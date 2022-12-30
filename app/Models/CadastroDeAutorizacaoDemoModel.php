<?php

namespace App\Models;

use CodeIgniter\Model;

class CadastroDeAutorizacaoDemoModel extends Model
{
    protected $table = 'cadastro_de_autorizacao_demo';
    protected $primaryKey = 'id_autorizacao';
    protected $allowedFields = [
        'id_autorizacao',
        'nome',
        'telefone',
        'email',
        'data_de_cadastro',
        'hora_de_cadastro',
        'id_uf',
        'id_municipio',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}