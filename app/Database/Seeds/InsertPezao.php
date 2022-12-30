<?php

namespace App\Database\Seeds;

class InsertPezao extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        

        $this->db->table('fornecedores')->insert([
            'nome_do_representante' => "FORNCEDOR GERAL",
            'nome_da_empresa' => "",
            'cnpj' => "",
            'ie' => "",
            'cep' => "",
            'logradouro' => "",
            'numero' => "",
            'complemento' => "",
            'bairro' => "",
            'comercial' => "",
            'celular_1' => "",
            'celular_2' => "",
            'email' => "",
            'id_uf' => 17,
            'id_municipio' => 1,
            'id_empresa' => 1,
        ]);
    }
}
