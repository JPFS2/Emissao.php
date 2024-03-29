<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdemDeServicoProvisorioModel extends Model
{
    protected $table = 'ordens_de_servicos_provisorio';
    protected $primaryKey = 'id_ordem';
    protected $allowedFields = [
        'id_ordem',
        'situacao',
        'data_de_entrada',
        'hora_de_entrada',
        'data_de_saida',
        'hora_de_saida',
        'canal_de_venda',
        'centro_de_custo',
        'frete',
        'outros',
        'desconto',
        'observacoes',
        'observacoes_internas',
        'id_cliente',
        'id_vendedor',
        'id_tecnico',
        'id_contador',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}