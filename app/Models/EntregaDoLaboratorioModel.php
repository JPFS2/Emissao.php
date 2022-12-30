<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregaDoLaboratorioModel extends Model
{
    protected $table = 'entregas_do_laboratorio';
    protected $primaryKey = 'id_entrega';
    protected $allowedFields = [
        'id_entrega',
        'status',
        'data',
        'id_empresa',
        'id_laboratorio',
        'id_cliente',
        'id_entregador',
        'observacoes'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
}
