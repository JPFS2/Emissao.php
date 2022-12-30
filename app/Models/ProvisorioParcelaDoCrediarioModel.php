<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvisorioParcelaDoCrediarioModel extends Model
{
    protected $table = 'provisorio_parcelas_do_crediario';
    protected $primaryKey = 'id_parcela';
    protected $allowedFields = [
        'id_parcela',
        'nome',
        'data_de_vencimento',
        'valor',
        'observacoes',
        'id_empresa',
        'id_venda',
        'id_cliente',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
