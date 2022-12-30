<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdemDeServicoModel extends Model
{
    protected $table = 'ordens_de_servicos';
    protected $primaryKey = 'id_ordem';
    protected $allowedFields = [
        'id_ordem',
        'frete',
        'outros',
        'desconto',
        'situacao',
        'data_de_entrada',
        'hora_de_entrada',
        'data_de_saida',
        'hora_de_saida',
        'canal_de_venda',
        'forma_de_pagamento',
        'endereco_de_entrega',
        'observacoes',
        'observacoes_internas',
        'id_cliente',
        'id_vendedor',
        'id_tecnico',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}