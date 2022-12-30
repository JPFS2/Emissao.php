<?php

namespace App\Models;

use CodeIgniter\Model;

class CreditoNaLojaModel extends Model
{
    protected $table = 'creditos_na_loja';
    protected $primaryKey = 'id_credito';
    protected $allowedFields = [
        'id_credito',
        'valor',
        'observacao',
        'data',
        'hora',
        'id_cliente',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
