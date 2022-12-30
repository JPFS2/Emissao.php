<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicoMaoDeObraDoLaboratorioModel extends Model
{
    protected $table = 'servicos_mao_de_obra_do_laboratorio';
    protected $primaryKey = 'id_servico';
    protected $allowedFields = [
        'nome',
        'detalhes',
        'quantidade',
        'valor',
        'desconto',
        'id_laboratorio',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}