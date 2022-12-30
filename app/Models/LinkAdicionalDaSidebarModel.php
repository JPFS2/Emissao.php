<?php

namespace App\Models;

use CodeIgniter\Model;

class LinkAdicionalDaSidebarModel extends Model
{
    protected $table = 'links_adicionais_da_sidebar';
    protected $primaryKey = 'id_link';
    protected $allowedFields = [
        'id_link',
        'link',
        'descricao',
        'icone',
        'tipo',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
