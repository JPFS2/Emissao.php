<?php

namespace App\Models;

use CodeIgniter\Model;

class VendaCreditoNaLojaModel extends Model
{
    protected $table = 'vendas_credito_na_loja';
    protected $primaryKey = 'id_venda_credito_na_loja';
    protected $allowedFields = [
        'id_venda_credito_na_loja',
        'data',
        'hora',
        'valor_a_pagar',
        'id_venda',
        'id_cliente',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
