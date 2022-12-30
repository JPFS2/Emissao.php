<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\EmpresaModel;
use App\Models\PlanoModel;
use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\ControleDeAcessoModel;

use CodeIgniter\Controller;

class Planos extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $link = [
        'item' => '6'
    ];

    private $login_model;
    private $controle_de_acesso_do_usuario_model;
    private $empresa_model;
    private $plano_model;
    private $link_adicional_da_sidebar_model;
    private $controle_de_acesso_model;

    function __construct()
    {
        $this->helpers = ['app'];

        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->login_model                         = new LoginModel();
        $this->controle_de_acesso_do_usuario_model = new ControleDeAcessoDoUsuarioModel();
        $this->empresa_model                       = new EmpresaModel();
        $this->plano_model                         = new PlanoModel();
        $this->link_adicional_da_sidebar_model     = new LinkAdicionalDaSidebarModel();
        $this->controle_de_acesso_model            = new ControleDeAcessoModel();
    }

    public function index()
    {
        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Planos',
            'icone'  => 'fa fa-list'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Planos", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
            ->where('id_empresa', $this->id_empresa)
            ->findAll();

        $data['planos'] = $this->plano_model
                                        ->findAll();

        echo view('templates/header', $data);
        echo view('planos/index');
        echo view('templates/footer');
    }

    public function create()
    {
        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Novo Plano',
            'icone'  => 'fa fa-plus-circle'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Planos", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
            ->where('id_empresa', $this->id_empresa)
            ->findAll();

        echo view('templates/header', $data);
        echo view('planos/form');
        echo view('templates/footer');
    }

    public function edit($id_plano)
    {
        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Editar Plano',
            'icone'  => 'fa fa-plus-circle'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/admin/inicio", 'active' => false],
            ['titulo' => "Planos", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
            ->where('id_empresa', $this->id_empresa)
            ->findAll();

        $data['controle_de_acesso_do_plano'] = $this->controle_de_acesso_model
                                                                    ->where('id_plano', $id_plano)
                                                                    ->first();

        $data['plano'] = $this->plano_model
                                    ->where('id_plano', $id_plano)
                                    ->first();

        echo view('templates/header', $data);
        echo view('planos/form');
        echo view('templates/footer');
    }

    public function store()
    {
        $dados = $this->request->getVar();

        // Converte de BRL para USD
        $dados['valor'] = converteMoney($dados['valor']);

        // Caso a ação seja editar
        if(isset($dados['id_plano'])):
            $this->plano_model
                ->where('id_plano', $dados['id_plano'])
                ->set($dados)
                ->update();

            // Primeiro atualiza tudo pra zero
            $this->controle_de_acesso_model
                                    ->where('id_plano', $dados['id_plano'])
                                    ->set([
                                            'venda_rapida' => 0,
                                            'pdv' => 0,
                                            'pesquisa_produto' => 0,
                                            'historico_de_vendas' => 0,
                                            'orcamentos' => 0,
                                            'pedidos' => 0,
                                            'ordem_de_servico' => 0,
                                            'laboratorio' => 0,
                                            'novo_pedido' => 0,
                                            'mesas' => 0,
                                            'entregas' => 0,
                                            'abrir_painel' => 0,
                                            'transmitir_no_painel' => 0,
                                            'configs' => 0,
                                            'clientes' => 0,
                                            'fornecedores' => 0,
                                            'funcionarios' => 0,
                                            'vendedores' => 0,
                                            'entregadores' => 0,
                                            'tecnicos' => 0,
                                            'servico_mao_de_obra' => 0,
                                            'transportadoras' => 0,
                                            'produtos' => 0,
                                            'reposicoes' => 0,
                                            'saida_de_mercadorias' => 0,
                                            'inventario_do_estoque' => 0,
                                            'categoria_dos_produtos' => 0,
                                            'caixas' => 0,
                                            'lancamentos' => 0,
                                            'retiradas_do_caixa' => 0,
                                            'despesas' => 0,
                                            'contas_a_pagar' => 0,
                                            'contas_a_receber' => 0,
                                            'relatorio_dre' => 0,
                                            'nfe' => 0,
                                            'nfce' => 0,
                                            'vendas_historico_completo' => 0,
                                            'vendas_por_cliente' => 0,
                                            'vendas_por_vendedor' => 0,
                                            'vendas_lucro_total' => 0,
                                            'estoque_produtos' => 0,
                                            'estoque_minimo' => 0,
                                            'estoque_inventario' => 0,
                                            'estoque_validade_do_produto' => 0,
                                            'financeiro_movimentacao_de_entradas_e_saidas' => 0,
                                            'financeiro_faturamento_diario' => 0,
                                            'financeiro_faturamento_detalhado' => 0,
                                            'financeiro_lancamentos' => 0,
                                            'financeiro_retiradas_do_caixa' => 0,
                                            'financeiro_despesas' => 0,
                                            'financeiro_contas_a_pagar' => 0,
                                            'financeiro_contas_a_receber' => 0,
                                            'financeiro_dre' => 0,
                                            'geral_clientes' => 0,
                                            'geral_fornecedores' => 0,
                                            'geral_funcionarios' => 0,
                                            'geral_vendedores' => 0,
                                            'agenda' => 0,
                                            'usuarios' => 0,
                                            'config_da_conta' => 0,
                                            'config_da_empresa' => 0,
                                            'config_nfe_e_nfce' => 0,
                                            'widget_clientes' => 0,
                                            'widget_produtos' => 0,
                                            'widget_vendas' => 0,
                                            'widget_lancamentos' => 0,
                                            'widget_faturamento' => 0,
                                            'widget_os' => 0,
                                            'grafico_faturamento_linha' => 0,
                                            'grafico_faturamento_barras' => 0,
                                            'tabela_contas_a_pagar' => 0,
                                            'tabela_contas_a_receber' => 0
                                        ])
                                    ->update();

            // Depois atualiza para o que o usuário escolheu
            $this->controle_de_acesso_model
                ->where('id_plano', $dados['id_plano'])
                ->set($dados)
                ->update();

            // Pega todas as empresas relacionadas a esse plano para atualizar o controle de acesso
            $empresas = $this->empresa_model
                                        ->where('id_plano', $dados['id_plano'])
                                        ->findAll();

            // Remove id_controle_de_acesso para não dar conflito
            unset($dados['id_controle_de_acesso']);

            // Altera todos os controles de acessos cadastrados para cada empresa e coloca os do Plano
            foreach($empresas as $empresa):
                $this->controle_de_acesso_do_usuario_model
                                            ->where('id_empresa', $empresa['id_empresa'])
                                            ->set($dados)
                                            ->update();
            endforeach;

            $this->session
                ->setFlashdata(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Plano atualizado com sucesso!'
                    ]
                );

            return redirect()->to(base_url("planos/edit/{$dados['id_plano']}"));
        endif;

        // Caso a ação seja cadastrar
        $id_plano = $this->plano_model
                            ->insert($dados);

        $dados['id_plano'] = $id_plano;

        // Primeiro cadastra todos com zero
        $id_controle_de_acesso = $this->controle_de_acesso_model
                                ->insert([
                                    'venda_rapida' => 0,
                                    'pdv' => 0,
                                    'pesquisa_produto' => 0,
                                    'historico_de_vendas' => 0,
                                    'orcamentos' => 0,
                                    'pedidos' => 0,
                                    'ordem_de_servico' => 0,
                                    'laboratorio' => 0,
                                    'novo_pedido' => 0,
                                    'mesas' => 0,
                                    'entregas' => 0,
                                    'abrir_painel' => 0,
                                    'transmitir_no_painel' => 0,
                                    'configs' => 0,
                                    'clientes' => 0,
                                    'fornecedores' => 0,
                                    'funcionarios' => 0,
                                    'vendedores' => 0,
                                    'entregadores' => 0,
                                    'tecnicos' => 0,
                                    'servico_mao_de_obra' => 0,
                                    'transportadoras' => 0,
                                    'produtos' => 0,
                                    'reposicoes' => 0,
                                    'saida_de_mercadorias' => 0,
                                    'inventario_do_estoque' => 0,
                                    'categoria_dos_produtos' => 0,
                                    'caixas' => 0,
                                    'lancamentos' => 0,
                                    'retiradas_do_caixa' => 0,
                                    'despesas' => 0,
                                    'contas_a_pagar' => 0,
                                    'contas_a_receber' => 0,
                                    'relatorio_dre' => 0,
                                    'nfe' => 0,
                                    'nfce' => 0,
                                    'vendas_historico_completo' => 0,
                                    'vendas_por_cliente' => 0,
                                    'vendas_por_vendedor' => 0,
                                    'vendas_lucro_total' => 0,
                                    'estoque_produtos' => 0,
                                    'estoque_minimo' => 0,
                                    'estoque_inventario' => 0,
                                    'estoque_validade_do_produto' => 0,
                                    'financeiro_movimentacao_de_entradas_e_saidas' => 0,
                                    'financeiro_faturamento_diario' => 0,
                                    'financeiro_faturamento_detalhado' => 0,
                                    'financeiro_lancamentos' => 0,
                                    'financeiro_retiradas_do_caixa' => 0,
                                    'financeiro_despesas' => 0,
                                    'financeiro_contas_a_pagar' => 0,
                                    'financeiro_contas_a_receber' => 0,
                                    'financeiro_dre' => 0,
                                    'geral_clientes' => 0,
                                    'geral_fornecedores' => 0,
                                    'geral_funcionarios' => 0,
                                    'geral_vendedores' => 0,
                                    'agenda' => 0,
                                    'usuarios' => 0,
                                    'config_da_conta' => 0,
                                    'config_da_empresa' => 0,
                                    'config_nfe_e_nfce' => 0,
                                    'widget_clientes' => 0,
                                    'widget_produtos' => 0,
                                    'widget_vendas' => 0,
                                    'widget_lancamentos' => 0,
                                    'widget_faturamento' => 0,
                                    'widget_os' => 0,
                                    'grafico_faturamento_linha' => 0,
                                    'grafico_faturamento_barras' => 0,
                                    'tabela_contas_a_pagar' => 0,
                                    'tabela_contas_a_receber' => 0,
                                    'id_plano' => $id_plano
                                ]);

        // Depois atualiza para o que o usuário escolheu
        $this->controle_de_acesso_model
                                ->where('id_controle_de_acesso', $id_controle_de_acesso)
                                ->set($dados)
                                ->update();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Plano cadastrado com sucesso!'
                ]
            );

        return redirect()->to(base_url('planos'));
    }

    public function delete($id_plano)
    {
        $empresas = $this->empresa_model
                        ->where('id_plano', $id_plano)
                        ->findAll();

        // Apaga todos o login da empresa, pois essa opção não tem foreik key e não é apagado automaticamente
        foreach($empresas as $empresa):
            $this->login_model
                ->where('id_empresa', $empresa['id_empresa'])
                ->delete();
        endforeach;

        // Apaga o plano em questão
        $this->plano_model
            ->where('id_plano', $id_plano)
            ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Plano cadastrado com sucesso!'
                ]
            );

        return redirect()->to(base_url('planos'));
    }
}
