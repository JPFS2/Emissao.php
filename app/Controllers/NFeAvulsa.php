<?php

namespace App\Controllers;

use App\Models\CodigoDeBarraDoProdutoModel;
use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\TransportadoraModel;
use App\Models\UnidadeModel;
use App\Models\UfModel;
use App\Models\NFeAvulsaProdutoModel;
use App\Models\FormaDePagamentoModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\ProdutoModel;

use CodeIgniter\Controller;

class NFeAvulsa extends Controller
{
    private $link = [
        'li' => '9.x',
        'item' => '9.0'
    ];

    private $session;
    private $id_empresa;
    private $id_login;

    private $codigo_de_barra_do_produto_model;
    private $link_adicional_da_sidebar_model;
    private $transportadora_model;
    private $unidade_model;
    private $uf_model;
    private $nfe_avulsa_produto_model;
    private $controle_de_acesso_model;
    private $produto_model;
    private $forma_de_pagamento_model;

    function __construct()
    {
        $this->helpers = ['app'];

        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->codigo_de_barra_do_produto_model = new CodigoDeBarraDoProdutoModel();
        $this->link_adicional_da_sidebar_model  = new LinkAdicionalDaSidebarModel();
        $this->transportadora_model             = new TransportadoraModel();
        $this->unidade_model                    = new UnidadeModel();
        $this->uf_model                         = new UfModel();
        $this->nfe_avulsa_produto_model         = new NFeAvulsaProdutoModel();
        $this->controle_de_acesso_model         = new ControleDeAcessoDoUsuarioModel();
        $this->produto_model                    = new ProdutoModel();
        $this->forma_de_pagamento_model         = new FormaDePagamentoModel();
    }

    public function entrada()
    {
        $this->link['subItem'] = "9.1";

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'NFe Entrada - Avulsa',
            'icone'  => 'fa fa-money-bill-alt'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "NFe Entrada - Avulsa", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['produtos_do_estoque'] = $this->produto_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['formas_de_pagamento'] = $this->forma_de_pagamento_model
                                            // ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['produtos_da_nfe'] = $this->nfe_avulsa_produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        echo view('templates/header', $data);
        echo view('nfe_avulsa/entrada/index');
        echo view('templates/footer');
    }

    public function saida()
    {
        $this->link['subItem'] = "9.2";
        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'NFe Saída - Avulsa',
            'icone'  => 'fa fa-money-bill-alt'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "NFe Saída - Avulsa", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['produtos_do_estoque'] = $this->produto_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['formas_de_pagamento'] = $this->forma_de_pagamento_model
                                            // ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['produtos_da_nfe'] = $this->nfe_avulsa_produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        $data['ufs'] = $this->uf_model
                                ->findAll();

        $data['unidades'] = $this->unidade_model
                                        ->findAll();

        $data['transportadoras'] = $this->transportadora_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        echo view('templates/header', $data);
        echo view('nfe_avulsa/saida/index');
        echo view('templates/footer');
    }

    public function devolucao()
    {
        $this->link['subItem'] = "9.3";
        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'NFe Devolução - Avulsa',
            'icone'  => 'fa fa-money-bill-alt'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "NFe Devolução - Avulsa", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['produtos_do_estoque'] = $this->produto_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['formas_de_pagamento'] = $this->forma_de_pagamento_model
                                            // ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['produtos_da_nfe'] = $this->nfe_avulsa_produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        $data['ufs'] = $this->uf_model
                                ->findAll();

        $data['unidades'] = $this->unidade_model
                                        ->findAll();

        $data['transportadoras'] = $this->transportadora_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        echo view('templates/header', $data);
        echo view('nfe_avulsa/devolucao/index');
        echo view('templates/footer');
    }

    public function addProduto($tipo)
    {
        $dados = $this->request->getVar();

        // Tipo 1=entrada, 2=saida, 3=devolucao
        if($tipo == 1):
            $url = "/NFeAvulsa/entrada";
        elseif($tipo == 2):
            $url = "/NFeAvulsa/saida";
        elseif($tipo == 3):
            $url = "/NFeAvulsa/devolucao";
        endif;

        // Caso esteja pesquisando o produto por código de barras
        if($dados['codigo_de_barras'] != ""):


            
            $codigo_de_barra = $this->codigo_de_barra_do_produto_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('codigo_de_barra', $dados['codigo_de_barras'])
                                                    ->first();

            if(empty($codigo_de_barra)):

                $this->session->setFlashdata(
                    'alert',
                    [
                        'type'  => 'warning',
                        'title' => 'O Produto do código de barras informado não foi encontrado!'
                    ]
                );

                return redirect()->to($url);

            endif;

            $produto = $this->produto_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_produto', $codigo_de_barra['id_produto'])
                            ->first();

            $produto['codigo_de_barras'] = $codigo_de_barra['codigo_de_barra'];

        else:

            $produto = $this->produto_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_produto', $dados['id_produto'])
                            ->first();

            $aux = $this->codigo_de_barra_do_produto_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('id_produto', $produto['id_produto'])
                                                    ->first();

            if($aux == null):
                $produto['codigo_de_barras'] = "SEM GTIN";
            else:
                $produto['codigo_de_barras'] = $aux['codigo_de_barra'];
            endif;
        
        endif;

        $produto['quantidade'] = $dados['quantidade'];
        $produto['valor_unitario'] = $produto['valor_de_venda'];

        $produto['id_empresa'] = $this->id_empresa;

        $this->nfe_avulsa_produto_model
                            ->insert($produto);

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Produto adicionado com sucesso!'
            ]
        );

        return redirect()->to($url);
    }

    public function deleteProduto($id_produto_nfe_avulsa, $tipo)
    {
        $this->nfe_avulsa_produto_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_nfe_avulsa', $id_produto_nfe_avulsa)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Produto excluido com sucesso!'
            ]
        );

        // Tipo 1=entrada, 2=saida, 3=devolucao
        if($tipo == 1):
            $url = "/NFeAvulsa/entrada";
        elseif($tipo == 2):
            $url = "/NFeAvulsa/saida";
        elseif($tipo == 3):
            $url = "/NFeAvulsa/devolucao";
        endif;

        return redirect()->to($url);
    }

    public function alteraDadosFiscaisDoProduto()
    {
        $dados = $this->request->getVar();

        $this->nfe_avulsa_produto_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_nfe_avulsa', $dados['id_produto_nfe_avulsa'])
            ->set($dados)
            ->update();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Dados do Produto atualizados com sucesso!'
                ]
            );

        if(isset($dados['CFOP_Externo'])):
            return redirect()->to(base_url('NFeAvulsa/devolucao'));
        else:
            return redirect()->to(base_url('NFeAvulsa/entrada'));
        endif;
    }
}

?>