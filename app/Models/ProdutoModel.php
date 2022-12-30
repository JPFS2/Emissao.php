<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id_produto';
    protected $allowedFields = [
        'id_produto',
        'nome',
        'unidade',
        'localizacao',
        'quantidade',
        'quantidade_minima',
        'valor_de_custo',
        'margem_de_lucro',
        'valor_de_venda',
        'lucro',
        'NCM',
        'CSOSN',
        'CFOP_NFe',
        'CFOP_NFCe',
        'CFOP_Externo',
        'porcentagem_icms',
        'pis_cofins',
        'arquivo',
        'id_categoria',
        'id_fornecedor',
        'validade',
        
        'tipo_da_comissao',
        'porcentagem_comissao',
        'valor_comissao',
        'controlar_estoque',

        'id_contador',
        'id_empresa',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
