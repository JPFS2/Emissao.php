<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaDePagamentoDaVendaModel extends Model
{
    protected $table = 'formas_de_pagamento_da_venda';
    protected $primaryKey = 'id_forma_de_pagamento';
    protected $allowedFields = [
        'id_forma_de_pagamento',
        'valor',
        'id_empresa',
        'id_forma',
        'id_venda'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}