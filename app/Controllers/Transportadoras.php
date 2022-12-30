<?php

namespace App\Controllers;

use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\TransportadoraModel;
use App\Models\MunicipioModel;
use App\Models\UfModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use CodeIgniter\Controller;

class Transportadoras extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $link = [
        'li' => '5.x',
        'item' => '5.0',
        'subItem' => '5.8'
    ];

    private $link_adicional_da_sidebar_model;
    private $transportadora_model;
    private $municipio_model;
    private $uf_model;
    private $controle_de_acesso_model;

    private $permissao;

    function __construct()
    {
        $this->helpers = ['app'];

        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->link_adicional_da_sidebar_model = new LinkAdicionalDaSidebarModel();
        $this->transportadora_model     = new TransportadoraModel();
        $this->municipio_model          = new MunicipioModel();
        $this->uf_model                 = new UfModel();
        $this->controle_de_acesso_model = new ControleDeAcessoDoUsuarioModel();

        $this->permissao = $this->controle_de_acesso_model->verificaPermissao('transportadoras');
    }

    public function index()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'Transportadoras',
            'icone'  => 'fa fa-users'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Técnicos", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['transportadoras'] = $this->transportadora_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->findAll();

        echo view('templates/header', $data);
        echo view('transportadoras/index');
        echo view('templates/footer');
    }

    public function show($id_transportadora)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'Dados da Transportadora',
            'icone'  => 'fa fa-users'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Transportadoras", 'rota'   => "/transportadoras", 'active' => false],
            ['titulo' => "Editar", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['ufs'] = $this->uf_model
                            ->findAll(); 

        $data['municipios'] = $this->municipio_model
                                    ->findAll(); 

        $data['transportadora'] = $this->transportadora_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_transportadora', $id_transportadora)
                                        ->join('ufs', 'transportadoras.id_uf = ufs.id_uf')
                                        ->join('municipios', 'transportadoras.id_municipio = municipios.id_municipio')
                                        ->first();

        echo view('templates/header', $data);
        echo view('transportadoras/show');
        echo view('templates/footer');
    }

    public function create()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;
        
        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'Nova Transportadora',
            'icone'  => 'fa fa-users'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Transportadoras", 'rota'   => "/transportadoras", 'active' => false],
            ['titulo' => "Novo", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['ufs'] = $this->uf_model
                            ->findAll(); 

        $data['municipios'] = $this->municipio_model
                                    ->findAll(); 

        echo view('templates/header', $data);
        echo view('transportadoras/form');
        echo view('templates/footer');
    }

    public function edit($id_transportadora)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'Nova Transportadora',
            'icone'  => 'fa fa-users'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Transportadoras", 'rota'   => "/transportadoras", 'active' => false],
            ['titulo' => "Editar", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['ufs'] = $this->uf_model
                            ->findAll(); 

        $data['municipios'] = $this->municipio_model
                                    ->findAll(); 

        $data['transportadora'] = $this->transportadora_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_transportadora', $id_transportadora)
                                        ->first();

        echo view('templates/header', $data);
        echo view('transportadoras/form');
        echo view('templates/footer');
    }

    public function store()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $dados = $this->request->getVar();

        // Remove mascara
        $dados['CNPJ'] = removeMascara($dados['CNPJ']);

        // Caso não exista então coloca IE como vazio
        if(!isset($dados['IE'])):
            $dados['IE'] = "";
        endif;

        // Caso a ação seja editar
        if(isset($dados['id_transportadora'])):
            $this->transportadora_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_transportadora', $dados['id_transportadora'])
                ->set($dados)
                ->update();

            $this->session->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Transportadora atualizada com sucesso!'
                ]
            );

            return redirect()->to("/transportadoras/edit/{$dados['id_transportadora']}");
        endif;

        // Caso a ação seja cadastrar
        $dados['id_empresa'] = $this->id_empresa;

        $this->transportadora_model
            ->insert($dados);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Transportadora cadastrada com sucesso!'
            ]
        );

        return redirect()->to('/transportadoras');
    }

    public function delete($id_transportadora)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;
        
        $this->transportadora_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_transportadora', $id_transportadora)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Transportadora excluida com sucesso!'
            ]
        );

        return redirect()->to('/transportadoras');
    }
}

?>