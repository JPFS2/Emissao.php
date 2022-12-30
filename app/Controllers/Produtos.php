<?php

namespace App\Controllers;

use App\Database\Migrations\CodigosDeBarrasDosProdutos;
use App\Models\CodigoDeBarraDoProdutoModel;
use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\UfModel;
use App\Models\MunicipioModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\ReposicaoModel;
use App\Models\ProvisorioReposicaoProdutosPorXmlModel;
use App\Models\ProvisorioAddProdutoPorXmlModel;
use App\Models\CategoriasDosProdutosModel;
use App\Models\ProdutoModel;
use App\Models\FornecedorModel;

use CodeIgniter\Controller;

class Produtos extends Controller
{
    private $modulo = 'produtos';

    private $link = [
        'li' => '6.x',
        'item' => '6.0',
        'subItem' => '6.1'
    ];

    private $session;

    private $id_empresa;
    private $id_login;

    private $codigo_de_barra_do_produto_model;
    private $link_adicional_da_sidebar_model;
    private $uf_model;
    private $municipio_model;
    private $controle_de_acesso_model;
    private $reposicao_model;
    private $provisorio_reposicao_produtos_por_xml_model;
    private $provisorio_add_produto_por_xml_model;
    private $produto_model;
    private $categoria_model;
    private $fornecedor_model;

    function __construct()
    {
        $this->helpers = ['app'];

        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->codigo_de_barra_do_produto_model            = new CodigoDeBarraDoProdutoModel();
        $this->link_adicional_da_sidebar_model             = new LinkAdicionalDaSidebarModel();
        $this->uf_model                                    = new UfModel();
        $this->municipio_model                             = new MunicipioModel();
        $this->controle_de_acesso_model                    = new ControleDeAcessoDoUsuarioModel();
        $this->reposicao_model                             = new ReposicaoModel();
        $this->provisorio_reposicao_produtos_por_xml_model = new ProvisorioReposicaoProdutosPorXmlModel();
        $this->provisorio_add_produto_por_xml_model        = new ProvisorioAddProdutoPorXmlModel();
        $this->produto_model                               = new ProdutoModel();
        $this->categoria_model                             = new CategoriasDosProdutosModel();
        $this->fornecedor_model                            = new FornecedorModel();

        $this->permissao = $this->controle_de_acesso_model->verificaPermissao('produtos');
    }

    public function index()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = [
            'li' => '5.x',
            'item' => '5.0',
            'subItem' => '6.1'
        ];

        $data['titulo'] = [
            'modulo' => 'Produtos',
            'icone'  => 'fa fa-box-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Produtos", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $dados = $this->request
                        ->getVar();

        // Caso não exista as variáveis, adiciona string vazia para não dar erro.
        if(!isset($dados['id_produto']) && !isset($dados['nome']) && !isset($dados['codigo_de_barras'])):
            $dados['id_produto'] = "";
            $dados['nome'] = "";
            $dados['codigo_de_barras'] = "";
        endif;
        
        // Verifica se as variáveis são vazias
        // Caso sejam vazias então faz uma busca
        // Caso não sejam vazias, então mostra os 15 últimos cadastrados
        if($dados['id_produto'] == "" && $dados['nome'] == "" && $dados['codigo_de_barras'] == ""):
            
            $data['produtos'] = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->orderBy('id_produto', 'DESC')
                                        ->limit(15)
                                        ->find();

        elseif($dados['id_produto'] != ""):

            $data['produtos'] = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto', $dados['id_produto'])
                                        ->findAll();

            $data['id_produto'] = $dados['id_produto'];

        elseif($dados['nome'] != ""):

            $data['produtos'] = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        // ->where('nome', $dados['nome'])
                                        ->orderBy('nome', 'ASC')
                                        ->like('nome', $dados['nome'])
                                        ->findAll();

            $data['nome'] = $dados['nome'];

        elseif($dados['codigo_de_barras'] != ""):

            if($dados['codigo_de_barras'] != "SEM GTIN"):
                // $data['produtos'] = $this->produto_model
                //                         ->where('id_empresa', $this->id_empresa)
                //                         ->where('codigo_de_barras', $dados['codigo_de_barras'])
                //                         ->findAll();

                $codigos = $this->codigo_de_barra_do_produto_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->where('codigo_de_barra', $dados['codigo_de_barras'])
                                                        ->first();

                if(!empty($codigos)):
                    $produtos = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto', $codigos['id_produto'])
                                        ->findAll();

                    $data['produtos'] = $produtos;
                endif;
            endif;

            $data['codigo_de_barras'] = $dados['codigo_de_barras'];

        endif;

        echo view('templates/header', $data);
        echo view('produtos/index');
        echo view('templates/footer');
    }

    public function pesquisar()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->controle_de_acesso_model->verificaPermissao('pesquisa_produto')):
            return redirect()->to($url);
        endif;

        $data['link'] = [
            'li' => '2.x',
            'item' => '2.0',
            'subItem' => '2.2'
        ];

        $data['titulo'] = [
            'modulo' => 'Pesquisar Produto',
            'icone'  => 'fa fa-box-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Pesq. Produto", 'rota'   => "", 'active' => true]
        ];


        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['produtos'] = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        // Para pesquisa feito pelo nome
        $id_produto = $this->request->getvar('id_produto');
        
        if(isset($id_produto)) :
            $data['produto_pesq'] = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto', $id_produto)
                                        ->first();

            $this->session->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Produto Localizado!'
                ]    
            );

        endif;
        
        // Para pesquisa feito pelo codigo de barras
        $codigo_de_barras = $this->request->getvar('codigo_de_barras');
        
        if (isset($codigo_de_barras)) :

            $codigo_de_barra = $this->codigo_de_barra_do_produto_model
                                                                ->where('codigo_de_barra', $codigo_de_barras)
                                                                ->first();

            if(!empty($codigo_de_barra)):
                $produto = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_produto', $codigo_de_barra['id_produto'])
                                ->first();
                
                if(isset($produto['id_produto'])) :
                    $data['produto_pesq'] = $produto;
                    
                    $this->session->setFlashdata(
                        'alert',
                        [
                            'type'  => 'success',
                            'title' => 'Produto localizado!'
                        ]    
                    );
                else :
                    $this->session->setFlashdata(
                        'alert',
                        [
                            'type'  => 'warning',
                            'title' => 'Produto não localizado! Verifique o código de barras.'
                        ]    
                    );
                endif;
            else:
                $this->session->setFlashdata(
                    'alert',
                    [
                        'type'  => 'warning',
                        'title' => 'Produto não localizado! Verifique o código de barras.'
                    ]
                );
            endif;
        endif;

        echo view('templates/header', $data);
        echo view('produtos/pesquisar');
        echo view('templates/footer');
    }

    public function show($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = [
            'li' => '5.x',
            'item' => '5.0',
            'subItem' => '6.1'
        ];

        $data['titulo'] = [
            'modulo' => 'Dados do Produto',
            'icone'  => 'fa fa-edit'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Produtos", 'rota' => "/produtos", 'active' => false],
            ['titulo' => "Dados", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['produto'] = $this->produto_model
            ->select('
                produtos.nome AS nome_do_produto,
                categorias_dos_produtos.nome AS nome_da_categoria_do_produto,
                fornecedores.nome_do_representante AS nome_do_representante,
                fornecedores.nome_da_empresa AS nome_da_empresa,
                unidade,
                localizacao,
                quantidade,
                quantidade_minima,
                margem_de_lucro,
                valor_de_custo,
                valor_de_venda,
                lucro, arquivo,
                NCM,
                CSOSN,
                CFOP_NFe,
                CFOP_NFCe,
                CFOP_Externo,
                validade,
                tipo_da_comissao,
                porcentagem_comissao,
                valor_comissao,
                porcentagem_icms,
                pis_cofins,
                controlar_estoque
            ')
            ->join('categorias_dos_produtos', 'categorias_dos_produtos.id_categoria = produtos.id_categoria')
            ->join('fornecedores', 'fornecedores.id_fornecedor = produtos.id_fornecedor')
            ->where('produtos.id_produto', $id_produto)
            ->first();

        $data['codigos_de_barras'] = $this->codigo_de_barra_do_produto_model
                                                                ->where('id_empresa', $this->id_empresa)
                                                                ->where('id_produto', $id_produto)
                                                                ->findAll();

        echo view('templates/header', $data);
        echo view('produtos/show');
        echo view('templates/footer');
    }

    public function create()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = [
            'li' => '5.x',
            'item' => '5.0',
            'subItem' => '6.1'
        ];
        
        $data['titulo'] = [
            'modulo' => 'Novo Produto',
            'icone'  => 'fa fa-plus-circle'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Produtos", 'rota' => "/produtos", 'active' => false],
            ['titulo' => "Novo", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['categorias'] = $this->categoria_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        $data['fornecedores'] = $this->fornecedor_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        echo view('templates/header', $data);
        echo view('produtos/form');
        echo view('templates/footer');
    }

    public function edit($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = [
            'li' => '5.x',
            'item' => '5.0',
            'subItem' => '6.1'
        ];
        
        $data['titulo'] = [
            'modulo' => 'Editar Produto',
            'icone'  => 'fa fa-edit'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Produtos", 'rota' => "/produtos", 'active' => false],
            ['titulo' => "Editar", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['produto'] = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_produto', $id_produto)
                                ->first();

        $data['codigos_de_barras'] = $this->codigo_de_barra_do_produto_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->where('id_produto', $id_produto)
                                                        ->findAll();

        $data['categorias'] = $this->categoria_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        $data['fornecedores'] = $this->fornecedor_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->findAll();

        $data['id_produto'] = $id_produto;

        echo view('templates/header', $data);
        echo view('produtos/form');
        echo view('templates/footer');
    }

    public function store()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $file = $this->request
                        ->getFile('arquivo');

        $dados = $this->request
                            ->getvar();

        // Verifica se controlar estoque
        if($dados['controlar_estoque'] == 2):
            $dados['quantidade'] = 0;
            $dados['quantidade_minima'] = 0;
        endif;

        // Converte valores de BRL para USD
        $dados['margem_de_lucro']      = converteMoney($dados['margem_de_lucro']);
        $dados['valor_de_custo']       = converteMoney($dados['valor_de_custo']);
        $dados['valor_de_venda']       = converteMoney($dados['valor_de_venda']);
        $dados['lucro']                = converteMoney($dados['lucro']);
        $dados['porcentagem_comissao'] = converteMoney($dados['porcentagem_comissao']);
        $dados['valor_comissao']       = converteMoney($dados['valor_comissao']);

        // Remove Mascaras
        $dados['NCM']          = removeMascara($dados['NCM']);
        $dados['CFOP_NFe']     = removeMascara($dados['CFOP_NFe']);
        $dados['CFOP_NFCe']    = removeMascara($dados['CFOP_NFCe']);
        $dados['CFOP_Externo'] = removeMascara($dados['CFOP_Externo']);

        // Verifica código de barras
        if(!isset($dados['codigo_de_barras'])):
            $dados['codigo_de_barras'] = "SEM GTIN";
        endif;

        // Verifica se foi selecionado uma imagem, e atribui ao array o nome do arquivo depois de movido para a pasta.
        if ($file->isValid()) :

            // Se a ação for editar, e se foi selecionado uma foto para trocar, então remove a que já existe e cadastra a nova
            if(isset($dados['id_produto'])) :
            
                $produto = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_produto', $dados['id_produto'])
                                ->first();

                if($produto['arquivo'] != "") :
                    
                    unlink("assets/img/produtos/{$produto['arquivo']}");
                
                endif;
            
            endif;

            $name = $file->getRandomName();
            $file->store('../../public/assets/img/produtos/', $name);

            $dados['arquivo'] = $name;

        endif;

        // Caso a ação seja editar
        if(isset($dados['id_produto'])) :
            $this->produto_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto', $dados['id_produto'])
                ->set($dados)
                ->update();

            $this->session->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Produto atualizado com sucesso!',
                ]
            );

            return redirect()->to("/produtos/edit/{$dados['id_produto']}");
        endif;

        // Caso a ação seja cadastrar
        $dados['id_empresa'] = $this->id_empresa;

        $id_produto = $this->produto_model
                                ->insert($dados);

        // Redireciona para cadastrar os códigos de barras
        // Caso haja
        return redirect()->to(base_url("produtos/openCodeBar/$id_produto"));
    }

    public function openCodeBar($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = [
            'li' => '5.x',
            'item' => '5.0',
            'subItem' => '6.1'
        ];

        $data['titulo'] = [
            'modulo' => 'Produtos',
            'icone'  => 'fa fa-box-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Produtos", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['id_produto'] = $id_produto;

        echo View('templates/header', $data);
        echo View('produtos/abrir_modal_codigo_de_barras');
        echo View('templates/footer');
    }

    public function storeCadastroCodigoDeBarras($id_produto, $opcao)
    {
        // Caso a opção seja 0=Não somente emite um alerta e redireciona
        if($opcao == "0"):
            $this->session
                ->setFlashdata(
                    'alert',
                    [
                        'type'  => 'success',
                        'title' => 'Produto cadastrado com sucesso!'
                    ]
                );

            return redirect()->to(base_url('produtos'));
        endif;

        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $data['link'] = [
            'li' => '5.x',
            'item' => '5.0',
            'subItem' => '6.1'
        ];

        $data['titulo'] = [
            'modulo' => 'Cadastro de Código de Barra',
            'icone'  => 'fa fa-box-open'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Cadastro de Código de Barra", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['codigos_de_barras'] = $this->codigo_de_barra_do_produto_model
                                                                    ->where('id_empresa', $this->id_empresa)
                                                                    ->where('id_produto', $id_produto)
                                                                    ->findAll();

        $data['id_produto'] = $id_produto;

        echo View('templates/header', $data);
        echo View('produtos/cadastrar_codigos_de_barra');
        echo View('templates/footer');
    }

    public function storeCadastraCodigoDeBarras($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request
                        ->getVar();

        // Adiciona ao array
        $dados['id_empresa'] = $this->id_empresa;
        $dados['id_produto'] = $id_produto;
        
        $this->codigo_de_barra_do_produto_model
                                    ->insert($dados);

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Código de Barra cadastrado com sucesso!'
                ]
            );

        return redirect()->to(base_url("produtos/storeCadastroCodigoDeBarras/$id_produto/1"));
    }

    public function deleteCodigoDeBarra($id_produto, $id_codigo)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $this->codigo_de_barra_do_produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto', $id_produto)
                                        ->where('id_codigo', $id_codigo)
                                        ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Código de Barra excluido com sucesso!'
                ]
            );

        return redirect()->to(base_url("produtos/storeCadastroCodigoDeBarras/$id_produto/1"));
    }

    // -------------------------- CADASTRO DE PRODUTOS POR XML ------------------------------------ //

    public function add_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        // Remove todos os registros da tabela só para ter certeza que ela estará vazia
        $this->provisorio_add_produto_por_xml_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->delete();

        $file = $this->request->getFile('xml');
        $xml  = simplexml_load_file($file);

        $emitente_da_xml = $xml->NFe->infNFe->emit;

        $fornecedor = $this->fornecedor_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('cnpj', $emitente_da_xml->CNPJ)
                                ->join('ufs', 'fornecedores.id_uf = ufs.id_uf')
                                ->join('municipios', 'fornecedores.id_municipio = municipios.id_municipio')
                                ->first();

        if(empty($fornecedor)) // Verifica se o fornecedor existe, se não existir ele será cadastrado provisoriamente e espera a ação do usuário.
        {
            $municipio = $this->municipio_model
                            ->where('codigo', $emitente_da_xml->enderEmit->cMun)
                            ->first();

            $uf = $this->uf_model
                        ->where('id_uf', $municipio['id_uf'])
                        ->first();

            $id_fornecedor = $this->fornecedor_model->insert([
                'nome_do_representante' => $emitente_da_xml->xNome,
                'nome_da_empresa'       => $emitente_da_xml->xFant,
                'cnpj'                  => $emitente_da_xml->CNPJ,
                'ie'                    => $emitente_da_xml->IE,
                'cep'                   => $emitente_da_xml->enderEmit->CEP,
                'logradouro'            => $emitente_da_xml->enderEmit->xLgr,
                'numero'                => $emitente_da_xml->enderEmit->nro,
                'complemento'           => $emitente_da_xml->enderEmit->xCpl,
                'bairro'                => $emitente_da_xml->enderEmit->xBairro,
                'municipio'             => $emitente_da_xml->enderEmit->xMun,
                'comercial'             => $emitente_da_xml->enderEmit->fone,
                'anotacoes'             => "Fornecedor cadastrado por XML",
                'id_uf'                 => $uf['id_uf'],
                'id_municipio'          => $municipio['id_municipio'],
                'id_empresa'            => $this->id_empresa
            ]);

            // Pega os dados do fornecedor cadastrado
            $fornecedor = $this->fornecedor_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_fornecedor', $id_fornecedor)
                                ->join('ufs', 'fornecedores.id_uf = ufs.id_uf')
                                ->join('municipios', 'fornecedores.id_municipio = municipios.id_municipio')
                                ->first();

            // Informa com a variável que foi cadastrado o fornecedor
            $acao_cad_fornecedor = TRUE;
        }

        // Pega 1ª categoria cadastrada
        $categoria = $this->categoria_model
                                    ->first();
        
        if(empty($categoria)):
            $this->session
                ->setFlashdata(
                    'alert',
                    [
                        'type'  => 'warning',
                        'title' => 'Para cadastrar produtos pelo XML é preciso ter pelo menos uma categoria de produtos cadastrada!'
                    ]
                );

            return redirect()->to(base_url('produtos'));
        endif;
        // ----------- //

        foreach($xml->NFe->infNFe->det as $item)
        {
            $this->provisorio_add_produto_por_xml_model->insert([
                'nome'              => $item->prod->xProd,
                'unidade'           => $item->prod->uCom,
                'codigo_de_barras'  => $item->prod->cEAN,
                'quantidade'        => $item->prod->qCom,
                'quantidade_minima' => 1,
                'valor_de_custo'    => $item->prod->vUnCom,
                'NCM'               => $item->prod->NCM,
                'CSOSN'             => $item->prod->CSOSN,
                'CFOP_NFe'          => $item->prod->CFOP,
                'CFOP_NFCe'         => $item->prod->CFOP,
                'CFOP_Externo'      => $item->prod->CFOP,
                'id_categoria'      => $categoria['id_categoria'],
                'id_fornecedor'     => $fornecedor['id_fornecedor'],
                'id_empresa'        => $this->id_empresa
            ]);
        }

        if(isset($acao_cad_fornecedor)) // Se foi cadastrado motra para o usuário se ele quer cadastrar esse fornecedor, se não ele remove e altera o id_funcionario
        {
            $data['link'] = $this->link;

            $data['titulo'] = [
                'modulo' => 'Editar Produto',
                'icone'  => 'fa fa-edit'
            ];

            $data['caminhos'] = [
                ['titulo' => "Dashboard", 'rota' => "/dashboard", 'active' => false],
                ['titulo' => "Produtos", 'rota' => "/produtos", 'active' => false],
                ['titulo' => "Editar", 'rota'   => "", 'active' => true]
            ];

            $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

            $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

            $data['fornecedor'] = $fornecedor;

            echo View('templates/header', $data);
            echo View('produtos/acao_add_fornecedor_por_xml');
            echo View('templates/footer');
        }
        else
        {
            return redirect()->to("/produtos/provisorio_add_produtos_por_xml");
        }
    }

    public function remove_fornecedor_cadastrado_por_xml($id_fornecedor)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        // Pega todos os produtos da xml que foram cadastrados na tabela provisoria
        $produtos = $this->provisorio_add_produto_por_xml_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->findAll();

        $fornecedor = $this->fornecedor_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('nome_do_representante', 'GERAL')
                            ->first();

        // Caso não exita um fornecedor chamado de GERAL por algum motivo então cadastra ele 
        if(empty($fornecedor)):
            $this->fornecedor_model
                ->insert([
                    'nome_do_representante' => 'GERAL',
                    'nome_da_empresa'       => 'Não possui',
                    'cnpj'                  => 'Não possui',
                    'id_uf'                 => 17,
                    'id_municipio'          => 399,
                    'id_empresa'            => $this->id_empresa
                ]);
        endif;
        // ------------------ //

        // Altera todas os id_fornecedor para fornecedor GERAL
        foreach($produtos as $produto)
        {
            $this->provisorio_add_produto_por_xml_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto_provisorio', $produto['id_produto_provisorio'])
                ->set('id_fornecedor', $fornecedor['id_fornecedor'])
                ->update();
        }

        // Remove o fornecedor
        $this->fornecedor_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_fornecedor', $id_fornecedor)
            ->delete();

        return redirect()->to('/produtos/provisorio_add_produtos_por_xml');
    }

    public function provisorio_add_produtos_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Finalize as informações dos produtos',
            'icone'  => 'fa fa-plus-circle'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Produtos", 'rota' => "/produtos", 'active' => false],
            ['titulo' => "Cad. por XML", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['produtos'] = $this->provisorio_add_produto_por_xml_model
                                                                ->where('id_empresa', $this->id_empresa)
                                                                ->findAll();

        $data['categorias'] = $this->categoria_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();

        echo View('templates/header', $data);
        echo View('produtos/provisorio_add_produtos_por_xml');
        echo View('templates/footer');
    }

    public function altera_dados_do_produto_provisorio_cad_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $dados = $this->request->getvar();

        // Converte de BRL para USD
        $dados['valor_de_custo'] = converteMoney($dados['valor_de_custo']);
        $dados['valor_de_venda'] = converteMoney($dados['valor_de_venda']);
        $dados['lucro']          = converteMoney($dados['lucro']);

        // Remove Mascaras
        $dados['NCM']          = removeMascara($dados['NCM']);
        $dados['CFOP_NFe']     = removeMascara($dados['CFOP_NFe']);
        $dados['CFOP_NFCe']    = removeMascara($dados['CFOP_NFCe']);
        $dados['CFOP_Externo'] = removeMascara($dados['CFOP_Externo']);

        // Porcentagem
        if($dados['tipo_da_comissao'] == 1):
            $dados['valor_comissao'] = 0;
        else:
            $dados['porcentagem_comissao'] = 0;
        endif;
        
        $this->provisorio_add_produto_por_xml_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_provisorio', $dados['id_produto_provisorio'])
            ->set($dados)
            ->update();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => "Dados do Produto atualizados com sucesso!"
                ]
            );

        return redirect()->to("/produtos/provisorio_add_produtos_por_xml/#prod_{$dados['id_produto_provisorio']}");
    }

    public function finalizar_e_cadastrar_produtos_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        // Pega todos os produtos da tabela provisorio_add_produto_por_xml_model e insere na tabela de produtos
        $produtos_provisorio = $this->provisorio_add_produto_por_xml_model
                                                                    ->where('id_empresa', $this->id_empresa)
                                                                    ->findAll();

        foreach($produtos_provisorio as $produto)
        {
            $this->produto_model
                ->insert($produto);
        }

        // Remove todos os registros da tabela provisorio_add_produto_por_xml_model
        $this->provisorio_add_produto_por_xml_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // Cria uma mensagem de alerta
        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Produtos do XML cadastrados com sucesso!'
                ]
            );

        // Redireciona para a página de produtos
        return redirect()->to('/produtos');
    }

    // -------------------------- REPOSIÇÃO DE PRODUTOS POR XML ------------------------------------ //

    public function reposicao_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        // Remove todos os registros da tabela só para ter certeza que ela estará vazia
        $this->provisorio_reposicao_produtos_por_xml_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->delete();

        $file = $this->request->getFile('xml');
        $xml  = simplexml_load_file($file);

        foreach($xml->NFe->infNFe->det as $item)
        {
            // Verifica se possui código de barras
            if($item->prod->cEAN != "SEM GTIN"):
                $produto = $this->produto_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('codigo_de_barras', $item->prod->cEAN)
                            ->first();
            else:
                $produto = [];
            endif;

            if(!empty($produto)) // Se o produto existir coloca o nome dele para repor
            {
                $this->provisorio_reposicao_produtos_por_xml_model
                    ->insert([
                        'nome'                    => $produto['nome'],
                        'quantidade_da_reposicao' => $item->prod->qCom,
                        'id_produto'              => $produto['id_produto'],
                        'id_empresa'              => $this->id_empresa
                    ]);
            }
            else // Caso não exista, o usuário terá que escolher o produto para repor
            {
                $this->provisorio_reposicao_produtos_por_xml_model
                    ->insert([
                        'nome'                    => $item->prod->xProd,
                        'quantidade_da_reposicao' => $item->prod->qCom,
                        'id_produto'              => 0, // Zero para informar que o produto não foi localizado
                        'id_empresa'              => $this->id_empresa
                    ]);
            }
        }

        return redirect()->to('/produtos/provisorio_reposicao_produtos_por_xml');
    }

    public function provisorio_reposicao_produtos_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $data['link'] = $this->link;

        $data['titulo'] = [
            'modulo' => 'Produtos da Reposição',
            'icone'  => 'fa fa-plus-circle'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Reposições", 'rota' => "/reposicoes", 'active' => false],
            ['titulo' => "Reposição por XML", 'rota'   => "", 'active' => true]
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

        $data['produtos'] = $this->provisorio_reposicao_produtos_por_xml_model
                                                                        ->where('id_empresa', $this->id_empresa)
                                                                        ->findAll();

        echo View('templates/header', $data);
        echo View('produtos/provisorio_reposicao_produtos_por_xml');
        echo View('templates/footer');
    }

    public function altera_dados_do_produto_provisorio_reposicao_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $dados = $this->request
                        ->getvar();
        
        $this->provisorio_reposicao_produtos_por_xml_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_produto_provisorio', $dados['id_produto_provisorio'])
                                ->set($dados)
                                ->update();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Quantidade alterada com sucesso!'
                ]
            );

        return redirect()->to("/produtos/provisorio_reposicao_produtos_por_xml/#prod_{$dados['id_produto_provisorio']}");
    }

    public function finalizar_e_repoe_produtos_por_xml()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $produtos_provisorio = $this->provisorio_reposicao_produtos_por_xml_model
                                                                            ->where('id_empresa', $this->id_empresa)
                                                                            ->findAll();

        foreach($produtos_provisorio as $prod_prov)
        {
            $id_produto = $prod_prov['id_produto']; // Id_produto

            $produto_do_estoque = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto', $id_produto)
                                        ->first(); // Pega o produto do estoque

            $quantidade = $produto_do_estoque['quantidade'] + $prod_prov['quantidade_da_reposicao']; // Soma a quantidade do produto do estoque com o da reposição

            $this->produto_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto', $id_produto)
                ->set('quantidade', $quantidade)
                ->update();

            $dados_da_reposicao = [
                'data'        => date('Y-m-d'),
                'hora'        => date('H:i:s'),
                'quantidade'  => $prod_prov['quantidade_da_reposicao'],
                'observacoes' => "Reposição do produto feita por XML",
                'id_produto'  => $id_produto,
                'id_empresa'  => $this->id_empresa
            ];

            $this->reposicao_model
                    ->insert($dados_da_reposicao);
        }

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Reposição cadastrada com sucesso!'
                ]
            );

        return redirect()->to("/reposicoes");
    }

    public function remove_produto_reposicao_por_xml($id_produto_provisorio)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $this->provisorio_reposicao_produtos_por_xml_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_provisorio', $id_produto_provisorio)
            ->delete();

        // --------------------- //
        // Verifica se todos os produtos da reposição com xml foram excluidos
        // se sim, cria um alerta e redireciona.
        $produtos_provisorio = $this->provisorio_reposicao_produtos_por_xml_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->find();

        if(empty($produtos_provisorio)):

            $this->session
                ->setFlashdata(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Todos os produtos da reposição com XML foi excluidos, faça o processo novamente!'
                    ]
                );

            return redirect()->to('/reposicoes');

        endif;
        // -------------------- //

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Produto excluido com sucesso!'
                ]
            );

        $id_aux = $id_produto_provisorio +1;

        return redirect()->to("/produtos/provisorio_reposicao_produtos_por_xml/#prod_$id_aux");
    }

    // --------------------------------------------------------------------------------------------- //

    public function delete($id_produto)
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        // Verifica se tem permissão de acesso
        if ($url = $this->permissao):
            return redirect()->to($url);
        endif;

        $produto = $this->produto_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto', $id_produto)
                        ->first();

        // Caso o produto tenha imagem, exclui ela.
        if($produto['arquivo'] != "") :
            unlink("assets/img/produtos/{$produto['arquivo']}");
        endif;

        $this->produto_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto', $id_produto)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Produto excluido com sucesso!',
            ]
        );

        return redirect()->to('/produtos');
    }

    // public function removerImagem($id_produto)
    // {
    //     $produto = $this->produto_model->where('id_produto', $id_produto)->first();
    //     $foto = $produto['arquivo'];

    //     $session = session();
    //     if(unlink("assets/img/produtos/$foto"))
    //     {
    //         $this->produto_model->set('arquivo', "")->where('id_produto', $id_produto)->update();

    //         $session->setFlashdata('alert', 'success_remove_image');
    //         return redirect()->to("/produtos/edit/$id_produto");
    //     }

    //     $session->setFlashdata('alert', 'error_remove_image');

    //     return redirect()->to("/produtos/edit/$id_produto");
    // }

    public function adicionaMargemDeLucroEmTodosOsProdutos()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;

        $margem_de_lucro = $this->request->getVar('margem_de_lucro');
        
        // Atualiza a margem de lucro de todos os produtos de uma vez
        $this->provisorio_add_produto_por_xml_model
            ->where('id_empresa', $this->id_empresa)
            ->set('margem_de_lucro', $margem_de_lucro)
            ->update();

        // Recupera todos os produtos provisorio da empresa
        $produtos_provisorio = $this->provisorio_add_produto_por_xml_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->find();

        foreach($produtos_provisorio as $produto):
            // ----- Calcula e atualizada o valor da venda ----- //
            $valor_de_venda = $produto['valor_de_custo'] + ($produto['valor_de_custo'] * $margem_de_lucro / 100);

            $this->provisorio_add_produto_por_xml_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto_provisorio', $produto['id_produto_provisorio'])
                ->set('valor_de_venda', $valor_de_venda)
                ->update();

            // ----- Calcula e atualizada o lucro ----- //
            $lucro = $valor_de_venda - $produto['valor_de_custo'];

            $this->provisorio_add_produto_por_xml_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto_provisorio', $produto['id_produto_provisorio'])
                ->set('lucro', $lucro)
                ->update();
        endforeach;

        // Emite um alerta informando que foi sucesso!
        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => "success",
                    'title' => "Margem de lucro dos produtos atualizada com sucesso!"
                ]
            );
    }

    public function adicionaComissaoEmTodosOsProdutos()
    {
        // Verifica se tem permissão de acesso
        if ($url = $this->permissao) :
            return redirect()->to($url);
        endif;
        
        $dados = $this->request->getVar();

        // Converte de BRL para USD
        $dados['porcentagem_valor_all'] = converteMoney($dados['porcentagem_valor_all']);

        // Faz uma verificação para saber qual o tipo escolhido
        if($dados['tipo_da_comissao'] == 1):
            $porcentagem_comissao = $dados['porcentagem_valor_all'];
            $valor_comissao = 0;
        else:
            $porcentagem_comissao = 0;
            $valor_comissao = $dados['porcentagem_valor_all'];
        endif;

        // Faz as atualizações
        $this->provisorio_add_produto_por_xml_model
            ->where('id_empresa', $this->id_empresa)
            ->set([
                'tipo_da_comissao'     => $dados['tipo_da_comissao'],
                'porcentagem_comissao' => $porcentagem_comissao,
                'valor_comissao'       => $valor_comissao
            ])
            ->update();

        // Emite um alerta informando que foi sucesso!
        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => "success",
                    'title' => "Comissão dos produtos atualizada com sucesso!"
                ]
            );
    }

    public function add_por_csv()
    {
        $csv = $this->request
                        ->getFile('csv');

        // $string = file_get_contents($csv);

        // $linhas = explode('\n', $string);

        // dd($linhas);

        $id_categoria = $this->categoria_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->select('id_categoria')
                                        ->first()['id_categoria'];

        $id_fornecedor = $this->fornecedor_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->select('id_fornecedor')
                                            ->first()['id_fornecedor'];

        $array_formatado = [];

        $file = fopen($csv, 'r');
        
        while (($line = fgetcsv($file, 0, ';', '"', '\\')) !== false) {
            $array_provisorio = [];

            $array_provisorio['nome'] = $line[0];

            // Converte para double QUANTIDADE
            $array_provisorio['quantidade'] = converteMoney($line[1]);

            // Converte para double QUANTIDADE MINIMA
            $array_provisorio['quantidade_minima']= converteMoney($line[2]);

            // Separa o R$ e converte para double
            $aux = explode("R$", $line[3]);

            if (isset($aux[1])) :
                $valor_de_custo = converteMoney($aux[1]);
            else :
                $valor_de_custo = converteMoney($aux[0]);
            endif;

            $array_provisorio['valor_de_custo'] = $valor_de_custo;

            // Converte para double MARGEM DE LUCRO
            $margem_de_lucro = converteMoney($line[4]);

            $array_provisorio['margem_de_lucro'] = $margem_de_lucro;

            // Adiciona valor de venda
            $valor_de_venda = (($margem_de_lucro * $valor_de_custo / 100) + $valor_de_custo);
            $array_provisorio['valor_de_venda'] = $valor_de_venda;

            // Converte para double TIPO DE COMISSÃO
            $array_provisorio['tipo_da_comissao'] = converteMoney($line[5]);

            // Converte para double PORCENTAGEM_DA_COMISSAO
            $array_provisorio['porcentagem_comissao'] = converteMoney($line[6]);

            // Converte para double VALOR_DA_COMISSAO
            $array_provisorio['valor_comissao'] = converteMoney($line[7]);

            // Adiciona lucro
            $array_provisorio['lucro'] = $valor_de_venda - $valor_de_custo;

            // Adiciona NCM
            $array_provisorio['NCM'] = $line[8];

            // Adiciona CSOSN
            $array_provisorio['CSOSN'] = $line[9];

            // Adiciona CFOP_NFE
            $array_provisorio['CFOP_NFe'] = $line[10];

            // Adiciona CFOP_NFCE
            $array_provisorio['CFOP_NFCe'] = $line[11];

            // Adiciona CFOP_EXTERNO
            $array_provisorio['CFOP_Externo'] = $line[12];

            // Adiciona PIS_COFINS
            if($line[13] == "1" || $line[13] == "2" || $line[13] =="3" || $line[13] == "4" || $line[13] == "5" || $line[13] == "6" || $line[13] == "7" || $line[13] == "8" || $line[13] == "9"):
                $array_provisorio['pis_cofins'] = "0" . $line[13];
            else:
                $array_provisorio['pis_cofins'] = $line[13];
            endif;

            // Adiciona id_categoria ao array
            $array_provisorio['id_categoria'] = $id_categoria;

            // Adiciona id_fornecedor ao array
            $array_provisorio['id_fornecedor'] = $id_fornecedor;

            // Adiciona id_empresa
            $array_provisorio['id_empresa'] = $this->id_empresa;

            // Adiciona Unidade
            $array_provisorio['unidade'] = "UN";

            $array_provisorio['codigo_de_barra'] = $line[14];

            // Controla estoque
            $array_provisorio['controlar_estoque'] = $line[15]; //1=SIM, 2=NÃO

            $array_formatado[] = $array_provisorio;
        }

        fclose($file);

        // ---------- Faz a insersão do array -------------- //
        foreach($array_formatado as $array):
            $id_produto = $this->produto_model
                                        ->insert($array);

            if($array['codigo_de_barra'] != "" || $array['codigo_de_barra'] != 0 || $array['codigo_de_barra'] != "SEM GTIN" || $array['codigo_de_barra'] != " "):
                $this->codigo_de_barra_do_produto_model
                                                ->insert([
                                                    'codigo_de_barra' => $array['codigo_de_barra'],
                                                    'id_empresa' => $this->id_empresa,
                                                    'id_produto' => $id_produto
                                                ]);
            endif;
        endforeach;

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Tabela importada com sucesso!'
                ]
            );

        return redirect()->to(base_url('produtos'));
    }
}
