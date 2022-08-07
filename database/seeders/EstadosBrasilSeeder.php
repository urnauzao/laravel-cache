<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosBrasilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            [
                "nome" => "Acre",
                "capital" => "Rio Branco",
                "uf" => "AC",
            ],
            [
                "nome" => "Alagoas",
                "capital" => "Maceió",
                "uf" => "AL",
            ],
            [
                "nome" => "Amapá",
                "capital" => "Macapá",
                "uf" => "AP",
            ],
            [
                "nome" => "Amazonas",
                "capital" => "Manaus",
                "uf" => "AM",
            ],
            [
                "nome" => "Bahia",
                "capital" => "Salvador",
                "uf" => "BA",
            ],
            [
                "nome" => "Ceará",
                "capital" => "Fortaleza",
                "uf" => "CE",
            ],
            [
                "nome" => "Distrito Federal*",
                "capital" => "Brasília",
                "uf" => "DF",
            ],
            [
                "nome" => "Espírito Santo",
                "capital" => "Vitória",
                "uf" => "ES",
            ],
            [
                "nome" => "Goiás",
                "capital" => "Goiânia",
                "uf" => "GO",
            ],
            [
                "nome" => "Maranhão",
                "capital" => "São Luís",
                "uf" => "MA",
            ],
            [
                "nome" => "Mato Grosso",
                "capital" => "Cuiabá",
                "uf" => "MT",
            ],
            [
                "nome" => "Mato Grosso do Sul",
                "capital" => "Campo Grande",
                "uf" => "MS",
            ],
            [
                "nome" => "Minas Gerais",
                "capital" => "Belo Horizonte",
                "uf" => "MG",
            ],
            [
                "nome" => "Pará",
                "capital" => "Belém",
                "uf" => "PA",
            ],
            [
                "nome" => "Paraíba",
                "capital" => "João Pessoa",
                "uf" => "PB",
            ],
            [
                "nome" => "Paraná",
                "capital" => "Curitiba",
                "uf" => "PR",
            ],
            [
                "nome" => "Pernambuco",
                "capital" => "Recife",
                "uf" => "PE",
            ],
            [
                "nome" => "Piauí",
                "capital" => "Teresina",
                "uf" => "PI",
            ],
            [
                "nome" => "Rio de Janeiro",
                "capital" => "Rio de Janeiro",
                "uf" => "RJ",
            ],
            [
                "nome" => "Rio Grande do Norte",
                "capital" => "Natal",
                "uf" => "RN",
            ],
            [
                "nome" => "Rio Grande do Sul",
                "capital" => "Porto Alegre",
                "uf" => "RS",
            ],
            [
                "nome" => "Rondônia",
                "capital" => "Porto Velho",
                "uf" => "RO",
            ],
            [
                "nome" => "Roraima",
                "capital" => "Boa Vista",
                "uf" => "RR",
            ],
            [
                "nome" => "Santa Catarina",
                "capital" => "Florianópolis",
                "uf" => "SC",
            ],
            [
                "nome" => "São Paulo",
                "capital" => "São Paulo",
                "uf" => "SP",
            ],
            [
                "nome" => "Sergipe",
                "capital" => "Aracaju",
                "uf" => "SE",
            ],
            [
                "nome" => "Tocantins",
                "capital" => "Palmas",
                "uf" => "TO"
            ]
        ];

        DB::table('estados_brasil')->insert($estados);
    }
}
