<?php

namespace App\Controllers;

use App\Models\CodigoDeBarraDoProdutoModel;
use App\Models\FormaDePagamentoModel;
use App\Models\CaixaModel;
use App\Models\ProdutoModel;
use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\FormaDePagamentoDaVendaModel;
use App\Models\UnidadeModel;
use App\Models\TransportadoraModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\EmpresaModel;
use App\Models\VendedorModel;
use App\Models\ClienteModel;
use App\Models\NFeModel;
use App\Models\NFCeModel;
use App\Models\ProdutoDaVendaModel;
use App\Models\VendaModel;

use CodeIgniter\Controller;

class Vendas extends Controller
{
    private $link = [
        'li' => '2.x',
        'item' => '2.0',
        'subItem' => '2.3'
    ];
    
    private $session;
    private $id_empresa;
    private $id_login;

    private $codigo_de_barra_do_produto_model;
    private $forma_de_pagamento_model;
    private $caixa_model;
    private $produto_model;
    private $link_adicional_da_sidebar_model;
    private $forma_de_pagamento_da_venda_model;
    private $unidade_model;
    private $transportadora_model;
    private $controle_de_acesso_model;
    private $empresa_model;
    private $vendedor_model;
    private $venda_model;
    private $produtos_da_venda;
    private $nfe_model;
    private $nfce_model;
    private $cliente_model;

    private $permissao;

    function __construct()
    {
        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->helpers = ['app'];

        $this->codigo_de_barra_do_produto_model  = new CodigoDeBarraDoProdutoModel();
        $this->forma_de_pagamento_model          = new FormaDePagamentoModel();
        $this->caixa_model                       = new CaixaModel();
        $this->produto_model                     = new ProdutoModel();
        $this->link_adicional_da_sidebar_model   = new LinkAdicionalDaSidebarModel();
        $this->forma_de_pagamento_da_venda_model = new FormaDePagamentoDaVendaModel();
        $this->unidade_model                     = new UnidadeModel();
        $this->transportadora_model              = new TransportadoraModel();
        $this->controle_de_acesso_model          = new ControleDeAcessoDoUsuarioModel();
        $this->empresa_model                     = new EmpresaModel();
        $this->vendedor_model                    = new VendedorModel();
        $this->venda_model                       = new VendaModel();
        $this->produtos_da_venda                 = new ProdutoDaVendaModel();
        $this->nfe_model                         = new NFeModel();
        $this->nfce_model                        = new NFCeModel();
        $this->cliente_model                     = new ClienteModel();

        $this->permissao = $this->controle_de_acesso_model->verificaPermissao('historico_de_vendas');
    }

    public function index()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;
        
        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'Vendas',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Vendas", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $vendas = $this->venda_model
                        ->where('vendas.id_empresa', $this->id_empresa)
                        ->join('clientes', 'vendas.id_cliente = clientes.id_cliente')
                        ->orderBy('vendas.id_venda', 'ASC')
                        ->find();

        $novo_array_vendas = [];

        // Percorre as vendas, caso tenha uma nota fiscal para essa venda
        // adiciona o id_nfe no array
        foreach($vendas as $venda):
            // VERIFICA SE FOI EMITIDA NFE
            $nfe = $this->nfe_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_venda', $venda['id_venda'])
                        ->select('id_nfe')
                        ->first();

            if(!empty($nfe)):
                $venda['id_nfe'] = $nfe['id_nfe'];
            endif;

            // VERIFICA SE FOI EMITIDA NFCE
            $nfce = $this->nfce_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_venda', $venda['id_venda'])
                        ->select('id_nfce')
                        ->first();

            if(!empty($nfce)):
                $venda['id_nfce'] = $nfce['id_nfce'];
            endif;

            $novo_array_vendas[] = $venda;
        endforeach;

        
        // Seta o novo array para mostrar no Show
        $data['vendas'] = $novo_array_vendas;
        // dd($data['vendas']);

        echo view('templates/header', $data);
        echo view('vendas/index');
        echo view('templates/footer');
    }

    public function show($id_venda)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Dados da Venda',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Vendas", 'rota' => "/vendas", 'active' => false],
            ['titulo' => "Ver Dados", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['empresa'] = $this->empresa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
                                ->first();

        $data['venda'] = $this->venda_model
                                ->where('vendas.id_empresa', $this->id_empresa)
                                ->where('id_venda', $id_venda)
                                ->join('clientes', 'vendas.id_cliente = clientes.id_cliente')
                                ->first();

        // Adiciona um elemento 'nome_do_cliente' e 'nome_do_vendedor' ao array associativo vendas
        $data['venda']['nome_do_cliente'] = $this->cliente_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->where('id_cliente', $data['venda']['id_cliente'])
                                                ->first()['nome'];

        $data['venda']['nome_do_vendedor'] = $this->vendedor_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->where('id_vendedor', $data['venda']['id_vendedor'])
                                                ->first()['nome'];
        
        $data['produtos_da_venda'] = $this->produtos_da_venda
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_venda', $id_venda)
                                        ->findAll();

        // $data['config_nfe_nfce'] = $this->config_nfe_nfce_model
        //                                 ->where('id_config', 1)
        //                                 ->first();

        $data['transportadoras'] = $this->transportadora_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        $data['unidades'] = $this->unidade_model
                                        ->findAll();

        $data['nfe_da_venda'] = $this->nfe_model
                                    ->where('id_venda', $id_venda)
                                    ->first();

        $data['nfce_da_venda'] = $this->nfce_model
                                        ->where('id_venda', $id_venda)
                                        ->first();

        $data['id_venda'] = $id_venda;

        // Verifica se foi emitida NFe se sim então envia o id_nfe
        $nfe = $this->nfe_model
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_venda', $id_venda)
                    ->first();

        if(!empty($nfe)) :
            $data['id_nfe'] = $nfe['id_nfe'];
        endif;

        // Verifica se foi emitida NFCe se sim então envia o id_nfe
        $nfce = $this->nfce_model
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_venda', $id_venda)
                    ->first();

        if(!empty($nfce)) :
            $data['id_nfce'] = $nfce['id_nfce'];
        endif;

        $data['formas_de_pagamento_da_venda'] = $this->forma_de_pagamento_da_venda_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('id_venda', $id_venda)
                                                    ->join(
                                                        'formas_de_pagamento',
                                                        'formas_de_pagamento_da_venda.id_forma = formas_de_pagamento.id_forma'
                                                    )
                                                    ->findAll();

        echo view('templates/header', $data);
        echo view('vendas/show');
        echo view('templates/footer');
    }

    public function delete($id_venda)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $produtos_da_venda = $this->produtos_da_venda
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_venda', $id_venda)
                                            ->findAll();

        foreach($produtos_da_venda as $produto):
            $produto_do_estoque = $this->produto_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->where('id_produto', $produto['id_produto'])
                                                ->first();

            $nova_quantidade = $produto['quantidade'] + $produto_do_estoque['quantidade'];

            $this->produto_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto', $produto['id_produto'])
                        ->set('quantidade', $nova_quantidade)
                        ->update();
        endforeach;
        
        $this->venda_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_venda', $id_venda)
            ->delete();

        // Cria um alert na sessão
        $this->session->setFlashdata(
            'alert', 
            [
                'type'  => 'success',
                'title' => 'Venda excluida com sucesso!',
            ]
        );

        return redirect()->to('/vendas');
    }

    public function edit($id_venda)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Editar Venda',
            'icone'  => 'fa fa-money-bill-alt'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Vendas", 'rota' => "/vendas", 'active' => false],
            ['titulo' => "Editar", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();
        // ---------------------------- //

        $data['caixas'] = $this->caixa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('status', "Aberto")
                                ->findAll();

        $data['produtos_do_estoque'] = $this->produto_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['clientes'] = $this->cliente_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();
        
        $data['produtos_da_venda'] = $this->produtos_da_venda
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->where('id_venda', $id_venda)
                                                        ->findAll();

        $valor_da_venda = $this->produtos_da_venda
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_venda', $id_venda)
                                        ->selectSum('valor_final')
                                        ->first();

        $data['formas_de_pagamento'] = $this->forma_de_pagamento_model
                                            // ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['formas_de_pagamento_da_venda'] = $this->forma_de_pagamento_da_venda_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->where('id_venda', $id_venda)
                                                            ->join(
                                                                'formas_de_pagamento', 
                                                                'formas_de_pagamento_da_venda.id_forma = formas_de_pagamento.id_forma'
                                                            )
                                                            ->findAll();

        $somatorio_formas_de_pagamento = $this->forma_de_pagamento_da_venda_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('id_venda', $id_venda)
                                                    ->selectSum('valor')
                                                    ->first()['valor'];

        // Calcula troco
        $troco = $somatorio_formas_de_pagamento - $valor_da_venda['valor_final'];

        if($troco < 0):
            $troco = 0;
        endif;

        // Calcula restante
        $restante = $valor_da_venda['valor_final'] - $somatorio_formas_de_pagamento;

        if($restante < 0):
            $restante = 0;
        endif;

        $data['vendedores'] = $this->vendedor_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('status', "Ativo")
                                    ->find();

        $venda = $this->venda_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_venda', $id_venda)
                                ->first();

        $data['cliente_da_venda'] = $this->cliente_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_cliente', $venda['id_cliente'])
                                            ->first();

        $data['vendedor_da_venda'] = $this->vendedor_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('id_vendedor', $venda['id_vendedor'])
                                                    ->first();

        $data['caixa_da_venda'] = $this->caixa_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->where('id_caixa', $venda['id_caixa'])
                                                ->first();

        // Mandar para view
        $data['valor_da_venda'] = $valor_da_venda;
        $data['somatorio_formas_de_pagamento'] = $somatorio_formas_de_pagamento;

        $data['troco'] = $troco;
        $data['restante'] = $restante;

        $data['id_venda'] = $id_venda;

        $data['venda'] = $venda;

        echo view('templates/header', $data);
        echo view('vendas/form');
        echo view('templates/footer');
    }

    public function storeEditVenda($id_venda)
    {
        $dados = $this->request
                            ->getVar();

        // ---------- Calcula valor a pagar
        $produtos_da_venda = $this->produtos_da_venda
                                                ->where('id_empresa', $this->id_empresa)
                                                ->where('id_venda', $id_venda)
                                                ->findAll();

        $valor_a_pagar = 0;
        foreach($produtos_da_venda as $produto):
            $valor_a_pagar += (($produto['quantidade'] * $produto['valor_unitario']) - $produto['desconto']);
        endforeach;

        // ---------- Calcula valor recebido
        $valor_recebido = $this->forma_de_pagamento_da_venda_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->where('id_venda', $id_venda)
                                                        ->selectSum('valor')
                                                        ->first()['valor'];

        // --------- Calcula troco
        $troco = $valor_recebido - $valor_a_pagar;

        // ------------------- //
        $dados['valor_a_pagar']  = $valor_a_pagar;
        $dados['valor_recebido'] = $valor_recebido;
        $dados['troco'] = $troco;

        $this->venda_model
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_venda', $id_venda)
                    ->set($dados)
                    ->update();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Venda editada com sucesso!' 
                ]
            );

        return redirect()->to(base_url("vendas/show/$id_venda"));
    }

    // -------------------------- EDITAR VENDAS -------------------------------------- //

    // ------ PRODUTO ------- //
    public function addProdutoDaVenda($id_venda)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request
                            ->getvar();

        // Caso codigo_de_barras for igual a nada "" então o usuário selecionou um produto
        if($dados['codigo_de_barras'] == "")
        {
            $produto = $this->produto_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_produto', $dados['id_produto'])
                            ->first();

            if($dados['quantidade'] > $produto['quantidade']):
                if($produto['controlar_estoque'] == 1): // 1=Controlar Estoque
                    
                    $this->session
                        ->setFlashdata(
                            'alert',
                            [
                                'type'  => 'warning',
                                'title' => 'A quantidade escolhida não tem em estoque. Por favor escolha uma quantidade valida!'
                            ]
                        );

                    return redirect()->to('vendaRapida');

                endif;
            endif;

            $aux = $this->codigo_de_barra_do_produto_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('id_produto', $produto['id_produto'])
                                                    ->first();

            if($aux == null): // codigo_de_barras=null, não foi cadastrado nenhum
                $codigo_de_barra = "SEM GTIN";
            else:
                $codigo_de_barra = $aux['codigo_de_barra'];
            endif;

            $this->produtos_da_venda
                ->insert([
                    'nome'                  => $produto['nome'],
                    'unidade'               => $produto['unidade'],
                    'codigo_de_barras'      => $codigo_de_barra,
                    'quantidade'            => $dados['quantidade'],
                    'valor_unitario'        => $produto['valor_de_venda'],
                    'subtotal'              => $dados['quantidade'] * $produto['valor_de_venda'],
                    'desconto'              => 0,
                    'valor_final'           => $dados['quantidade'] * $produto['valor_de_venda'],
                    'tipo_da_comissao'      => $produto['tipo_da_comissao'],
                    'porcentagem_comissao'  => $produto['porcentagem_comissao'],
                    'valor_comissao'        => $produto['valor_comissao'],
                    'NCM'                   => $produto['NCM'],
                    'CSOSN'                 => $produto['CSOSN'],
                    'CFOP_NFe'              => $produto['CFOP_NFe'],
                    'CFOP_NFCe'             => $produto['CFOP_NFCe'],
                    'CFOP_Externo'          => $produto['CFOP_Externo'],
                    'porcentagem_icms'      => $produto['porcentagem_icms'],
                    'pis_cofins'            => $produto['pis_cofins'],
                    'lucro'                 => $produto['lucro'],
                    'id_produto'            => $produto['id_produto'],
                    'id_empresa'            => $this->id_empresa,
                    'id_venda'              => $id_venda
                ]); 

            $this->session->setFlashdata(
                'alert', 
                [
                    'type'  => 'success',
                    'title' => 'Produto adicionado com sucesso!',
                ]
            );
        }
        else // Senão ele digitou um codigo_de_barras
        {
            // Primeiro procura o código de barra no banco
            $codigo_de_barra = $this->codigo_de_barra_do_produto_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('codigo_de_barra', $dados['codigo_de_barras'])
                                                    ->first();

            if(!empty($codigo_de_barra)) // Caso código de barra não seja vazio então existe um produto
            {
                // Pega o produto de acordo com o id que está no array do código de barras
                $produto = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto', $codigo_de_barra['id_produto'])
                                        ->first();

                if ($dados['quantidade'] > $produto['quantidade']) :
                    if ($produto['controlar_estoque'] == 1) : // 1=Controlar Estoque

                        $this->session
                            ->setFlashdata(
                                'alert',
                                [
                                    'type'  => 'warning',
                                    'title' => 'A quantidade escolhida não tem em estoque. Por favor escolha uma quantidade valida!'
                                ]
                            );

                        return redirect()->to('vendaRapida');

                    endif;
                endif;

                // Faz a insersão como produto da venda
                $this->produtos_da_venda->insert([
                    'nome'                  => $produto['nome'],
                    'unidade'               => $produto['unidade'],
                    'codigo_de_barras'      => $codigo_de_barra['codigo_de_barra'],
                    'quantidade'            => $dados['quantidade'],
                    'valor_unitario'        => $produto['valor_de_venda'],
                    'subtotal'              => $dados['quantidade'] * $produto['valor_de_venda'],
                    'desconto'              => 0,
                    'valor_final'           => $dados['quantidade'] * $produto['valor_de_venda'],
                    'tipo_da_comissao'      => $produto['tipo_da_comissao'],
                    'porcentagem_comissao'  => $produto['porcentagem_comissao'],
                    'valor_comissao'        => $produto['valor_comissao'],
                    'NCM'                   => $produto['NCM'],
                    'CSOSN'                 => $produto['CSOSN'],
                    'CFOP_NFe'              => $produto['CFOP_NFe'],
                    'CFOP_NFCe'             => $produto['CFOP_NFCe'],
                    'CFOP_Externo'          => $produto['CFOP_Externo'],
                    'porcentagem_icms'      => $produto['porcentagem_icms'],
                    'pis_cofins'            => $produto['pis_cofins'],
                    'lucro'                 => $produto['lucro'],
                    'id_produto'            => $produto['id_produto'],
                    'id_empresa'            => $this->id_empresa,
                    'id_venda'              => $id_venda
                ]);

                $this->session->setFlashdata(
                'alert', 
                    [
                        'type'  => 'success',
                        'title' => 'Produto adicionado com sucesso!',
                    ]
                );
            }
            else // Produto com o codigo_de_barras não encontrado
            {
                $this->session->setFlashdata(
                    'alert', 
                    [
                        'type'  => 'warning',
                        'title' => 'Produto com código de barras não encontrado!',
                    ]
                );
            }
        }

        return redirect()->to(base_url("vendas/edit/$id_venda"));
    }

    public function deleteProduto($id_produto_da_venda, $id_venda)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $this->produtos_da_venda
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_produto_da_venda', $id_produto_da_venda)
                            ->delete();

        // Cria um alert na sessão
        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Produto excluido com sucesso!',
            ]
        );

        return redirect()->to(base_url("vendas/edit/$id_venda"));
    }

    public function atualizarProdutoDaVenda($id_venda)
    {
        $dados = $this->request
                            ->getVar();

        // Converte de BRL para USD
        $dados['valor_unitario'] = converteMoney($dados['valor_unitario']);
        $dados['desconto']       = converteMoney($dados['desconto']);

        // ---------- Calcula subtotal, valor final
        $subtotal    = $dados['quantidade'] * $dados['valor_unitario'];
        $valor_final = $subtotal - $dados['desconto'];

        $dados['subtotal'] = $subtotal;
        $dados['valor_final'] = $valor_final;

        $this->produtos_da_venda
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_venda', $id_venda)
                            ->where('id_produto_da_venda', $dados['id_produto_da_venda'])
                            ->set($dados)
                            ->update();

        return redirect()->to(base_url("vendas/edit/$id_venda"));
    }

    // ------ FORMA DE PAGAMENTO ------ //
    public function createFormaDePagamento()
    {
        $dados = $this->request
                            ->getVar();

        // Converte BRL para USD
        $dados['valor'] = converteMoney($dados['valor']);

        // Adiciona id_empresa ao array
        $dados['id_empresa'] = $this->id_empresa;

        $this->forma_de_pagamento_da_venda_model
                                        ->insert($dados);

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Forma de Pagamento adicionada com sucesso!'
                ]
            );

        echo 1;
    }

    public function deleteFormaDePagamentoDaVenda($id_forma_de_pagamento, $id_venda)
    {
        $this->forma_de_pagamento_da_venda_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_forma_de_pagamento', $id_forma_de_pagamento)
            ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Forma de Pagamento excluida com sucesso!'
                ]
            );

        return redirect()->to(base_url("vendas/edit/$id_venda"));
    }
}