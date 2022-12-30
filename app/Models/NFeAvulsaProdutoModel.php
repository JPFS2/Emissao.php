<?php

namespace App\Models;

use CodeIgniter\Model;

class NFeAvulsaProdutoModel extends Model
{
    protected $table = 'nfe_avulsa_produtos';
    protected $primaryKey = 'id_produto_nfe_avulsa';
    protected $allowedFields = [
        'id_produto_nfe_avulsa',
        'nome',
        'unidade',
        'codigo_de_barras',
        'quantidade',
        'valor_unitario',
        'desconto',
        'NCM',
        'CSOSN',
        'CFOP_NFe',
        'CFOP_NFCe',
        'CFOP_Externo',
        'id_produto',
        'id_empresa',
    ];
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}