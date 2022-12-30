<?php

namespace App\Controllers;

use App\Models\ControleDeAcessoDoUsuarioModel;

use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\FormaDePagamentoModel;
use App\Models\TecnicoModel;
use App\Models\VendedorModel;
use App\Models\ClienteModel;
use App\Models\LancamentoModel;
use App\Models\CaixaModel;
use App\Models\ServicoMaoDeObraOsModel;
use App\Models\ProdutoPecaOsModel;
use App\Models\EquipamentoOsModel;
use App\Models\OrdemDeServicoModel;

use App\Models\ServicoMaoDeObraModel;
use App\Models\ServicoMaoDeObraProvisorioModel;
use App\Models\ProdutoPecaOsProvisorioModel;
use App\Models\ProdutoModel;
use App\Models\EquipamentoOsProvisorioModel;
use CodeIgniter\Controller;

class OrdemDeServico extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $link = [
        'item' => '3'
    ];

    private $link_adicional_da_sidebar_model;
    private $forma_de_pagamento_model;
    private $tecnico_model;
    private $vendedor_model;
    private $cliente_model;
    private $controle_de_acesso_model;

    private $lancamento_model;
    private $caixa_model;
    private $servico_mao_de_obra_os_model;
    private $produto_peca_os_model;
    private $equipamento_os_model;
    private $ordem_de_servico_model;

    private $servico_mao_de_obra_model;
    private $servico_mao_de_obra_os_provisorio_model;
    private $produto_peca_os_provisorio_model;
    private $produto_model;
    private $equipamento_provisorio_os_model;

    private $permissao;

    function __construct()
    {
        $this->helpers = ['app'];

        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->controle_de_acesso_model                = new ControleDeAcessoDoUsuarioModel();

        $this->link_adicional_da_sidebar_model = new LinkAdicionalDaSidebarModel();
        $this->forma_de_pagamento_model                = new FormaDePagamentoModel();
        $this->tecnico_model                           = new TecnicoModel();
        $this->vendedor_model                          = new VendedorModel();
        $this->cliente_model                           = new ClienteModel();
        $this->lancamento_model                        = new LancamentoModel();
        $this->caixa_model                             = new CaixaModel();
        $this->servico_mao_de_obra_os_model            = new ServicoMaoDeObraOsModel();
        $this->produto_peca_os_model                   = new ProdutoPecaOsModel();
        $this->equipamento_os_model                    = new EquipamentoOsModel();
        $this->ordem_de_servico_model                  = new OrdemDeServicoModel();

        $this->servico_mao_de_obra_model               = new ServicoMaoDeObraModel();
        $this->servico_mao_de_obra_os_provisorio_model = new ServicoMaoDeObraProvisorioModel();
        $this->produto_peca_os_provisorio_model        = new ProdutoPecaOsProvisorioModel();
        $this->produto_model                           = new ProdutoModel();
        $this->equipamento_provisorio_os_model         = new EquipamentoOsProvisorioModel();

        $this->permissao = $this->controle_de_acesso_model->verificaPermissao('ordem_de_servico');
    }

    public function index()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Ordens de serviço',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['ordens'] = $this->ordem_de_servico_model
                                ->where('ordens_de_servicos.id_empresa', $this->id_empresa)
                                ->join('clientes', 'ordens_de_servicos.id_cliente = clientes.id_cliente')
                                ->select('
                                    id_ordem,
                                    tipo,
                                    clientes.nome AS nome_do_cliente,
                                    razao_social,
                                    data_de_entrada,
                                    data_de_saida,
                                    situacao,
                                    clientes.id_cliente
                                ')
                                ->findAll();

        $data['caixas'] = $this->caixa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('status', "Aberto")
                                ->findAll();

        echo view('templates/header', $data);
        echo view('ordem_de_servico/index');
        echo view('templates/footer');
    }

    public function gerar()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Gerar ordem de serviço',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['clientes'] = $this->cliente_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $data['vendedores'] = $this->vendedor_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        $data['tecnicos'] = $this->tecnico_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        $data['formas_de_pagamento'] = $this->forma_de_pagamento_model
                                                                ->findAll();

        $data['caixas'] = $this->caixa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('status', "Aberto")
                                ->findAll();

        $data['equipamentos'] = $this->equipamento_provisorio_os_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        $data['produtos'] = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $produtos_pecas = $this->produto_peca_os_provisorio_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $data['servicos_mao_de_obra'] = $this->servico_mao_de_obra_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        $servicos_mao_de_obra_provisorio = $this->servico_mao_de_obra_os_provisorio_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->findAll();

        // Soma todos os produtos e peças
        $somatorio_produtos_pecas = 0;
        foreach($produtos_pecas as $produto) :
            $somatorio_produtos_pecas += (($produto['quantidade'] * $produto['valor']) - $produto['desconto']);
        endforeach;

        $data['produtos_pecas'] = $produtos_pecas;
        $data['somatorio_produtos_pecas'] = $somatorio_produtos_pecas;

        // Soma todos os serviços/mão de obra
        $somatorio_servicos_mao_de_obra = 0;
        foreach($servicos_mao_de_obra_provisorio as $servico) :
            $somatorio_servicos_mao_de_obra += (($servico['quantidade'] * $servico['valor']) - $servico['desconto']);
        endforeach;

        $data['servicos_mao_de_obra_provisorio'] = $servicos_mao_de_obra_provisorio;
        $data['somatorio_servicos_mao_de_obra'] = $somatorio_servicos_mao_de_obra;

        echo view('templates/header', $data);
        echo view('ordem_de_servico/gerar');
        echo view('templates/footer');
    }

    public function show($id_ordem)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Ordem de serviço',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['equipamentos'] = $this->equipamento_os_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_ordem', $id_ordem)
                                    ->findAll();

        $produtos_pecas = $this->produto_peca_os_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_ordem', $id_ordem)
                                        ->findAll();

        $servicos_mao_de_obra = $this->servico_mao_de_obra_os_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_ordem', $id_ordem)
                                            ->findAll();

        $data['ordem_de_servico'] = $this->ordem_de_servico_model
                                        ->where('ordens_de_servicos.id_empresa', $this->id_empresa)
                                        ->where('id_ordem', $id_ordem)
                                        ->join('clientes', 'ordens_de_servicos.id_cliente = clientes.id_cliente')
                                        ->join('vendedores', 'ordens_de_servicos.id_vendedor = vendedores.id_vendedor')
                                        ->join('tecnicos', 'ordens_de_servicos.id_tecnico = tecnicos.id_tecnico')
                                        ->select('
                                            frete,
                                            outros,
                                            desconto,
                                            situacao,
                                            data_de_entrada,
                                            hora_de_entrada,
                                            data_de_saida,
                                            hora_de_saida,
                                            clientes.nome AS nome_do_cliente,
                                            vendedores.nome AS nome_do_vendedor,
                                            tecnicos.nome AS nome_do_tecnico,
                                            canal_de_venda,
                                            forma_de_pagamento,
                                            endereco_de_entrega,
                                            observacoes,
                                            observacoes_internas
                                        ')
                                        ->first();

        // Soma todos os produtos e peças
        $somatorio_produtos_pecas = 0;
        foreach($produtos_pecas as $produto) :
            $somatorio_produtos_pecas += (($produto['quantidade'] * $produto['valor']) - $produto['desconto']);
        endforeach;

        $data['produtos_pecas'] = $produtos_pecas;
        $data['somatorio_produtos_pecas'] = $somatorio_produtos_pecas;

        // Soma todos os serviços/mão de obra
        $somatorio_servicos_mao_de_obra = 0;
        foreach($servicos_mao_de_obra as $servico) :
            $somatorio_servicos_mao_de_obra += (($servico['quantidade'] * $servico['valor']) - $servico['desconto']);
        endforeach;

        $data['servicos_mao_de_obra'] = $servicos_mao_de_obra;
        $data['somatorio_servicos_mao_de_obra'] = $somatorio_servicos_mao_de_obra;
        
        echo view('templates/header', $data);
        echo view('ordem_de_servico/show');
        echo view('templates/footer');
    }

    public function delete($id_ordem)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $this->ordem_de_servico_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_ordem', $id_ordem)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Ordem de serviço excluido com sucesso!'
            ]
        );

        return redirect()->to('/ordemDeServico');
    }

    public function alteraSituacao()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getVar();

        $this->ordem_de_servico_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_ordem', $dados['id_ordem'])
            ->set('situacao', $dados['situacao'])
            ->update();

        // Insere a ordem de serviço no caixa caso exista id_caixa e situação seja Finalizada
        if(isset($dados['id_caixa']) && $dados['situacao'] == "Finalizada") :
            $ordem = $this->ordem_de_servico_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_ordem', $dados['id_ordem'])
                            ->first();

            $produtos_pecas = $this->produto_peca_os_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_ordem', $dados['id_ordem'])
                                    ->findAll();

            $servicos_mao_de_obra = $this->servico_mao_de_obra_os_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_ordem', $dados['id_ordem'])
                                        ->findAll();

            $total_produtos_pecas = 0;
            foreach($produtos_pecas as $produto):
                $total_produtos_pecas += ($produto['valor'] - $produto['desconto']);
            endforeach;

            $total_servicos_mao_de_obra = 0;
            foreach($servicos_mao_de_obra as $servico):
                $total_servicos_mao_de_obra += ($servico['valor'] - $servico['desconto']);
            endforeach;

            $total = (($total_produtos_pecas + $total_servicos_mao_de_obra + $ordem['frete'] + $ordem['outros']) - $ordem['desconto']);

            $this->lancamento_model
                ->insert([
                    'descricao'   => "Ordem de serviço, Cód.: {$ordem['id_ordem']}",
                    'valor'       => $total,
                    'data'        => date('Y-m-d'),
                    'hora'        => date('H:i:s'),
                    'id_caixa'    => $dados['id_caixa'],
                    'observacoes' => "Lançamento inserido automaticamente como ação de O.S.",
                    'id_empresa'  => $this->id_empresa
                ]);
        endif;

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Situação da O.S. alterada com sucesso!'
            ]
        );

        return redirect()->to('/ordemDeServico');
    }

    // ------------ FORMS -------------- //
    // ----- EQUIPAMENTOS ----- //
    public function showEquipamento($id_equipamento)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Editar Equipamento',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['equipamento'] = $this->equipamento_provisorio_os_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_equipamento', $id_equipamento)
                                    ->first();

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/equipamento/show');
        echo view('templates/footer');
    }

    public function createEquipamento()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Adicionar Equipamento',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/equipamento/form');
        echo view('templates/footer');
    }

    public function editEquipamento($id_equipamento)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Editar Equipamento',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['equipamento'] = $this->equipamento_provisorio_os_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_equipamento', $id_equipamento)
                                    ->first();

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/equipamento/form');
        echo view('templates/footer');
    }

    public function storeEquipamento()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getVar();
        
        // Caso a ação seja editar
        if(isset($dados['id_equipamento'])) :
            $this->equipamento_provisorio_os_model
                ->where('id_equipamento', $dados['id_equipamento'])
                ->save($dados);

            $this->session->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Equipamento atualizado com sucesso!'
                ]
            );

            return redirect()->to("/ordemDeServico/editEquipamento/{$dados['id_equipamento']}");
        endif;

        // Caso a ação seja cadastar
        $dados['id_empresa'] = $this->id_empresa;
        
        $this->equipamento_provisorio_os_model
            ->insert($dados);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Equipamento cadastrado com sucesso!'
            ]
        );

        return redirect()->to("/ordemDeServico/gerar");
    }

    public function deleteEquipamento($id_equipamento)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $this->equipamento_provisorio_os_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_equipamento', $id_equipamento)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Equipamento excluido com sucesso!'
            ]
        );
        
        return redirect()->to('/ordemDeServico/gerar');
    }

    // ----- PEÇAS ----- //
    public function showPeca($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Dados do Produto/Peça',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['produto'] = $this->produto_peca_os_provisorio_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_produto', $id_produto)
                                ->first();

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/peca/show');
        echo view('templates/footer');
    }

    public function createPeca()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Adicionar Peça',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $dados = $this->request
                        ->getVar();

        $produto = $this->produto_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto', $dados['id_produto'])
                        ->first();

        $produto['quantidade'] = $dados['quantidade'];
        
        $data['produto'] = $produto;

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/peca/create');
        echo view('templates/footer');
    }

    public function editPeca($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Editar Peça',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['produto'] = $this->produto_peca_os_provisorio_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_produto', $id_produto)
                                ->first();

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/peca/edit');
        echo view('templates/footer');
    }

    public function storePeca()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getVar();
        $dados['id_empresa'] = $this->id_empresa;

        // Remove mascaras
        $dados['valor']    = converteMoney($dados['valor']);
        $dados['desconto'] = converteMoney($dados['desconto']);

        // Caso a ação seja editar
        if(isset($dados['id_produto'])) :
            
            $this->produto_peca_os_provisorio_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto', $dados['id_produto'])
                ->save($dados);

            $this->session->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Produto/Peça atualizado com sucesso!'
                ]
            );

            return redirect()->to("/ordemDeServico/editPeca/{$dados['id_produto']}");

        endif;

        // Caso a ação seja cadastrar
        $this->produto_peca_os_provisorio_model
            ->insert($dados);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Produto/Peça adicionado com sucesso!'
            ]
        );

        return redirect()->to('/ordemDeServico/gerar');
    }

    public function deletePeca($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $this->produto_peca_os_provisorio_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto', $id_produto)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Produto/Peça excluido com sucesso!'
            ]
        );

        return redirect()->to('/ordemDeServico/gerar');
    }

    // ----- SERVIÇOS ----- //
    public function showServico($id_servico)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Dados do Serviço/Mão de Obra',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['servico'] = $this->servico_mao_de_obra_os_provisorio_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_servico', $id_servico)
                                ->first();

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/servico/show');
        echo view('templates/footer');
    }

    public function createServico()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Adicionar Serviço',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $dados = $this->request
                            ->getVar();

        $servico = $this->servico_mao_de_obra_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_servico', $dados['id_servico'])
                                        ->first();

        $servico['quantidade'] = $dados['quantidade'];
        
        $data['servico'] = $servico;

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/servico/create');
        echo view('templates/footer');
    }

    public function editServico($id_servico)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Editar Serviço',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Ordens de Serviço", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['link'] = $this->link;

        $data['servico'] = $this->servico_mao_de_obra_os_provisorio_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_servico', $id_servico)
                                ->first();

        echo view('templates/header', $data);
        echo view('ordem_de_servico/forms/servico/edit');
        echo view('templates/footer');
    }

    public function storeServico()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getVar();
        $dados['id_empresa'] = $this->id_empresa;

        // Remove mascaras
        $dados['valor']    = converteMoney($dados['valor']);
        $dados['desconto'] = converteMoney($dados['desconto']);

        // Caso a ação seja editar
        if(isset($dados['id_servico'])) :
            
            $this->servico_mao_de_obra_os_provisorio_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_servico', $dados['id_servico'])
                ->save($dados);

            $this->session->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Serviço/Mão de Obra atualizado com sucesso!'
                ]
            );

            return redirect()->to("/ordemDeServico/editServico/{$dados['id_servico']}");

        endif;

        // Caso a ação seja cadastrar
        $this->servico_mao_de_obra_os_provisorio_model
            ->insert($dados);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Serviço/Mão de Obra adicionado com sucesso!'
            ]
        );

        return redirect()->to('/ordemDeServico/gerar');
    }

    public function deleteServico($id_servico)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $this->servico_mao_de_obra_os_provisorio_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_servico', $id_servico)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Serviço/Mão de Obra excluido com sucesso!'
            ]
        );

        return redirect()->to('/ordemDeServico/gerar');
    }

    // ------------ FINALIZAR ODEM ---------------- //
    public function finalizar()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;
        
        $dados = $this->request->getVar();

        // Adiciona id_empresa ao array
        $dados['id_empresa'] = $this->id_empresa;
        
        $equipamentos = $this->equipamento_provisorio_os_model
                            ->where('id_empresa', $this->id_empresa)
                            ->findAll();

        $produtos_pecas = $this->produto_peca_os_provisorio_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $servicos_mao_de_obra = $this->servico_mao_de_obra_os_provisorio_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        // Calcula todos os produtos e serviços + frete + outros tirando todos os descontos
        $total_produtos_pecas = 0;
        foreach($produtos_pecas as $produto):
            $total_produtos_pecas += ($produto['valor'] - $produto['desconto']);
        endforeach;

        $total_servicos_mao_de_obra = 0;
        foreach($servicos_mao_de_obra as $servico):
            $total_servicos_mao_de_obra += ($servico['valor'] - $servico['desconto']);
        endforeach;

        $total = (($total_produtos_pecas + $total_servicos_mao_de_obra + $dados['frete'] + $dados['outros']) - $dados['desconto']);

        $id_ordem = $this->ordem_de_servico_model
                                    ->insert($dados);

        // ---------------------- RECADASTRA EQUIPAMENTOS -------------------------  //
        foreach($equipamentos as $equipamento):
            // Remove created_at, updated_at, deleted_at para não dar erro
            unset($equipamento['created_at']);
            unset($equipamento['updated_at']);
            unset($equipamento['deleted_at']);

            // Adiciona id_ordem
            $equipamento['id_ordem'] = $id_ordem;
            
            // Cadastra equipamento
            $this->equipamento_os_model
                ->insert($equipamento);
        endforeach;

        // Remove todas os registros da tabela
        $this->equipamento_provisorio_os_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // -----------------  RECADASTRA PRODUTOS/PEÇAS ------------------------  //
        foreach($produtos_pecas as $produto):
            // Remove created_at, updated_at, deleted_at para não dar erro
            unset($produto['created_at']);
            unset($produto['updated_at']);
            unset($produto['deleted_at']);

            // Adiciona id_ordem
            $produto['id_ordem'] = $id_ordem;
            
            // Cadastra equipamento
            $this->produto_peca_os_model
                ->insert($produto);
        endforeach;

        // Remove todas os registros da tabela
        $this->produto_peca_os_provisorio_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // -----------------  RECADASTRA SERVIÇOS/MÃO DE OBRA ------------------------  //
        foreach($servicos_mao_de_obra as $servico):
            // Remove created_at, updated_at, deleted_at para não dar erro
            unset($servico['created_at']);
            unset($servico['updated_at']);
            unset($servico['deleted_at']);

            // Adiciona id_ordem
            $servico['id_ordem'] = $id_ordem;
            
            // Cadastra equipamento
            $this->servico_mao_de_obra_os_model
                ->insert($servico);
        endforeach;

        // Remove todas os registros da tabela
        $this->servico_mao_de_obra_os_provisorio_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // Insere a ordem de serviço no caixa caso exista id_caixa e situação seja Finalizada
        if(isset($dados['id_caixa']) && $dados['situacao'] == "Finalizada") :
            $this->lancamento_model
                ->insert([
                    'descricao'   => "Ordem de serviço, Cód.: $id_ordem",
                    'valor'       => $total,
                    'data'        => date('Y-m-d'),
                    'hora'        => date('H:i:s'),
                    'id_caixa'    => $dados['id_caixa'],
                    'observacoes' => "Lançamento inserido automaticamente como ação de O.S.",
                    'id_empresa'  => $this->id_empresa
                ]);
        endif;

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Ordem de serviço gerada com sucesso!'
            ]
        );

        return redirect()->to('/ordemDeServico');
    }
}