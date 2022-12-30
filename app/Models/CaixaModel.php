<?php

namespace App\Models;

use CodeIgniter\Model;

class CaixaModel extends Model
{
    protected $table = 'caixas';
    protected $primaryKey = 'id_caixa';
    protected $allowedFields = [
        'id_caixa',
        'data_de_abertura',
        'data_de_fechamento',
        'hora_de_abertura',
        'hora_de_fechamento',
        'valor_inicial',
        'valor_total',
        'valor_de_fechamento',
        'observacoes',
        'status',

        'quantidade_cedulas_de_200',
        'quantidade_cedulas_de_100',
        'quantidade_cedulas_de_50',
        'quantidade_cedulas_de_20',
        'quantidade_cedulas_de_10',
        'quantidade_cedulas_de_5',
        'quantidade_cedulas_de_2',
        'quantidade_1_real',
        'quantidade_50_centavos',
        'quantidade_25_centavos',
        'quantidade_10_centavos',
        'quantidade_5_centavos',

        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
