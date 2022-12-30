<?php

namespace App\Controllers;

use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\ContaReceberModel;
use App\Models\ContaPagarModel;
use App\Models\OrdemDeServicoModel;
use App\Models\ProdutoModel;
use App\Models\ClienteModel;
use App\Models\VendaModel;
use App\Models\LancamentoModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use CodeIgniter\Controller;

class Inicio extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $link_adicional_da_sidebar_model;
    private $conta_a_receber_model;
    private $conta_a_pagar_model;
    private $ordem_de_servico_model;
    private $produto_model;
    private $cliente_model;
    private $venda_model;
    private $lancamento_model;
    private $controle_de_acesso_model;

    function __construct()
    {
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->link_adicional_da_sidebar_model = new LinkAdicionalDaSidebarModel();
        $this->conta_a_receber_model           = new ContaReceberModel();
        $this->conta_a_pagar_model             = new ContaPagarModel();
        $this->ordem_de_servico_model          = new OrdemDeServicoModel();
        $this->produto_model                   = new ProdutoModel();
        $this->cliente_model                   = new ClienteModel();
        $this->venda_model                     = new VendaModel();
        $this->lancamento_model                = new LancamentoModel();
        $this->controle_de_acesso_model        = new ControleDeAcessoDoUsuarioModel();
    }

    public function index()
    {
        // Revifica se tem uma sessão ativa
        if($this->session->get('tipo') == null):
            $this->session->setFlashdata(
                'alert',
                [
                    'type' => 'error',
                    'title' => 'Você não está logado! Acesse sua conta para continuar.'
                ]
            );

            return redirect()->to('/login');
        endif;

        $data['link'] = [
            'item' => '1'
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        // ---------- VARIÁVEL PARA SER USADA NO CONTROLLER TODO //
        $ano_e_mes_atual = date('Y')."-".date('m');

        // ------------------------------------------ WIDGETS ------------------------------------------------- //
        $data['clientes'] = COUNT(
            $this->cliente_model
                            ->where('id_empresa', $this->id_empresa)
                            ->findAll()
        );

        $data['produtos'] = COUNT(
            $this->produto_model
                            ->where('id_empresa', $this->id_empresa)
                            ->findAll()
        );

        $data['quantidade_de_vendas_do_mes'] = COUNT(
            $this->venda_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('data >=', $ano_e_mes_atual."-01")
                        ->where('data <=', $ano_e_mes_atual."-31")
                        ->findAll()
        );

        $data['quantidade_de_lancamentos_do_mes'] = COUNT(
            $this->lancamento_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('data >=', $ano_e_mes_atual."-01")
                        ->where('data <=', $ano_e_mes_atual."-31")
                        ->findAll()
        );

        $total_em_vendas = $this->venda_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('data >=', $ano_e_mes_atual."-01")
                                ->where('data <=', $ano_e_mes_atual."-31")
                                ->selectSum('valor_a_pagar')
                                ->first()['valor_a_pagar'];

        if($total_em_vendas == null):
            $total_em_vendas = 0;
        endif;

        $total_em_lancamentos = $this->lancamento_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('data >=', $ano_e_mes_atual."-01")
                                    ->where('data <=', $ano_e_mes_atual."-31")
                                    ->selectSum('valor')
                                    ->first()['valor'];

        if($total_em_lancamentos == null):
            $total_em_lancamentos = 0;
        endif;

        $data['faturamento_do_mes'] = ($total_em_vendas + $total_em_lancamentos);

        $data['quantidade_de_os_do_mes'] = COUNT(
            $this->ordem_de_servico_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('data_de_entrada >=', $ano_e_mes_atual."-01")
                        ->where('data_de_entrada <=', $ano_e_mes_atual."-31")
                        ->findAll()
        );

        // ------------------------------------------ FATURAMENTO ------------------------------------------------- //
        $ano_atual = date('Y');
        $faturamento_por_mes = [];
        $meses = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

        foreach($meses as $mes):
            $total_de_lancamentos = $this->lancamento_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('data >=', "$ano_atual-$mes-01")
                                        ->where('data <=', "$ano_atual-$mes-31")
                                        ->selectSum('valor')
                                        ->first()['valor'];

            if($total_de_lancamentos == null):
                $total_de_lancamentos = 0;
            endif;

            $total_de_vendas = $this->venda_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('data >=', "$ano_atual-$mes-01")
                                        ->where('data <=', "$ano_atual-$mes-31")
                                        ->selectSum('valor_a_pagar')
                                        ->first()['valor_a_pagar'];

            if($total_de_vendas == null):
                $total_de_vendas = 0;
            endif;
            
            $faturamento_por_mes[] = ($total_de_lancamentos + $total_de_vendas);
        endforeach;

        $data['nome_dos_meses'] = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $data['faturamento_por_mes'] = $faturamento_por_mes;

        // ------------------------------------------ CONTAS A PAGAR E RECEBER ------------------------------------------------- //
        $data['contas_a_pagar'] = $this->conta_a_pagar_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('data_de_vencimento >=', $ano_e_mes_atual."-01")
                                        ->where('data_de_vencimento <=', $ano_e_mes_atual."-31")
                                        ->findAll();

        $data['contas_a_receber'] = $this->conta_a_receber_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('data_de_vencimento >=', $ano_e_mes_atual."-01")
                                        ->where('data_de_vencimento <=', $ano_e_mes_atual."-31")
                                        ->findAll();

        echo view('templates/header', $data);
        echo view('dashboard/index');
        echo view('templates/footer');
    }
}
