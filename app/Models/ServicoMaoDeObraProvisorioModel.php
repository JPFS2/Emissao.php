<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicoMaoDeObraProvisorioModel extends Model
{
    protected $table = 'servicos_mao_de_obra_provisorio';
    protected $primaryKey = 'id_servico';
    protected $allowedFields = [
        'id_servico',
        'nome',
        'detalhes',
        'quantidade',
        'valor',
        'desconto',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}