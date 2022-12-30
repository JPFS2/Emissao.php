<?php

namespace App\Models;

use CodeIgniter\Model;

class CodigoDeBarraDoProdutoModel extends Model
{
    protected $table = 'codigos_de_barras_dos_produtos';
    protected $primaryKey = 'id_codigo';
    protected $allowedFields = [
        'id_codigo',
        'codigo_de_barra',
        'id_empresa',
        'id_produto',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
