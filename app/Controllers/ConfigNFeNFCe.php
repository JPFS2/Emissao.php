<?php

namespace App\Controllers;

use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\EmpresaModel;
use CodeIgniter\Controller;

class ConfigNFeNFCe extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $link = [
        'li' => '12.x',
        'item' => '12.0',
        'subItem' => '12.4'
    ];

    private $link_adicional_da_sidebar_model;
    private $controle_de_acesso_model;
    private $empresa_model;

    private $permissao;

    function __construct()
    {
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->helpers = ['app'];

        $this->link_adicional_da_sidebar_model = new LinkAdicionalDaSidebarModel();
        $this->controle_de_acesso_model = new ControleDeAcessoDoUsuarioModel();
        $this->empresa_model            = new EmpresaModel();

        $this->permissao = $this->controle_de_acesso_model->verificaPermissao('config_nfe_e_nfce');
    }

    public function edit()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Configurações NFe e NFCe',
            'icone'  => 'fa fa-user-circle'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/admin/inicio", 'active' => false],
            ['titulo' => "Configuracoes NFe e NFCe", 'rota'   => "", 'active' => true]
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
                                ->first();

        echo view('templates/header', $data);
        echo view('config/form_config_nfe_nfce');
        echo view('templates/footer');
    }

    public function store()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;
        
        $dados = $this->request->getVar();
        $file = $this->request->getFile('file');

        // Verifica se foi selecionado um certificado
        if ($file->isValid()) :
            $empresa = $this->empresa_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->first();

            $local = WRITEPATH . "uploads/certificados/" . $empresa['certificado'];

            if($empresa['certificado'] != "") :
                unlink($local);
            endif;

            $name = date("dmY").date("His").rand(1, 99999999).".pfx";
            $file->store("../../writable/uploads/certificados", $name);

            $dados['certificado'] = $name;
        endif;

        $this->empresa_model
            ->where('id_empresa', $this->id_empresa)
            ->set($dados)
            ->update();

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Dados NFe e NFCe atualizados com sucesso!'
            ]
        );
        
        return redirect()->to('/configNFeNFCe/edit');  
    }
}

?>