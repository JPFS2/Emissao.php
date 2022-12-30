<?php

namespace App\Controllers;

use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\EmpresaModel;
use App\Models\NFeAvulsaModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\NFCeModel;
use App\Models\NFeModel;

use CodeIgniter\Controller;
use CodeIgniter\Entity\Cast\ArrayCast;
use ZipArchive;

class ControleFiscal extends Controller
{
    private $link = [
        'li' => '9.x',
        'item' => '9.0'
    ];

    private $session;
    private $id_empresa;
    private $id_login;

    private $link_adicional_da_sidebar_model;
    private $emprsa_model;
    private $nfe_avulsa_model;
    private $controle_de_acesso_model;
    private $nfce_model;
    private $nfe_model;

    function __construct()
    {
        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->link_adicional_da_sidebar_model = new LinkAdicionalDaSidebarModel();        
        $this->empresa_model            = new EmpresaModel();
        $this->nfe_avulsa_model         = new NFeAvulsaModel();
        $this->controle_de_acesso_model = new ControleDeAcessoDoUsuarioModel();
        $this->nfce_model               = new NFCeModel();
        $this->nfe_model                = new NFeModel();
    }

    public function nfe()
    {
        // Verifica se tem permissão de acesso
        $permissao = $this->controle_de_acesso_model->verificaPermissao('nfe');

        if ($url = $permissao):
            return redirect()->to($url);
        endif;

        $this->link['subItem'] = '9.4';
        $data['link'] = $this->link;
        
        $data['titulo'] = [
            'modulo' => 'Controle Fiscal',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "NFEs", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $dados = $this->request->getVar();

        // Verifica se o usuário escolheu uma faixa de data
        // Caso não tenha escolhido nenhuma faixa, coloca a data atual e status TODOS
        if(!isset($dados['data_inicio'])):
            
            $dados['data_inicio'] = date('Y-m-d');
            $dados['data_final']  = date('Y-m-d');
            $dados['status']      = "Todas";

        endif;

        if($dados['status'] == "Todas"): // Mostra todas as notas no intervalo selecionado
            $data['nfes'] = $this->nfe_model
                                ->where('nfes.id_empresa', $this->id_empresa)
                                ->where('data >=', $dados['data_inicio'])
                                ->where('data <=', $dados['data_final'])
                                ->join('clientes', 'nfes.id_cliente = clientes.id_cliente')
                                ->select('
                                    nfes.id_nfe,
                                    status,
                                    numero_da_nota,
                                    valor_da_nota,
                                    chave,
                                    data,
                                    hora,
                                    nome AS nome_do_cliente,
                                    id_venda
                                ')
                                ->findAll();

            $data['nfes_avulsa'] = $this->nfe_avulsa_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('data >=', $dados['data_inicio'])
                                        ->where('data <=', $dados['data_final'])
                                        ->findAll();
        elseif($dados['status'] == "Apenas Emitidas"): // Mostra somente as notas EMITIDAS no intervalo selecionado
            $data['nfes'] = $this->nfe_model
                                ->where('nfes.id_empresa', $this->id_empresa)
                                ->where('data >=', $dados['data_inicio'])
                                ->where('data <=', $dados['data_final'])
                                ->where('status', "Emitida")
                                ->join('clientes', 'nfes.id_cliente = clientes.id_cliente')
                                ->select('
                                    nfes.id_nfe,
                                    status,
                                    numero_da_nota,
                                    valor_da_nota,
                                    chave,
                                    data,
                                    hora,
                                    nome AS nome_do_cliente,
                                    id_venda
                                ')
                                ->findAll();

            $data['nfes_avulsa'] = $this->nfe_avulsa_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('data >=', $dados['data_inicio'])
                                        ->where('data <=', $dados['data_final'])
                                        ->where('status', "Emitida")
                                        ->findAll();
        elseif($dados['status'] == "Apenas Canceladas"): // Mostra somente as notas CANCELADAS no intervalo selecionado
            $data['nfes'] = $this->nfe_model
                                ->where('nfes.id_empresa', $this->id_empresa)
                                ->where('data >=', $dados['data_inicio'])
                                ->where('data <=', $dados['data_final'])
                                ->where('status', "Cancelada")
                                ->join('clientes', 'nfes.id_cliente = clientes.id_cliente')
                                ->select('
                                    nfes.id_nfe,
                                    status,
                                    numero_da_nota,
                                    valor_da_nota,
                                    chave,
                                    data,
                                    hora,
                                    nome AS nome_do_cliente,
                                    id_venda
                                ')
                                ->findAll();

            $data['nfes_avulsa'] = $this->nfe_avulsa_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('data >=', $dados['data_inicio'])
                                        ->where('data <=', $dados['data_final'])
                                        ->where('status', "Cancelada")
                                        ->findAll();
        endif;

        $data['data_inicio'] = $dados['data_inicio'];
        $data['data_final']  = $dados['data_final'];
        $data['status']      = $dados['status'];

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'XMLs gerados com sucesso!'
                ]
            );

        echo view('templates/header', $data);
        echo view('controle_fiscal/nfe');
        echo view('templates/footer');
    }

    public function nfce()
    {
        // Verifica se tem permissão de acesso
        $permissao = $this->controle_de_acesso_model->verificaPermissao('nfce');

        if ($url = $permissao):
            return redirect()->to($url);
        endif;

        $this->link['subItem'] = '9.5';
        $data['link'] = $this->link;
                
        $data['titulo'] = [
            'modulo' => 'Controle Fiscal',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "NFCEs", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $dados = $this->request->getVar();

        // Verifica se o usuário escolheu uma faixa de data
        // Caso não tenha escolhido nenhuma faixa, coloca a data atual e status TODOS
        if(!isset($dados['data_inicio'])):
            
            $dados['data_inicio'] = date('Y-m-d');
            $dados['data_final']  = date('Y-m-d');
            $dados['status']      = "Todas";

        endif;

        if($dados['status'] == "Todas"): // Mostra todas as notas no intervalo selecionado
            $data['nfces'] = $this->nfce_model
                                ->where('nfces.id_empresa', $this->id_empresa)
                                ->where('data >=', $dados['data_inicio'])
                                ->where('data <=', $dados['data_final'])
                                ->join('clientes', 'nfces.id_cliente = clientes.id_cliente')
                                ->select('
                                    nfces.id_nfce,
                                    status,
                                    numero_da_nota,
                                    valor_da_nota,
                                    chave,
                                    data,
                                    hora,
                                    nome AS nome_do_cliente,
                                    id_venda
                                ')
                                ->findAll();

        elseif($dados['status'] == "Apenas Emitidas"): // Mostra somente as notas EMITIDAS no intervalo selecionado
            $data['nfces'] = $this->nfce_model
                                ->where('nfces.id_empresa', $this->id_empresa)
                                ->where('data >=', $dados['data_inicio'])
                                ->where('data <=', $dados['data_final'])
                                ->where('status', "Emitida")
                                ->join('clientes', 'nfces.id_cliente = clientes.id_cliente')
                                ->select('
                                    nfces.id_nfce,
                                    status,
                                    numero_da_nota,
                                    valor_da_nota,
                                    chave,
                                    data,
                                    hora,
                                    nome AS nome_do_cliente,
                                    id_venda
                                ')
                                ->findAll();

        elseif($dados['status'] == "Apenas Canceladas"): // Mostra somente as notas CANCELADAS no intervalo selecionado
            $data['nfces'] = $this->nfce_model
                                ->where('nfces.id_empresa', $this->id_empresa)
                                ->where('data >=', $dados['data_inicio'])
                                ->where('data <=', $dados['data_final'])
                                ->where('status', "Cancelada")
                                ->join('clientes', 'nfces.id_cliente = clientes.id_cliente')
                                ->select('
                                    nfces.id_nfce,
                                    status,
                                    numero_da_nota,
                                    valor_da_nota,
                                    chave,
                                    data,
                                    hora,
                                    nome AS nome_do_cliente,
                                    id_venda
                                ')
                                ->findAll();
        endif;

        $data['data_inicio'] = $dados['data_inicio'];
        $data['data_final']  = $dados['data_final'];
        $data['status']      = $dados['status'];

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'XMLs gerados com sucesso!'
                ]
            );

        echo view('templates/header', $data);
        echo view('controle_fiscal/nfce');
        echo view('templates/footer');
    }

    public function baixaXML($id, $tipo)
    {
        if($tipo == 1) : // 1 = NFe
            
            $nfe = $this->nfe_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_nfe', $id)
                        ->first();

            $name = "{$nfe['chave']}.xml";
            $data = $nfe['xml'];
        
        else : // 2 = NFCe
            
            $nfce = $this->nfce_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_nfce', $id)
                        ->first();

            $name = "{$nfce['chave']}.xml";
            $data = $nfce['xml'];
        
        endif;

        return $this->response
                    ->download($name, $data);
    }

    public function baixaXML_Avulsa($id)
    {
        $nfe = $this->nfe_avulsa_model
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_nfe', $id)
                    ->first();

        $name = "{$nfe['chave']}.xml";
        $data = $nfe['xml'];

        return $this->response
                    ->download($name, $data);
    }

    public function baixaXMLS_NFe($data_inicio, $data_final)
    {
        $empresa = $this->empresa_model
                        ->where('id_empresa', $this->id_empresa)
                        ->first();

        $data_inicio_formatada = date('d-m-Y', strtotime($data_inicio));
        $data_final_formatada  = date('d-m-Y', strtotime($data_final));

        $local = "assets/temp_baixar_xmls/XML-de-{$data_inicio_formatada}-ate-{$data_final_formatada}.zip";

        // Apaga se existir.
        if(file_exists($local)) :

            unlink($local);
        
        endif;

        $zip = new ZipArchive();
        $res = $zip->open($local, ZipArchive::CREATE);
     
        if ($res === TRUE) :
            // Adiciona NFes normais
            $nfes = $this->nfe_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('data >=', $data_inicio)
                        ->where('data <=', $data_final)
                        ->findAll();

            foreach($nfes as $nfe) :
                $zip->addFromString("{$nfe['chave']}.xml", $nfe['xml']);
            endforeach;

            // Adiciona NFes Avulsas
            $nfes = $this->nfe_avulsa_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('data >=', $data_inicio)
                        ->where('data <=', $data_final)
                        ->findAll();

            foreach($nfes as $nfe) :
                $zip->addFromString("{$nfe['chave']}.xml", $nfe['xml']);
            endforeach;

            $zip->setArchiveComment('new archive comment');
            $zip->close();

            return $this->response->download($local, NULL);
        else:
            echo 'failed';
        endif;
    }

    public function baixaXMLS_NFCe($data_inicio, $data_final)
    {
        $empresa = $this->empresa_model
                        ->where('id_empresa', $this->id_empresa)
                        ->first();

        $data_inicio_formatada = date('d-m-Y', strtotime($data_inicio));
        $data_final_formatada  = date('d-m-Y', strtotime($data_final));

        $local = "assets/temp_baixar_xmls/XML-de-{$data_inicio_formatada}-ate-{$data_final_formatada}.zip";

        // Apaga se existir.
        if(file_exists($local)) :

            unlink($local);
        
        endif;

        $zip = new ZipArchive();
        $res = $zip->open($local, ZipArchive::CREATE);
     
        if ($res === TRUE) :
            // Adiciona NFes normais
            $nfes = $this->nfce_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('data >=', $data_inicio)
                        ->where('data <=', $data_final)
                        ->findAll();

            foreach($nfes as $nfe) :
                $zip->addFromString("{$nfe['chave']}.xml", $nfe['xml']);
            endforeach;

            $zip->setArchiveComment('new archive comment');
            $zip->close();

            return $this->response->download($local, NULL);
        else:
            echo 'failed';
        endif;
    }

    public function relatorioMonofasico()
    {
        // // Verifica se tem permissão de acesso
        // $permissao = $this->controle_de_acesso_model->verificaPermissao('nfce');

        // if ($url = $permissao):
        //     return redirect()->to($url);
        // endif;

        $this->link['subItem'] = '9.6';
        $data['link'] = $this->link;
                
        $data['titulo'] = [
            'modulo' => 'Relatório Monofasico',
            'icone'  => 'fa fa-database'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Relatório Monofásico", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $dados = $this->request->getVar();

        // Verifica se o usuário escolheu uma faixa de data
        // Caso não tenha escolhido nenhuma faixa, coloca a data atual e status TODOS
        if(!isset($dados['data_inicio'])):
            
            $dados['data_inicio'] = date('Y-m-d');
            $dados['data_final']  = date('Y-m-d');

        endif;

        // ------------------------ NFE
        $nfes = $this->nfe_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('data >=', $dados['data_inicio'])
                            ->where('data <=', $dados['data_final'])
                            ->findAll();

        $cont_produto_nfe = 0;
        $somatorio_nfe = 0;

        foreach($nfes as $nfe):
            $xml = simplexml_load_string($nfe['xml']);

            $json = json_encode($xml);
            $array = json_decode($json);

            $produtos = $array->NFe->infNFe->det;

            foreach($produtos as $produto):
                // Primeiro verifica porq quando é 49 no xml é COFINSOutr
                if(isset($produto->imposto->COFINS->COFINSNT)):
                    if ($produto->imposto->COFINS->COFINSNT->CST == "04") :
                        $cont_produto_nfe += 1;
                        $somatorio_nfe += $produto->prod->vProd;
                    endif;
                endif;
            endforeach;
        endforeach;

        // ------------------------- NFCe
        $nfces = $this->nfce_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('data >=', $dados['data_inicio'])
                            ->where('data <=', $dados['data_final'])
                            ->findAll();

        $cont_produto_nfce = 0;
        $somatorio_nfce = 0;

        foreach ($nfces as $nfce) :
            $xml = simplexml_load_string($nfce['xml']);

            $json = json_encode($xml);
            $array = json_decode($json);

            $produtos = $array->NFe->infNFe->det;

            foreach ($produtos as $produto) :
                if (isset($produto->imposto->COFINS->COFINSNT)) :
                    if ($produto->imposto->COFINS->COFINSNT->CST == "04") :
                        $cont_produto_nfce += 1;
                        $somatorio_nfce += $produto->prod->vProd;
                    endif;
                endif;
            endforeach;
        endforeach;

        // ----------- Mandar para View -------------- //

        $data['cont_produto'] = $cont_produto_nfe + $cont_produto_nfce;
        $data['somatorio'] = $somatorio_nfe + $somatorio_nfce;

        $data['data_inicio'] = $dados['data_inicio'];
        $data['data_final']  = $dados['data_final'];

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Relatório Monofásico gerado com sucesso!'
                ]
            );

        echo view('templates/header', $data);
        echo view('controle_fiscal/relatorio_monofasico');
        echo view('templates/footer');
    }
}
