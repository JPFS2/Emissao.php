<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanoModel extends Model
{
    protected $table = 'planos';
    protected $primaryKey = 'id_plano';
    protected $allowedFields = [
        'id_plano',
        'nome',
        'valor',
        'duracao',
        'observacoes',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
