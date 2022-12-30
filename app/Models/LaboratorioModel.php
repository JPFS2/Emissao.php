<?php

namespace App\Models;

use CodeIgniter\Model;

class LaboratorioModel extends Model
{
    protected $table = 'laboratorio';
    protected $primaryKey = 'id_laboratorio';
    protected $allowedFields = [
        'id_laboratorio',
        'dentes_do_maxilar',
        'dentes_da_mandibula',
        'data_de_entrada',
        'data_prevista',
        'cor_do_dente',
        'caixa',
        'paciente',
        'observacoes',
        'id_cliente',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
