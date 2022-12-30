<?php

namespace App\Models;

use CodeIgniter\Model;

class NFeAvulsaModel extends Model
{
    protected $table = 'nfes_avulsa';
    protected $primaryKey = 'id_nfe';
    protected $allowedFields = [
        'id_nfe',
        'status',
        'chave',
        'xml',
        'protocolo',
        'erro',
        'numero_da_nota',
        'valor_da_nota',
        'data',
        'hora',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}