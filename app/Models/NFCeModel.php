<?php

namespace App\Models;

use CodeIgniter\Model;

class NFCeModel extends Model
{
    protected $table = 'nfces';
    protected $primaryKey = 'id_nfce';
    protected $allowedFields = [
        'id_nfce',
        'status',
        'chave',
        'xml',
        'protocolo',
        'erro',
        'numero_da_nota',
        'valor_da_nota',
        'data',
        'hora',
        'id_venda',
        'id_cliente',
        'id_contador',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}