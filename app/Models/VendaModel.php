<?php

namespace App\Models;

use CodeIgniter\Model;

class VendaModel extends Model
{
    protected $table = 'vendas';
    protected $primaryKey = 'id_venda';
    protected $allowedFields = [
        'id_venda',
        'valor_a_pagar',
        'valor_recebido',
        'troco',
        'data',
        'hora',

        'id_cliente',
        'id_vendedor',
        'id_caixa',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
