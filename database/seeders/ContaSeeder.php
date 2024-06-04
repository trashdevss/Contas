<?php

namespace Database\Seeders;

use App\Models\Conta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if(!Conta::where('nome', 'Energia')->first()){
            Conta::create([
                'nome' => 'Energia',
                'valor' => '147.52',
                'vencimento' => '2024-01-23',
            ]);
        }

        if(!Conta::where('nome', 'Internet')->first()){
            Conta::create([
                'nome' => 'Internet',
                'valor' => '97.99',
                'vencimento' => '2024-01-23',
            ]);
        }

        if(!Conta::where('nome', 'Gás')->first()){
            Conta::create([
                'nome' => 'Gás',
                'valor' => '42.99',
                'vencimento' => '2024-01-15',
            ]);
        }

        if(!Conta::where('nome', 'Prestação A')->first()){
            Conta::create([
                'nome' => 'Prestação A',
                'valor' => '197.99',
                'vencimento' => '2024-01-10',
            ]);
        }

        if(!Conta::where('nome', 'Faculdade')->first()){
            Conta::create([
                'nome' => 'Faculdade',
                'valor' => '970.42',
                'vencimento' => '2024-01-15',
            ]);
        }

        if(!Conta::where('nome', 'Pós Graduação')->first()){
            Conta::create([
                'nome' => 'Pós Graduação',
                'valor' => '270.42',
                'vencimento' => '2024-01-30',
            ]);
        }

        if(!Conta::where('nome', 'Escola')->first()){
            Conta::create([
                'nome' => 'Escola',
                'valor' => '1220.42',
                'vencimento' => '2024-01-05',
            ]);
        }

        if(!Conta::where('nome', 'Prestação B')->first()){
            Conta::create([
                'nome' => 'Prestação B',
                'valor' => '220.42',
                'vencimento' => '2024-01-07',
            ]);
        }

        if(!Conta::where('nome', 'Academia')->first()){
            Conta::create([
                'nome' => 'Academia',
                'valor' => '120.00',
                'vencimento' => '2024-01-23',
            ]);
        }

        if(!Conta::where('nome', 'Cartão')->first()){
            Conta::create([
                'nome' => 'Cartão',
                'valor' => '420.00',
                'vencimento' => '2024-01-23',
            ]);
        }

        if(!Conta::where('nome', 'Condomínio')->first()){
            Conta::create([
                'nome' => 'Academia',
                'valor' => '120.00',
                'vencimento' => '2024-01-23',
            ]);
        }

    }
}
