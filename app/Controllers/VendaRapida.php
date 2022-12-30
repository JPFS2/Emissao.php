<?php

namespace App\Controllers;

use App\Models\ContaReceberModel;
use App\Models\ProvisorioParcelaDoCrediarioModel;
use App\Models\CodigoDeBarraDoProdutoModel;
use App\Models\FormaDePagamentoDoPedidoModel;
use App\Models\FormaDePagamentoDoOrcamentoModel;
use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\CreditoNaLojaModel;
use App\Models\VendaCreditoNaLojaModel;
use App\Models\FormaDePagamentoDaVendaModel;
use App\Models\FormaDePagamentoDaVendaRapidaModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\CaixaModel;
use App\Models\ClienteModel;
use App\Models\FormaDePagamentoModel;
use App\Models\OrcamentoModel;
use App\Models\PedidoModel;
use App\Models\ProdutoDaVendaModel;
use App\Models\ProdutoDaVendaRapidaModel;
use App\Models\ProdutoDoOrcamentoModel;
use App\Models\ProdutoDoPedidoModel;
use App\Models\ProdutoModel;
use App\Models\VendaModel;
use App\Models\VendedorModel;
use CodeIgniter\Controller;

class VendaRapida extends Controller
{
    private $link = [
        'li' => '2.x',
        'item' => '2.0',
        'subItem' => '2.1'
    ];

    private $session;
    private $id_empresa;
    private $id_login;

    private $conta_receber_model;
    private $provisorio_parcela_do_crediario_model;
    private $codigo_de_barra_do_produto_model;
    private $forma_de_pagamento_do_pedido_model;
    private $forma_de_pagamento_do_orcamento_model;
    private $link_adicional_da_sidebar_model;
    private $credito_na_loja_model;
    private $venda_credito_na_loja_model;
    private $forma_de_pagamento_da_venda_model;
    private $forma_de_pagamento_da_venda_rapida_model;
    private $controle_de_acesso_model;
    private $produto_model;
    private $caixa_model;
    private $produto_da_venda_rapida_model;
    private $venda_model;
    private $cliente_model;
    private $produto_da_venda_model;
    private $pedido_model;
    private $produto_do_pedido_model;
    private $orcamento_model;
    private $produto_do_orcamento_model;
    private $forma_de_pagamento_model;
    private $vendedor_model;

    private $permissao;

    function __construct()
    {
        $this->helpers = ['app'];

        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->conta_receber_model                      = new ContaReceberModel();
        $this->provisorio_parcela_do_crediario_model    = new ProvisorioParcelaDoCrediarioModel();
        $this->codigo_de_barra_do_produto_model         = new CodigoDeBarraDoProdutoModel();
        $this->forma_de_pagamento_do_pedido_model       = new FormaDePagamentoDoPedidoModel();
        $this->forma_de_pagamento_do_orcamento_model    = new FormaDePagamentoDoOrcamentoModel();
        $this->link_adicional_da_sidebar_model          = new LinkAdicionalDaSidebarModel();
        $this->credito_na_loja_model                    = new CreditoNaLojaModel();
        $this->venda_credito_na_loja_model              = new VendaCreditoNaLojaModel();
        $this->forma_de_pagamento_da_venda_model        = new FormaDePagamentoDaVendaModel();
        $this->forma_de_pagamento_da_venda_rapida_model = new FormaDePagamentoDaVendaRapidaModel();
        $this->controle_de_acesso_model                 = new ControleDeAcessoDoUsuarioModel();
        $this->produto_model                            = new ProdutoModel();
        $this->caixa_model                              = new CaixaModel();
        $this->produto_da_venda_rapida_model            = new ProdutoDaVendaRapidaModel();
        $this->venda_model                              = new VendaModel();
        $this->cliente_model                            = new ClienteModel();
        $this->produto_da_venda_model                   = new ProdutoDaVendaModel();
        $this->pedido_model                             = new PedidoModel();
        $this->produto_do_pedido_model                  = new ProdutoDoPedidoModel();
        $this->orcamento_model                          = new OrcamentoModel();
        $this->produto_do_orcamento_model               = new ProdutoDoOrcamentoModel();
        $this->forma_de_pagamento_model                 = new FormaDePagamentoModel();
        $this->vendedor_model                           = new VendedorModel();

        $this->permissao = $this->controle_de_acesso_model->verificaPermissao('venda_rapida');
    }

    public function index()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Venda Rápida',
            'icone'  => 'fa fa-money-bill-alt'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Venda Rápida", 'rota'   => "", 'active' => true]
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
        
        $data['produtos_da_venda_rapida'] = $this->produto_da_venda_rapida_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->findAll();

        $valor_da_venda = $this->produto_da_venda_rapida_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->selectSum('valor_final')
                                        ->first();

        $data['formas_de_pagamento'] = $this->forma_de_pagamento_model
                                            // ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $data['formas_de_pagamento_da_venda_rapida'] = $this->forma_de_pagamento_da_venda_rapida_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->join('formas_de_pagamento', 'formas_de_pagamento_da_venda_rapida.id_forma = formas_de_pagamento.id_forma')
                                                            ->findAll();

        $somatorio_formas_de_pagamento = $this->forma_de_pagamento_da_venda_rapida_model
                                                    ->where('id_empresa', $this->id_empresa)
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
                                    ->where('status', "Ativo")->find();

        // Mandar para view
        $data['valor_da_venda'] = $valor_da_venda;
        $data['somatorio_formas_de_pagamento'] = $somatorio_formas_de_pagamento;

        $data['troco'] = $troco;
        $data['restante'] = $restante;

        echo view('templates/header', $data);
        echo view('venda_rapida/index');
        echo view('templates/footer');
    }

    public function addProdutoDaVenda()
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

            $this->produto_da_venda_rapida_model
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
                $this->produto_da_venda_rapida_model->insert([
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

        return redirect()->to(base_url('/vendaRapida'));
    }

    public function tipoVenda($dados)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $id_venda = $this->venda_model
                            ->insert($dados);

        // ------------------------------------------ PRODUDOS ------------------------------------- //
        $produtos_da_venda_rapida = $this->produto_da_venda_rapida_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        foreach ($produtos_da_venda_rapida as $produto) :
            $produto['id_venda']    = $id_venda;
            
            // Adiciona os IDs ao array do produto
            $produto['id_empresa']  = $this->id_empresa;

            // Cadastra o produto
            $this->produto_da_venda_model
                ->insert($produto);

            // ---------------- Decrementa da quantidade do estoque a quantidade do produto vendido ------------------ //
            $produto_do_estoque = $this->produto_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto', $produto['id_produto'])
                ->first();

            // Caso o produto controle o estoque então decrementa a quantidade vendida
            if($produto_do_estoque['controlar_estoque'] == 1):
                // Cáculo
                $nova_qtd = $produto_do_estoque['quantidade'] - $produto['quantidade'];

                // Salva com a nova quantidade
                $this->produto_model
                    ->set('quantidade', $nova_qtd)
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_produto', $produto['id_produto'])
                    ->update();
            endif;
        endforeach;

        // Remove todos os registros da tabela produtos_da_venda_rapida.
        $this->produto_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();


        // ------------------------------------- FORMAS DE PAGAMENTO ------------------------------------------ //
        $formas_de_pagamento_da_venda_rapida_model = $this->forma_de_pagamento_da_venda_rapida_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->findAll();

        foreach($formas_de_pagamento_da_venda_rapida_model as $forma):
            // Remove id_id_forma_de_pagamento
            // Para não dar erro de chave duplicada
            unset($forma['id_forma_de_pagamento']);

            // Adiciona id_venda ao array
            $forma['id_venda'] = $id_venda;

            $this->forma_de_pagamento_da_venda_model
                ->insert($forma);
        endforeach;

        // Remove todos os registros da tabela formas_de_pagamento_da_venda_rapida.
        $this->forma_de_pagamento_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // VENDA CREDITO NA LOJA ----------------------- //
        // Caso esteja marcado o botão insere o registro
        if(isset($dados['usar_credito_na_loja'])):
            $this->venda_credito_na_loja_model
                ->insert([
                    'data'          => $dados['data'],
                    'hora'          => $dados['hora'],
                    'valor_a_pagar' => $dados['valor_a_pagar'],
                    'id_venda'      => $id_venda,
                    'id_cliente'    => $dados['id_cliente'],
                    'id_empresa'    => $dados['id_empresa']
                ]);
        endif;

        // Cria um alert na sessão
        $this->session->setFlashdata(
            'alert', 
            [
                'type'  => 'success',
                'title' => 'Venda realizada com sucesso!',
            ]
        );

        // Manda para o método limpar a tabela e depois mandar para o método crediario para cadastrar as parcelas
        if (isset($dados['venda_no_crediario'])) :
            return "vendaRapida/limpaTabelaParcelasDoCrediario/$id_venda";
        endif;

        return "/vendas";
    }

    public function limpaTabelaParcelasDoCrediario($id_venda = null)
    {
        // Limpa toda a tabela provisorio_parcelas_do_crediario
        // Para não acontecer de sair e quando voltar já ter parcelas cadastradas de outra venda
        $this->provisorio_parcela_do_crediario_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->delete();

        if($id_venda != null):
            return redirect()->to(base_url("vendaRapida/crediario/$id_venda"));
        endif;

        return;
    }


    public function crediario($id_venda)
    {        
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Venda no Crediário',
            'icone'  => 'fa fa-money-bill-alt'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Venda Rápida", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();
        // ---------------------------- //

        $data['venda'] = $this->venda_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_venda', $id_venda)
                                    ->first();

        $data['parcelas'] = $this->provisorio_parcela_do_crediario_model
                                                                ->where('id_empresa', $this->id_empresa)
                                                                ->findAll();

        echo View('templates/header', $data);
        echo View('venda_rapida/crediario');
        echo View('templates/footer');
    }

    public function geraParcelasDoCrediario($id_venda)
    {
        // Limpa a tabela provisorio_parcelas_do_crediario
        $this->limpaTabelaParcelasDoCrediario();

        $dados = $this->request
                            ->getVar();
        
        $venda = $this->venda_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_venda', $id_venda)
                                ->first();

        $cliente = $this->cliente_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_cliente', $venda['id_cliente'])
                                ->first();

        if($cliente['tipo'] == 1):
            $nome_do_cliente = $cliente['nome'];
        else:
            $nome_do_cliente = $cliente['razao_social'];
        endif;

        $valor_da_parcela = $venda['valor_a_pagar'] / $dados['quantidade'];

        $ultimo_vencimento = $dados['primeiro_vencimento'];

        for($i=0; $i<$dados['quantidade']; $i++):
            $cont = $i+1;

            $parcela = [
                'nome'               => "$nome_do_cliente - Parcela $cont/{$dados['quantidade']}",
                'data_de_vencimento' => $ultimo_vencimento,
                'valor'              => $valor_da_parcela,
                'observacoes'        => "Código da Venda: {$venda['id_venda']}",
                'id_empresa'         => $this->id_empresa,
                'id_cliente'         => $venda['id_cliente']
            ];

            $cont += 1;

            $vencimento_da_parcela = date('Y-m-d', strtotime("+30 days", strtotime($ultimo_vencimento)));

            $ultimo_vencimento = $vencimento_da_parcela;

            // Cadastra a parcela no banco
            $this->provisorio_parcela_do_crediario_model
                                                ->insert($parcela);
        endfor;

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Parcelas geradas com sucesso!'
                ]
            );

        return redirect()->to(base_url("vendaRapida/crediario/{$venda['id_venda']}"));
    }

    public function finalizarVendaNoCrediario()
    {
        // Pega todas as parcelas cadastradas no banco
        $parcelas = $this->provisorio_parcela_do_crediario_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        // Insere todas as parcelas no contas a receber
        foreach($parcelas as $parcela):
            // Adiciona o status da conta no array
            $parcela['status'] = "Aberta";

            $this->conta_receber_model
                            ->insert($parcela);
        endforeach;

        // Remove todas as parcelas provisorias
        $this->provisorio_parcela_do_crediario_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->delete();

        // Cria um alerta e redireciona ao venda rápida
        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Sucesso ao finalizar venda e adicionar parcelas ao contas a receber'
                ]
            );

        return redirect()->to(base_url('vendaRapida'));
    }

    public function alteraDadosDaParcelaIndividual($id_venda)
    {
        $dados = $this->request
                            ->getVar();

        // Converte de BRL para USD
        $dados['valor'] = converteMoney($dados['valor']);

        $this->provisorio_parcela_do_crediario_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_parcela', $dados['id_parcela'])
                                            ->set($dados)
                                            ->update();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Dados da parcela atualizados com sucesso!'
                ]
            );

        return redirect()->to(base_url("vendaRapida/crediario/$id_venda"));
    }

    public function tipoOrcamento($dados)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        // Converte BRL para USD
        $dados['valor_a_pagar']  = converteMoney($dados['valor_a_pagar']);
        $dados['valor_recebido'] = converteMoney($dados['valor_recebido']);
        $dados['troco']          = converteMoney($dados['troco']);

        // Por padrão todo orçamento gerado terá o status de Aberto
        $dados['status'] = "Aberto";

        // Adiciona os IDs ao array
        $dados['id_empresa']  = $this->id_empresa;

        $id_orcamento = $this->orcamento_model
                            ->insert($dados);

        $produtos_da_venda_rapida = $this->produto_da_venda_rapida_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        // ------------------------ TRANSFERE OS PRODUTOS DE VENDA RÁPIDA PARA ORCAMENTOS --------------------- //
        foreach ($produtos_da_venda_rapida as $produto) :
            $produto['id_orcamento'] = $id_orcamento;

            // Adiciona os IDs da sessão ao array
            $produto['id_empresa']  = $this->id_empresa;
            
            $this->produto_do_orcamento_model
                                ->insert($produto);
        endforeach;

        // Remove todos os registros da tabela produtos_da_venda_rapida.
        $this->produto_da_venda_rapida_model
            // ->emptyTable('produtos_da_venda_rapida');
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // ------------------ TRANSFERE AS FORMAS DE PAGAMENTO DE VENDA RÁPIDA PARA ORCAMENTOS ------------------------ //
        $formas_de_pagamento = $this->forma_de_pagamento_da_venda_rapida_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->findAll();

        foreach($formas_de_pagamento as $forma):
            // Remove primeiramente o id_forma
            unset($forma['id_forma_de_pagamento']);

            // Insere id_orcamento no array
            $forma['id_orcamento'] = $id_orcamento;

            // Insere o registro na tabela
            $this->forma_de_pagamento_do_orcamento_model
                                            ->insert($forma);
        endforeach;

        // Remove todos os registros da tabela formas_de_pagamento_da_venda_rapida.
        $this->forma_de_pagamento_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // --------------------------------- Cria um alert na sessão ---------------------------------- //
        $this->session->setFlashdata(
            'alert', 
            [
                'type'  => 'success',
                'title' => 'Orçamento realizado com sucesso!',
            ]
        );

        return "/orcamentos";
    }

    public function tipoPedido($dados)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        // Converte BRL para USD
        $dados['valor_a_pagar']  = converteMoney($dados['valor_a_pagar']);
        $dados['valor_recebido'] = converteMoney($dados['valor_recebido']);
        $dados['troco']          = converteMoney($dados['troco']);

        // Situação do Pedido
        $dados['situacao'] = "Não Pago - Andamento";

        // Para de entrega é o mesmo da data, pode ser alterado na sessão pedidos
        $dados['prazo_de_entrega'] = $dados['data'];

        $id_pedido = $this->pedido_model
                        ->insert($dados);

        $produtos_da_venda_rapida = $this->produto_da_venda_rapida_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        foreach ($produtos_da_venda_rapida as $produto) :
            $produto['id_pedido'] = $id_pedido;
            
            $this->produto_do_pedido_model
                ->insert($produto);
        endforeach;

        // Remove todos os registros da tabela produtos_da_venda_rapida.
        $this->produto_da_venda_rapida_model
        // ->emptyTable('produtos_da_venda_rapida');
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // ------------------ TRANSFERE AS FORMAS DE PAGAMENTO DE VENDA RÁPIDA PARA PEDIDOS ------------------------ //
        $formas_de_pagamento = $this->forma_de_pagamento_da_venda_rapida_model
                                                                    ->where('id_empresa', $this->id_empresa)
                                                                    ->findAll();

        foreach($formas_de_pagamento as $forma):
            // Remove primeiramente o id_forma
            unset($forma['id_forma_de_pagamento']);

            // Insere id_orcamento no array
            $forma['id_pedido'] = $id_pedido;

            // Insere o registro na tabela
            $this->forma_de_pagamento_do_pedido_model
                                            ->insert($forma);
        endforeach;

        // Remove todos os registros da tabela formas_de_pagamento_da_venda_rapida.
        $this->forma_de_pagamento_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // Cria um alert na sessão
        $this->session->setFlashdata(
            'alert', 
            [
                'type'  => 'success',
                'title' => 'Pedido realizado com sucesso!',
            ]
        );

        return "/pedidos";
    }

    public function store()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getvar();
        
        // Adiciona os IDs ao array
        $dados['id_empresa'] = $this->id_empresa;
        
        if($dados['tipo'] == "Venda") :
            $url = $this->tipoVenda($dados);
        elseif($dados['tipo'] == "Pedido") :
            $url = $this->tipoPedido($dados);
        elseif($dados['tipo'] == "Orçamento") :
            $url = $this->tipoOrcamento($dados);
        endif;

        return redirect()->to($url);
    }

    public function deleteProduto($id_produto_da_venda_rapida)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $this->produto_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_da_venda_rapida', $id_produto_da_venda_rapida)
            ->delete();

        // Cria um alert na sessão
        $this->session->setFlashdata(
            'alert', 
            [
                'type'  => 'success',
                'title' => 'Produto excluido com sucesso!',
            ]
        );

        return redirect()->to(base_url('/vendaRapida'));
    }

    public function alteraQuantidade()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getvar();

        $produto_da_venda_rapida = $this->produto_da_venda_rapida_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto_da_venda_rapida', $dados['id_produto_da_venda_rapida'])
                                        ->first();

        // dd($produto_da_venda_rapida);

        $subtotal = $dados['quantidade'] * $produto_da_venda_rapida['valor_unitario'];

        $this->produto_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->save([
                'id_produto_da_venda_rapida' => $dados['id_produto_da_venda_rapida'],
                'quantidade'                 => $dados['quantidade'],
                'subtotal'                   => $subtotal,
                'valor_final'                => $subtotal - $produto_da_venda_rapida['desconto']
            ]);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Quantidade alterada com sucesso!'
            ]
        );

        return redirect()->to('/vendaRapida');
    }


    public function alteraDesconto()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getvar();

        // Converte BRL para USD
        $dados['desconto'] = converteMoney($dados['desconto']);

        $produto_da_venda_rapida = $this->produto_da_venda_rapida_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto_da_venda_rapida', $dados['id_produto_da_venda_rapida'])
                                        ->first();

        // dd($produto_da_venda_rapida);

        $subtotal = $produto_da_venda_rapida['quantidade'] * $produto_da_venda_rapida['valor_unitario'];

        $this->produto_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->save([
                'id_produto_da_venda_rapida' => $dados['id_produto_da_venda_rapida'],
                'desconto'                   => $dados['desconto'],
                'subtotal'                   => $subtotal,
                'valor_final'                => $subtotal - $dados['desconto']
            ]);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Desconto adicionado com sucesso!'
            ]
        );

        return redirect()->to('/vendaRapida');
    }

    public function alteraValorUnitario()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;
        
        $dados = $this->request->getvar();

        // Converte BRL para USD
        $dados['valor_unitario'] = converteMoney($dados['valor_unitario']);

        $produto_da_venda_rapida = $this->produto_da_venda_rapida_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto_da_venda_rapida', $dados['id_produto_da_venda_rapida'])
                                        ->first();

        // dd($produto_da_venda_rapida);

        $subtotal = $produto_da_venda_rapida['quantidade'] * $dados['valor_unitario'];

        $this->produto_da_venda_rapida_model
            ->where('id_empresa', $this->id_empresa)
            ->save([
                'id_produto_da_venda_rapida' => $dados['id_produto_da_venda_rapida'],
                'valor_unitario'             => $dados['valor_unitario'],
                'desconto'                   => $produto_da_venda_rapida['desconto'],
                'subtotal'                   => $subtotal,
                'valor_final'                => $subtotal - $produto_da_venda_rapida['desconto']
            ]);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Valor Unitário alterado com sucesso!'
            ]
        );
        
        return redirect()->to('/vendaRapida');
    }

    public function createFormaDePagamento()
    {
        $dados = $this->request->getVar();

        // Converte BRL para USD
        $dados['valor'] = converteMoney($dados['valor']);

        // Adiciona id_empresa ao array
        $dados['id_empresa'] = $this->id_empresa;

        $this->forma_de_pagamento_da_venda_rapida_model
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

    public function deleteFormaDePagamentoDaVendaRapida($id_forma_de_pagamento)
    {
        $this->forma_de_pagamento_da_venda_rapida_model
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

        return redirect()->to(base_url('vendaRapida'));
    }

    public function verificaSeClienteTemCredito()
    {
        $id_cliente = $this->request
                                ->getVar('id_cliente');

        $valor_da_venda = $this->request
                                ->getVar('valor_da_venda');

        // Retorna o somatório do CREDITO NA LOJA
        $somatorio_creditos_na_loja = $this->credito_na_loja_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->where('id_cliente', $id_cliente)
                                                        ->selectSum('valor')
                                                        ->first()['valor'];

        if($somatorio_creditos_na_loja == null):
            $somatorio_creditos_na_loja = 0;
        endif;

        // Retorna o somatório de todas as vendas feita
        // com CREDITO NA LOJA
        $somatorio_vendas_credito_na_loja = $this->venda_credito_na_loja_model
                                                                    ->where('id_empresa', $this->id_empresa)
                                                                    ->where('id_cliente', $id_cliente)
                                                                    ->selectSum('valor_a_pagar')
                                                                    ->first()['valor_a_pagar'];

        if($somatorio_vendas_credito_na_loja == null):
            $somatorio_vendas_credito_na_loja = 0;
        endif;

        $credito = $somatorio_creditos_na_loja - $somatorio_vendas_credito_na_loja;

        if($credito < $valor_da_venda):
            echo 0; // 0=Não possui credito suficiente
        else:
            echo 1; // 1=Possui credito suficiente
        endif;
    }

    public function cancelaVenda()
    {
        // Remove todos os produtos da tabela produtos_da_venda_rapida
        $this->produto_da_venda_rapida_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->delete();

        // Remove todos os pagamentos da tabela pagamentos_da_venda_rapida
        $this->forma_de_pagamento_da_venda_rapida_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => "Venda cancelada com sucesso!"
                ]
            );

        return redirect()->to(base_url('vendaRapida'));
    }
}
