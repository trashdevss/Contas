@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mb-4 border-light shadow-card">
        <div class="card-header d-flex justify-content-between shadow-header">
            <span>Visualizar Conta</span>
            <span>
                <a href="{{ route('conta.index') }}" class="btn btn-info btn-sm">Listar</a>
                <a href="{{ route('conta.edit', ['conta' => $conta->id]) }}" class="btn btn-warning btn-sm">Editar</a>
            </span>
        </div>

        {{-- Verificar se existe a sessão success e imprimir o valor --}}
        <x-alert />

        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $conta->id }}</dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9">{{ $conta->nome }}</dd>

                <dt class="col-sm-3">Valor</dt>
                <dd class="col-sm-9">{{ 'R$ ' . number_format($conta->valor, 2, ',', '.') }}</dd>

                <dt class="col-sm-3">Vencimento</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($conta->vencimento)->tz('America/Sao_Paulo')->format('d/m/Y') }}</dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <a href="{{ route('conta.change-situation', [ 'conta' => $conta->id])}}">
                        {!! '<span class="badge text-bg-'. $conta->situacaoConta->cor .'">' . $conta->situacaoConta->nome . '</span>' !!}
                    </a>
                </dd>

                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($conta->created_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</dd>

                <dt class="col-sm-3">Editado</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($conta->updated_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</dd>
            </dl>
        </div>
    </div>
@endsection

<style>
    .shadow-card {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .shadow-header {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-radius: 10px 10px 0 0;
        background-color: white;
    }
</style>
