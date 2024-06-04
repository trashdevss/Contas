<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use App\Models\Conta;
use App\Models\SituacaoConta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\PhpWord;

class ContaController extends Controller
{
    
    public function index(Request $request)
    {

     
        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request) {
            $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
            ->when($request->filled('data_inicio'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
            })
            ->when($request->filled('data_fim'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
            })
            ->with('situacaoConta')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

     
        return view('contas.index', [
            'contas' => $contas,
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
        ]);
    }


    public function show(Conta $conta)
    {

     
        return view('contas.show', ['conta' => $conta]);
    }


    public function create()
    {
       
        $situacoesContas = SituacaoConta::orderBy('nome', 'asc')->get();

        return view('contas.create', [
            'situacoesContas' => $situacoesContas,
        ]);
    }

  
    public function store(ContaRequest $request)
    {

       
        $request->validated();

        try {

            
            $conta = Conta::create([
                'nome' => $request->nome,
                'valor' => str_replace(',', '.', str_replace('.', '', $request->valor)),
                'vencimento' => $request->vencimento,
                'situacao_conta_id' => $request->situacao_conta_id,
            ]);

           
            return redirect()->route('conta.show', ['conta' => $conta->id])->with('success', 'Conta cadastrada com sucesso');
        } catch (Exception $e) {

     
            Log::warning('Conta não cadastrada', ['error' => $e->getMessage()]);

         
            return back()->withInput()->with('error', 'Conta não cadastrada!');
        }
    }


    public function edit(Conta $conta)
    {
     
        $situacoesContas = SituacaoConta::orderBy('nome', 'asc')->get();

  
        return view('contas.edit', [
            'conta' => $conta,
            'situacoesContas' => $situacoesContas,
        ]);
    }

    public function update(ContaRequest $request, Conta $conta)
    {
 
        $request->validated();

        try {

            $conta->update([
                'nome' => $request->nome,
                'valor' => str_replace(',', '.', str_replace('.', '', $request->valor)),
                'vencimento' => $request->vencimento,
                'situacao_conta_id' => $request->situacao_conta_id,
            ]);

          
            Log::info('Conta editado com sucesso', ['id' => $conta->id, 'conta' => $conta]);

            
            return redirect()->route('conta.show', ['conta' => $conta->id])->with('success', 'Conta editada com sucesso');
        } catch (Exception $e) {

      
            Log::warning('Conta não editada', ['error' => $e->getMessage()]);

       
            return back()->withInput()->with('error', 'Conta não editada!');
        }
    }

   
    public function destroy(Conta $conta)
    {

        
        $conta->delete();

        return redirect()->route('conta.index')->with('success', 'Conta apagada com sucesso');
    }

  
    public function gerarPdf(Request $request)
    {


        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request) {
            $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
            ->when($request->filled('data_inicio'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
            })
            ->when($request->filled('data_fim'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
            })
            ->orderByDesc('created_at')
            ->get();

       
        $totalValor = $contas->sum('valor');

      
        $pdf = PDF::loadView('contas.gerar-pdf', [
            'contas' => $contas,
            'totalValor' => $totalValor
        ])->setPaper('a4', 'portrait');

  
        return $pdf->download('listar_contas.pdf');
    }


    public function changeSituation(Conta $conta)
    {

        try {

      
            $conta->update([
                'situacao_conta_id' => $conta->situacao_conta_id == 1 ? 2 : 1,
            ]);

            
            Log::info('Situação da conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta]);

            
            return back()->with('success', 'Situação da conta editada com sucesso!');
        } catch (Exception $e) {

           
            Log::warning('Situação da conta não editada', ['error' => $e->getMessage()]);

            
            return back()->with('error', 'Situação da conta não editada!');
        }
    }

    
    public function gerarCsv(Request $request)
    {

        
        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request) {
            $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
            ->when($request->filled('data_inicio'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
            })
            ->when($request->filled('data_fim'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
            })
            ->with('situacaoConta')
            ->orderBy('vencimento')
            ->get();

        
        $totalValor = $contas->sum('valor');

        
        $csvNomeArquivo = tempnam(sys_get_temp_dir(), 'csv_' . Str::ulid());

      
        $arquivoAberto = fopen($csvNomeArquivo, 'w');

       
        $cabecalho = ['id', 'Nome', 'Vencimento', mb_convert_encoding('Situação', 'ISO-8859-1', 'UTF-8'), 'Valor'];

      
        fputcsv($arquivoAberto, $cabecalho, ';');

      
        foreach ($contas as $conta) {

       
            $contaArray = [
                'id' => $conta->id,
                'nome' => mb_convert_encoding($conta->nome, 'ISO-8859-1', 'UTF-8'),
                'vencimento' => $conta->vencimento,
                'situacao' => mb_convert_encoding($conta->situacaoConta->nome, 'ISO-8859-1', 'UTF-8'),
                'valor' => number_format($conta->valor, 2, ',', '.'),
            ];

            
            fputcsv($arquivoAberto, $contaArray, ';');
        }

        $rodape = ['', '', '', '', number_format($totalValor, 2, ',', '.')];


        fputcsv($arquivoAberto, $rodape, ';');

  
        fclose($arquivoAberto);

   
        return response()->download($csvNomeArquivo, 'relatorio_contas_' . Str::ulid() . '.csv');
    }

    public function gerarWord(Request $request)
    {


        $contas = Conta::when($request->has('nome'), function ($whenQuery) use ($request) {
            $whenQuery->where('nome', 'like', '%' . $request->nome . '%');
        })
            ->when($request->filled('data_inicio'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
            })
            ->when($request->filled('data_fim'), function ($whenQuery) use ($request) {
                $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
            })
            ->with('situacaoConta')
            ->orderBy('vencimento')
            ->get();


        $totalValor = $contas->sum('valor');

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        $table = $section->addTable();


        $borderStyle = [
            'borderColor' => '000000',
            'borderSize' => 6,
        ];

     
        $table->addRow();
        $table->addCell(2000, $borderStyle)->addText("id");
        $table->addCell(2000, $borderStyle)->addText("Nome");
        $table->addCell(2000, $borderStyle)->addText("Vencimento");
        $table->addCell(2000, $borderStyle)->addText("Situação");
        $table->addCell(2000, $borderStyle)->addText("Valor");

        
        foreach ($contas as $conta) {

            $table->addRow();
            $table->addCell(2000, $borderStyle)->addText($conta->id);
            $table->addCell(2000, $borderStyle)->addText($conta->nome);
            $table->addCell(2000, $borderStyle)->addText(Carbon::parse($conta->vencimento)->format('d/m/Y'));
            $table->addCell(2000, $borderStyle)->addText($conta->situacaoConta->nome);
            $table->addCell(2000, $borderStyle)->addText(number_format($conta->valor, 2, ',', '.'));
        }

    
        $table->addRow();
        $table->addCell(2000)->addText('');
        $table->addCell(2000)->addText('');
        $table->addCell(2000)->addText('');
        $table->addCell(2000)->addText('');
        $table->addCell(2000, $borderStyle)->addText(number_format($totalValor, 2, ',', '.'));
    
        $filename = 'relatorio_contas_.docx';

        $savePath = storage_path($filename);

        $phpWord->save($savePath);
    
        return response()->download($savePath)->deleteFileAfterSend(true);
    }
}
