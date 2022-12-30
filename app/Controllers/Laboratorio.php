<?php

namespace App\Controllers;

use App\Models\ControleDeAcessoDoUsuarioModel;

use App\Models\EmpresaModel;
use App\Models\EntregaDoLaboratorioModel;
use App\Models\EntregadorModel;
use App\Models\ServicoMaoDeObraDoLaboratorioModel;
use App\Models\LaboratorioDefinitivoModel;
use App\Models\LaboratorioModel;
use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\ClienteModel;
use App\Models\LancamentoModel;
use App\Models\ServicoMaoDeObraOsModel;

use App\Models\ServicoMaoDeObraModel;
use App\Models\ServicoMaoDeObraProvisorioModel;
use CodeIgniter\Controller;

class Laboratorio extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $link = [
        'item' => '13'
    ];

    private $empresa_model;
    private $entrega_do_laboratorio_model;
    private $entregador_model;
    private $servico_mao_de_obra_do_laboratorio_model;
    private $laboratorio_definitivo_model;
    private $laboratorio_model;
    private $link_adicional_da_sidebar_model;
    private $cliente_model;
    private $controle_de_acesso_model;

    private $servico_mao_de_obra_model;
    private $servico_mao_de_obra_os_provisorio_model;

    private $permissao;

    function __construct()
    {
        $this->helpers = ['app'];

        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->controle_de_acesso_model                = new ControleDeAcessoDoUsuarioModel();

        $this->empresa_model                           = new EmpresaModel();
        $this->entrega_do_laboratorio_model            = new EntregaDoLaboratorioModel();
        $this->entregador_model                        = new EntregadorModel();
        $this->servico_mao_de_obra_do_laboratorio_model = new ServicoMaoDeObraDoLaboratorioModel();
        $this->laboratorio_definitivo_model            = new LaboratorioDefinitivoModel();
        $this->laboratorio_model                       = new LaboratorioModel();
        $this->link_adicional_da_sidebar_model         = new LinkAdicionalDaSidebarModel();
        $this->cliente_model                           = new ClienteModel();
        $this->lancamento_model                        = new LancamentoModel();
        $this->servico_mao_de_obra_os_model            = new ServicoMaoDeObraOsModel();

        $this->servico_mao_de_obra_model               = new ServicoMaoDeObraModel();
        $this->servico_mao_de_obra_os_provisorio_model = new ServicoMaoDeObraProvisorioModel();

        $this->permissao = $this->controle_de_acesso_model->verificaPermissao('laboratorio');
    }

    public function index()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Ordens',
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

        $ordens = $this->laboratorio_definitivo_model
                                            ->where('laboratorios.id_empresa', $this->id_empresa)
                                            ->join('clientes', 'laboratorios.id_cliente = clientes.id_cliente')
                                            ->findAll();

        $i=0;
        foreach($ordens as $ordem):
            $somatorio = 0;

            $servicos_mao_de_obra = $this->servico_mao_de_obra_do_laboratorio_model
                                                                                ->where('id_empresa', $this->id_empresa)
                                                                                ->where('id_laboratorio', $ordem['id_laboratorio'])
                                                                                ->findAll();

            foreach($servicos_mao_de_obra as $servico):
                $somatorio += (($servico['quantidade'] * $servico['valor']) - $servico['desconto']);
             endforeach;

             $ordens[$i]['somatorio'] = $somatorio;

             $i += 1;
        endforeach;

        $data['ordens'] = $ordens;

        echo view('templates/header', $data);
        echo view('laboratorio/index');
        echo view('templates/footer');
    }

    public function gerar($id_laboratorio)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Gerar Ordem',
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

        $data['servicos_mao_de_obra'] = $this->servico_mao_de_obra_model
            ->where('id_empresa', $this->id_empresa)
            ->findAll();

        $servicos_mao_de_obra_provisorio = $this->servico_mao_de_obra_os_provisorio_model
            ->where('id_empresa', $this->id_empresa)
            ->findAll();

        // Soma todos os serviços/mão de obra
        $somatorio_servicos_mao_de_obra = 0;
        foreach ($servicos_mao_de_obra_provisorio as $servico) :
            $somatorio_servicos_mao_de_obra += (($servico['quantidade'] * $servico['valor']) - $servico['desconto']);
        endforeach;

        // ---------- //
        $ordem_do_laboratorio = $this->laboratorio_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->where('id_laboratorio', $id_laboratorio)
                                                ->first();
        // ---------- //

        $data['servicos_mao_de_obra_provisorio'] = $servicos_mao_de_obra_provisorio;
        $data['somatorio_servicos_mao_de_obra'] = $somatorio_servicos_mao_de_obra;

        $data['ordem_do_laboratorio'] = $ordem_do_laboratorio;
        $data['id_laboratorio'] = $id_laboratorio;

        echo view('templates/header', $data);
        echo view('laboratorio/gerar');
        echo view('templates/footer');
    }

    public function show($id_laboratorio)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Ordem de serviço do Laboratório',
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

        $servicos_mao_de_obra = $this->servico_mao_de_obra_do_laboratorio_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_laboratorio', $id_laboratorio)
            ->findAll();

        $data['ordem'] = $this->laboratorio_definitivo_model
                                                ->where('laboratorios.id_empresa', $this->id_empresa)
                                                ->where('id_laboratorio', $id_laboratorio)
                                                ->join('clientes', 'laboratorios.id_cliente = clientes.id_cliente')
                                                ->first();

        // Soma todos os serviços/mão de obra
        $somatorio_servicos_mao_de_obra = 0;
        foreach ($servicos_mao_de_obra as $servico) :
            $somatorio_servicos_mao_de_obra += (($servico['quantidade'] * $servico['valor']) - $servico['desconto']);
        endforeach;

        $data['entrega'] = $this->entrega_do_laboratorio_model
                                                    ->where('entregas_do_laboratorio.id_empresa', $this->id_empresa)
                                                    ->where('entregas_do_laboratorio.id_laboratorio', $id_laboratorio)
                                                    ->join('entregadores', 'entregas_do_laboratorio.id_entregador = entregadores.id_entregador')
                                                    ->select('
                                                        id_entrega,
                                                        id_laboratorio,
                                                        entregas_do_laboratorio.status AS status,
                                                        data,
                                                        entregadores.nome AS nome,
                                                        observacoes
                                                    ')
                                                    ->first();

        $data['cliente'] = $this->cliente_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_cliente', $data['ordem']['id_cliente'])
                                        ->first();

        $data['servicos_mao_de_obra'] = $servicos_mao_de_obra;
        $data['somatorio_servicos_mao_de_obra'] = $somatorio_servicos_mao_de_obra;

        echo view('templates/header', $data);
        echo view('laboratorio/show');
        echo view('templates/footer');
    }

    public function delete($id_laboratorio)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $this->laboratorio_definitivo_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_laboratorio', $id_laboratorio)
                            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Ordem excluida com sucesso!'
            ]
        );

        return redirect()->to(base_url('laboratorio'));
    }

    public function createServico($id_laboratorio)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
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

        $data['id_laboratorio'] = $id_laboratorio;

        $data['servico'] = $servico;

        echo view('templates/header', $data);
        echo view('laboratorio/forms/servico/create');
        echo view('templates/footer');
    }

    public function storeServico($id_laboratorio)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $dados = $this->request->getVar();
        $dados['id_empresa'] = $this->id_empresa;

        // Remove mascaras
        $dados['valor']    = converteMoney($dados['valor']);
        $dados['desconto'] = converteMoney($dados['desconto']);

        // Caso a ação seja editar
        if (isset($dados['id_servico'])) :

            $this->servico_mao_de_obra_do_lab_provisorio_model
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

        return redirect()->to("/laboratorio/gerar/$id_laboratorio");
    }

    public function deleteServico($id_servico, $id_laboratorio)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
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

        return redirect()->to("/laboratorio/gerar/$id_laboratorio");
    }

    // ------------ FINALIZAR ODEM ---------------- //
    public function finalizar()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $dados = $this->request
                            ->getVar();

        // Adiciona id_empresa ao array
        $dados['id_empresa'] = $this->id_empresa;

        // Adiciona os dentes ao array
        $laboratorio_provisorio = $this->laboratorio_model
                                                    ->where('id_laboratorio', $dados['id_laboratorio'])
                                                    ->first();

        $dados['dentes_do_maxilar'] = $laboratorio_provisorio['dentes_do_maxilar'];
        $dados['dentes_da_mandibula'] = $laboratorio_provisorio['dentes_da_mandibula'];
        // -------------------------- //

        $servicos_mao_de_obra = $this->servico_mao_de_obra_os_provisorio_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->select('
                                                                nome,
                                                                detalhes,
                                                                quantidade,
                                                                valor,
                                                                desconto,
                                                                id_empresa,
                                                            ')
                                                            ->findAll();

        // Remove id_laboratorio do array
        unset($dados['id_laboratorio']);

        $id_laboratorio = $this->laboratorio_definitivo_model
                                                        ->insert($dados);

        foreach($servicos_mao_de_obra as $servico):
            $servico['id_laboratorio'] = $id_laboratorio;

            $this->servico_mao_de_obra_do_laboratorio_model
                                                    ->insert($servico);
        endforeach;

        // Remove a ordem do laboratorio provisoria e limpa os serviços mão de obra
        $this->laboratorio_model
                        ->where('id_empresa', $this->id_empresa)
                        ->delete();

        $this->servico_mao_de_obra_os_provisorio_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Ordem cadastrada com sucesso!'
                ]
            );

        return redirect()->to(base_url('laboratorio'));
    }

    public function salvaProvisorioDentesDoLaboratorio($id_laboratorio)
    {
        $dados = $this->request
                            ->getVar();
        
        $this->laboratorio_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_laboratorio', $id_laboratorio)
                            ->set($dados)
                            ->update();
    }

    public function iniciarNovaOrdemDoLaboratorio()
    {
        $this->laboratorio_model
                            ->where('id_empresa', $this->id_empresa)
                            ->delete();

        $cliente = $this->cliente_model
                                    ->where('nome', 'CONSUMIDOR FINAL')
                                    ->first();

        $id_laboratorio = $this->laboratorio_model
                                            ->insert([
                                                'dentes_do_maxilar' => '',
                                                'dentes_da_mandibula' => '',
                                                'data_de_entrada' => date('Y-m-d'),
                                                'data_prevista' => '',
                                                'cor_do_dente' => '',
                                                'caixa' => '',
                                                'paciente' => '',
                                                'observacoes' => '',
                                                'id_cliente' => $cliente['id_cliente'],
                                                'id_empresa' => $this->id_empresa,
                                            ]);

        return redirect()->to(base_url("laboratorio/gerar/$id_laboratorio"));
    }

    public function impressao($id_laboratorio)
    {
        $ordem = $this->laboratorio_definitivo_model
                                            ->where('laboratorios.id_empresa', $this->id_empresa)
                                            ->where('id_laboratorio', $id_laboratorio)
                                            ->join('clientes', 'laboratorios.id_cliente = clientes.id_cliente')
                                            ->first();

        $servicos = $this->servico_mao_de_obra_do_laboratorio_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->where('id_laboratorio', $id_laboratorio)
                                                    ->findAll();

        // Soma todos os serviços/mão de obra
        $somatorio_servicos_mao_de_obra = 0;
        foreach ($servicos as $servico) :
            $somatorio_servicos_mao_de_obra += (($servico['quantidade'] * $servico['valor']) - $servico['desconto']);
        endforeach;

        $entrega = $this->entrega_do_laboratorio_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->where('id_laboratorio', $id_laboratorio)
                                                ->first();

        if(!empty($entrega)):
            $data['entregador'] = $this->entregador_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_entregador', $entrega['id_entregador'])
                                            ->first();
        endif;

        $data['empresa'] = $this->empresa_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->first();

        $data['ordem'] = $ordem;
        $data['servicos'] = $servicos;
        $data['somatorio'] = $somatorio_servicos_mao_de_obra;

        echo View('laboratorio/impressao', $data);
    }

    // -------------- CADASTRAR ENTREGAS PARA A ORDEM ------------------ //
    public function createEntrega($id_laboratorio, $id_cliente)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['titulo'] = [
            'modulo' => 'Dados da Entrega',
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

        $data['cliente'] = $this->cliente_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_cliente', $id_cliente)
                                        ->first();

        $data['entregadores'] = $this->entregador_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['id_laboratorio'] = $id_laboratorio;

        echo view('templates/header', $data);
        echo view('laboratorio/entrega/form');
        echo view('templates/footer');
    }

    public function storeEntrega()
    {
        $dados = $this->request
                            ->getVar();

        $dados['id_empresa'] = $this->id_empresa;

        $this->entrega_do_laboratorio_model
                                    ->insert($dados);

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Entrega cadastrada com sucesso!'
                ]
            );

        return redirect()->to(base_url("laboratorio/show/{$dados['id_laboratorio']}"));
    }

    public function deleteEntrega($id_laboratorio, $id_entrega)
    {
        $this->entrega_do_laboratorio_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_laboratorio', $id_laboratorio)
                                    ->where('id_entrega', $id_entrega)
                                    ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Entrega excluida com sucesso!'
                ]
            );

        return redirect()->to(base_url("laboratorio/show/{$id_laboratorio}"));
    }

    public function alterarStatusDaEntrega()
    {
        $dados = $this->request
                            ->getVar();

        $this->entrega_do_laboratorio_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_laboratorio', $dados['id_laboratorio'])
                                ->where('id_entrega', $dados['id_entrega'])
                                ->set('status', $dados['status'])
                                ->update();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Status alterado com sucesso!'
                ]
            );

        return redirect()->to(base_url("laboratorio/show/{$dados['id_laboratorio']}"));
    }
}
