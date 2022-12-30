<?php

namespace App\Controllers;

use App\Models\ConfiguracaoModel;
use App\Models\PagamentoDaEmpresaModel;
use App\Models\EmpresaModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    private $link = [
        'li' => '4.x',
        'item' => '4.0'
    ];

    private $session;

    private $configuracao_model;
    private $pagamento_da_empresa_model;
    private $empresa_model;

    function __construct()
    {
        $this->session = session();

        $this->configuracao_model         = new ConfiguracaoModel();
        $this->pagamento_da_empresa_model = new PagamentoDaEmpresaModel();
        $this->empresa_model              = new EmpresaModel();
    }

    public function inicio()
    {
        $data['link'] = [
            'item' => '1'
        ];

        echo View('templates/header');
        echo View('admin/inicio', $data);
        echo View('templates/footer');
    }

    public function relatorioRelacaoDeEmpresas()
    {
        $this->link['subItem'] = '4.1';
        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'RELAÇÃO DE EMPRESAS',
            'icone'  => 'fa fa-book-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Caixas", 'rota' => "/caixas", 'active' => false],
            ['titulo' => "Dados", 'rota'   => "", 'active' => true]
        ];

        $data['empresas'] = $this->empresa_model
                                        ->findAll();

        $data['configuracao'] = $this->configuracao_model
                                    ->where('id_config', 1)
                                    ->first();

        echo view('templates/header');
        echo view('admin/relatorios/relacao_de_empresas', $data);
        echo view('templates/footer');
    }

    public function relatorioEmpresasAtivas()
    {
        $this->link['subItem'] = '4.2';
        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'RELAÇÃO DE EMPRESAS - ATIVAS',
            'icone'  => 'fa fa-book-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Caixas", 'rota' => "/caixas", 'active' => false],
            ['titulo' => "Dados", 'rota'   => "", 'active' => true]
        ];

        $data['empresas'] = $this->empresa_model
                                        ->where('status', 'Ativo')
                                        ->findAll();

        $data['configuracao'] = $this->configuracao_model
                                    ->where('id_config', 1)
                                    ->first();

        echo view('templates/header');
        echo view('admin/relatorios/relacao_de_empresas_ativas', $data);
        echo view('templates/footer');
    }

    public function relatorioEmpresasDesativadas()
    {
        $this->link['subItem'] = '4.3';
        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'RELAÇÃO DE EMPRESAS - DESATIVADAS',
            'icone'  => 'fa fa-book-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Caixas", 'rota' => "/caixas", 'active' => false],
            ['titulo' => "Dados", 'rota'   => "", 'active' => true]
        ];

        $data['empresas'] = $this->empresa_model
                                        ->where('status', 'Desativado')
                                        ->findAll();

        $data['configuracao'] = $this->configuracao_model
                                    ->where('id_config', 1)
                                    ->first();

        echo view('templates/header');
        echo view('admin/relatorios/relacao_de_empresas_desativadas', $data);
        echo view('templates/footer');
    }

    public function relatorioFaturamentoPorPeriodoDetalhado()
    {
        $this->link['subItem'] = '4.4';
        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'FATURAMENTO POR PERÍODO - DETALHADO',
            'icone'  => 'fa fa-book-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Caixas", 'rota' => "/caixas", 'active' => false],
            ['titulo' => "Dados", 'rota'   => "", 'active' => true]
        ];

        $data['configuracao'] = $this->configuracao_model
                                    ->where('id_config', 1)
                                    ->first();

        $dados = $this->request->getVar();

        if(empty($dados)):
            $dados['data_inicio'] = date('Y-m-d');
            $dados['data_final']  = date('Y-m-d');
        endif;

        $empresas = $this->empresa_model
                        ->findAll();

        // Adiciona o faturamento por periodo ao array da empresa
        $i=0;
        foreach($empresas as $empresa) :
            $faturamento_por_periodo = $this->pagamento_da_empresa_model
                                            ->where('id_empresa', $empresa['id_empresa'])
                                            ->where('data >=', $dados['data_inicio'])
                                            ->where('data <=', $dados['data_final'])
                                            ->selectSum('valor')
                                            ->first();

            $empresas[$i]['faturamento'] = $faturamento_por_periodo['valor'];

            $i +=1;
        endforeach;

        $data['empresas']    = $empresas;
        $data['data_inicio'] = $dados['data_inicio'];
        $data['data_final']  = $dados['data_final'];

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Relatório gerado com sucesso!'
            ]
        );

        echo view('templates/header');
        echo view('admin/relatorios/relatorio_pagamento_das_empresas_detalhado', $data);
        echo view('templates/footer');
    }

    public function relatorioVencimentoDeContrato()
    {
        $this->link['subItem'] = '4.5';
        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'VENCIMENTO DE CONTRATO',
            'icone'  => 'fa fa-book-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Caixas", 'rota' => "/caixas", 'active' => false],
            ['titulo' => "Dados", 'rota'   => "", 'active' => true]
        ];

        $data['configuracao'] = $this->configuracao_model
                                            ->where('id_config', 1)
                                            ->first();

        $dados = $this->request
                            ->getVar();

        if(!isset($dados['dias'])):
            $dados['dias'] = 30;
        endif;

        $data_aux = date('Y-m-d', strtotime("+{$dados['dias']} days", strtotime(date('Y-m-d'))));
                            
        $empresas = $this->empresa_model
                                    ->where('data_de_encerramento_do_contrato <=', $data_aux)
                                    ->findAll();

        $data['empresas'] = $empresas;
        $data['dias'] = $dados['dias'];

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Relatório gerado com sucesso!'
            ]
        );

        echo view('templates/header');
        echo view('admin/relatorios/vencimento_de_contrato', $data);
        echo view('templates/footer');
    }
}

?>