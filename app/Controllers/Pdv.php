<?php

namespace App\Controllers;

use App\Models\CaixaModel;

use App\Models\CodigoDeBarraDoProdutoModel;
use App\Models\LinkAdicionalDaSidebarModel;
use App\Models\VendaCreditoNaLojaModel;
use App\Models\FormaDePagamentoDaVendaModel;
use App\Models\FormaDePagamentoDoPdvModel;
use App\Models\ControleDeAcessoDoUsuarioModel;
use App\Models\EmpresaModel;
use App\Models\ClienteModel;
use App\Models\FormaDePagamentoModel;
use App\Models\NFCeModel;
use App\Models\ProdutoDaVendaModel;
use App\Models\ProdutoModel;
use App\Models\ProdutoPdvModel;
use App\Models\VendaModel;
use App\Models\VendedorModel;
use CodeIgniter\Controller;

class Pdv extends Controller
{
    private $session;
    private $id_empresa;
    private $id_login;

    private $codigo_de_barra_do_produto_model;
    private $link_adicional_da_sidebar_model;
    private $venda_credito_na_loja_model;
    private $forma_de_pagamento_da_venda_model;
    private $forma_de_pagamento_do_pdv_model;
    private $controle_de_acesso_model;
    private $empresa_model;
    private $produto_model;
    private $produto_pdv_model;
    private $cliente_model;
    private $venda_model;
    private $produto_da_venda_model;
    private $nfce_model;
    private $forma_de_pagamento_model;
    private $vendedor_model;

    function __construct()
    {
        $this->helpers = ['app'];

        // Pega os ID da sessão
        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');
        $this->id_login   = $this->session->get('id_login');

        $this->codigo_de_barra_do_produto_model  = new CodigoDeBarraDoProdutoModel();
        $this->link_adicional_da_sidebar_model   = new LinkAdicionalDaSidebarModel();
        $this->venda_credito_na_loja_model       = new VendaCreditoNaLojaModel();
        $this->forma_de_pagamento_da_venda_model = new FormaDePagamentoDaVendaModel();
        $this->forma_de_pagamento_do_pdv_model   = new FormaDePagamentoDoPdvModel();
        $this->controle_de_acesso_model          = new ControleDeAcessoDoUsuarioModel();
        $this->empresa_model                     = new EmpresaModel();
        $this->produto_model                     = new ProdutoModel();
        $this->produto_pdv_model                 = new ProdutoPdvModel();
        $this->cliente_model                     = new ClienteModel();
        $this->venda_model                       = new VendaModel();
        $this->produto_da_venda_model            = new ProdutoDaVendaModel();
        $this->nfce_model                        = new NFCeModel();
        $this->caixa_model                       = new CaixaModel();
        $this->forma_de_pagamento_model          = new FormaDePagamentoModel();
        $this->vendedor_model                    = new VendedorModel();
    }

    public function index()
    {
        $data['link'] = [
            'li' => '2.x',
            'item' => '2.0',
            'subItem' => '2.6'
        ];

        $data['titulo'] = [
            'modulo' => 'Caixas Abertos',
            'icone'  => 'fa fa-plus-circle'
        ];

        $data['caminhos'] = [
            ['titulo' => "Início", 'rota' => "/inicio", 'active' => false],
            ['titulo' => "Caixas Abertos", 'rota'   => "", 'active' => true]
        ];

        $data['links_adicionais'] = $this->link_adicional_da_sidebar_model
                                                    ->where('id_empresa', $this->id_empresa)
                                                    ->findAll();

        $data['controle_de_acesso'] = $this->controle_de_acesso_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_login', $this->id_login)
                                            ->first();

        $data['caixas'] = $this->caixa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('status', 'Aberto')
                                ->findAll();

        echo view('templates/header', $data);
        echo view('pdv/seleciona_caixa');
        echo view('templates/footer');
    }

    public function start($id_caixa)
    {
        $data['id_caixa'] = $id_caixa;

        $data['clientes'] = $this->cliente_model
                                ->where('id_empresa', $this->id_empresa)
                                ->select(
                                    'id_cliente,
                                    tipo,
                                    nome,
                                    razao_social
                                ')
                                ->findAll();
        
        $data['produtos'] = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->select(
                                    'id_produto,
                                    nome
                                ')
                                ->findAll();
        
        $data['produtos_do_pdv'] = $this->produto_pdv_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->findAll();
        
        $valor_a_pagar = $this->produto_pdv_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->selectSum('valor_final')
                                    ->first();
        
        $data['formas_de_pagamento'] = $this->forma_de_pagamento_model
                                                                ->findAll();

        $data['formas_de_pagamento_do_pdv'] = $this->forma_de_pagamento_do_pdv_model
                                                                    ->where('id_empresa', $this->id_empresa)
                                                                    ->join('formas_de_pagamento', 'formas_de_pagamento_do_pdv.id_forma = formas_de_pagamento.id_forma')
                                                                    ->findAll();

        $data['vendedores'] = $this->vendedor_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();
        
        // ------------- VALOR RECEBIDO
        $somatorio_formas_de_pagamento = $this->forma_de_pagamento_do_pdv_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->selectSum('valor')
                                                        ->first()['valor'];
        if($somatorio_formas_de_pagamento == null):
            $somatorio_formas_de_pagamento = 0;
        endif;
        
        // ------------- RESTANTE
        $restante = $valor_a_pagar['valor_final'] - $somatorio_formas_de_pagamento;

        if($restante < 0):
            $restante = 0;
        endif;

        // ------------- TROCO
        $troco = $somatorio_formas_de_pagamento - $valor_a_pagar['valor_final'];

        if($troco < 0):
            $troco = 0;
        endif;

        // ------------ DESCONTO GERAL
        $desconto_geral = $this->produto_pdv_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->selectSum('desconto')
                                            ->find()[0]['desconto'];

        // ---------------- Mandando para a view       
        $data['somatorio_formas_de_pagamento'] = $somatorio_formas_de_pagamento;
        $data['valor_a_pagar'] = $valor_a_pagar;
        $data['restante'] = $restante;
        $data['troco'] = $troco;
        $data['desconto_geral'] = $desconto_geral;

        echo view('pdv/start', $data);
    }

    public function adicionaProdutoPorCodigoDeBarras($id_caixa)
    {
        $dados = $this->request
                        ->getvar('codigo_de_barras');

        // Separa a quantidade do codigo de barras
        $aux = explode('x', $dados);

        // Caso exista aux na posição 1 então quer dizer que foi separado o x dos valores
        if(isset($aux[1])) :
            $quantidade = $aux[0];
            $codigo_de_barras = $aux[1];
        else :
            $quantidade       = 1;
            $codigo_de_barras = $dados;
        endif;

        $cod = $this->codigo_de_barra_do_produto_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('codigo_de_barra', $codigo_de_barras)
                                            ->first();

        if(!empty($cod)) : // Caso não seja vazio então está buscando pelo codigo de barras
            $produto = $this->produto_model
                                    ->select('
                                        id_produto,
                                        nome,
                                        unidade,
                                        valor_de_venda,
                                        NCM,
                                        CSOSN,
                                        CFOP_NFe,
                                        CFOP_NFCe,
                                        CFOP_Externo,
                                        porcentagem_icms,
                                        pis_cofins
                                    ')
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_produto', $cod['id_produto'])
                                    ->first();
            
            $valor_unitario = $produto['valor_de_venda'];
            $subtotal       = $quantidade * $valor_unitario;
            $desconto       = 0;
            $valor_final    = $subtotal - $desconto;

            $this->produto_pdv_model->insert([
                'nome'             => $produto['nome'],
                'unidade'          => $produto['unidade'],
                'codigo_de_barras' => $cod['codigo_de_barra'],
                'quantidade'       => $quantidade,
                'valor_unitario'   => $valor_unitario,
                'subtotal'         => $subtotal,
                'desconto'         => $desconto,
                'valor_final'      => $valor_final,
                'NCM'              => $produto['NCM'],
                'CSOSN'            => $produto['CSOSN'],
                'CFOP_NFe'         => $produto['CFOP_NFe'],
                'CFOP_NFCe'        => $produto['CFOP_NFCe'],
                'CFOP_Externo'     => $produto['CFOP_Externo'],
                'porcentagem_icms' => $produto['porcentagem_icms'],
                'pis_cofins'       => $produto['pis_cofins'],
                'id_produto'       => $produto['id_produto'],
                'id_empresa'       => $this->id_empresa
            ]);

            $this->session->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Produto adicionado com sucesso!'
                ]
            );

            return redirect()->to("/pdv/start/$id_caixa");

        else: // Caso esteja buscando pelo id_produto

            $produto = $this->produto_model
                        ->select('
                            id_produto,
                            nome,
                            unidade,
                            valor_de_venda,
                            NCM,
                            CSOSN,
                            CFOP_NFe,
                            CFOP_NFCe,
                            CFOP_Externo,
                            porcentagem_icms,
                            pis_cofins
                        ')
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto', $codigo_de_barras)
                        ->first();

            if(!empty($produto)): // Verifica se o produto foi encontrado
                // Pega o código de barras do produto
                $cod = $this->codigo_de_barra_do_produto_model
                                                        ->where('id_empresa', $this->id_empresa)
                                                        ->where('id_produto', $produto['id_produto'])
                                                        ->first();

                if($cod == null):
                    $codigo_de_barras = "SEM GTIN";
                else:
                    $codigo_de_barras = $cod['codigo_de_barra'];
                endif;

                $valor_unitario = $produto['valor_de_venda'];
                $subtotal       = $quantidade * $valor_unitario;
                $desconto       = 0;
                $valor_final    = $subtotal - $desconto;

                $this->produto_pdv_model->insert([
                    'nome'             => $produto['nome'],
                    'unidade'          => $produto['unidade'],
                    'codigo_de_barras' => $codigo_de_barras,
                    'quantidade'       => $quantidade,
                    'valor_unitario'   => $valor_unitario,
                    'subtotal'         => $subtotal,
                    'desconto'         => $desconto,
                    'valor_final'      => $valor_final,
                    'NCM'              => $produto['NCM'],
                    'CSOSN'            => $produto['CSOSN'],
                    'CFOP_NFe'         => $produto['CFOP_NFe'],
                    'CFOP_NFCe'        => $produto['CFOP_NFCe'],
                    'CFOP_Externo'     => $produto['CFOP_Externo'],
                    'porcentagem_icms' => $produto['porcentagem_icms'],
                    'pis_cofins'       => $produto['pis_cofins'],
                    'id_produto'       => $produto['id_produto'],
                    'id_empresa'       => $this->id_empresa
                ]);

                $this->session->setFlashdata(
                    'alert',
                    [
                        'type'  => 'success',
                        'title' => 'Produto adicionado com sucesso!'
                    ]
                );

                return redirect()->to("/pdv/start/$id_caixa");
            endif;

        endif;

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'warning',
                'title' => 'Produto com código informado não encontrado!'
            ]
        );

        return redirect()->to("/pdv/start/$id_caixa");
    }

    public function adicionaProdutoPorNome($id_caixa, $id_produto)
    {
        $produto = $this->produto_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto', $id_produto)
                        ->select('
                            id_produto,
                            nome,
                            unidade,
                            valor_de_venda,
                            NCM,
                            CSOSN,
                            CFOP_NFe,
                            CFOP_NFCe,
                            CFOP_Externo,
                            porcentagem_icms,
                            pis_cofins
                        ')
                        ->first();

        $cod = $this->codigo_de_barra_do_produto_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_produto', $produto['id_produto'])
                                            ->first();

        if($cod == null):
            $codigo_de_barras = "SEM GTIN";
        else:
            $codigo_de_barras = $cod['codigo_de_barra'];
        endif;

        $quantidade     = $this->request->getVar('quantidade');
        $valor_unitario = $produto['valor_de_venda'];
        $subtotal       = $quantidade * $valor_unitario;
        $desconto       = 0;
        $valor_final    = $subtotal - $desconto;

        $this->produto_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->insert([
                'nome'             => $produto['nome'],
                'unidade'          => $produto['unidade'],
                'codigo_de_barras' => $codigo_de_barras,
                'quantidade'       => $quantidade,
                'valor_unitario'   => $valor_unitario,
                'subtotal'         => $subtotal,
                'desconto'         => $desconto,
                'valor_final'      => $valor_final,
                'NCM'              => $produto['NCM'],
                'CSOSN'            => $produto['CSOSN'],
                'CFOP_NFe'         => $produto['CFOP_NFe'],
                'CFOP_NFCe'        => $produto['CFOP_NFCe'],
                'CFOP_Externo'     => $produto['CFOP_Externo'],
                'porcentagem_icms' => $produto['porcentagem_icms'],
                'pis_cofins'       => $produto['pis_cofins'],
                'id_produto'       => $produto['id_produto'],
                'id_empresa'       => $this->id_empresa
            ]);

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Produto adicionado com sucesso!'
            ]
        );

        return redirect()->to("/pdv/start/$id_caixa");
    }

    public function listaProdutosPesquisadosPorNome()
    {
        $nome_do_produto = $this->request
                                ->getVar('nome_do_produto');

        $id_caixa = $this->request
                            ->getVar('id_caixa');

        $produtos = $this->produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->orderBy('nome', 'ASC')
                                ->like('nome', $nome_do_produto)
                                ->findAll();

        // Se o array não for vazio então foram encontrados
        // produtos com o nome informado
        if(!empty($produtos)):
            foreach ($produtos as $produto) :
                $valor_do_produto = number_format($produto['valor_de_venda'], 2, ',', '.');
                
                echo "<tr>";
                    echo "<td style='width: 90px'>{$produto['id_produto']}</td>";
                    echo "<td>{$produto['nome']}</td>";
                    echo "<td style='width: 120px'>$valor_do_produto</td>";
                    echo "<td style='width: 90px'>{$produto['quantidade']}</td>";
                    echo "<td><form id=\"form_{$produto['id_produto']}\" action='/pdv/adicionaProdutoPorNome/$id_caixa/{$produto['id_produto']}' method='post'><input type='number' class='form-control' name='quantidade' value='1'></form></td>";
                    echo "
                        <td style='width: 90px'>
                            <button type='button' onclick=\"acionaFormPesquisaProdutoPorNome('form_{$produto['id_produto']}')\" class='btn btn-info style-action'>Add</button>
                        </td>
                        ";
                echo "</tr>";
            endforeach;
        else:
            echo "<tr>";
                echo "<td colspan='5'>Nenhum registro!</td>";
            echo "</tr>";
        endif;
    }

    public function removeProdutoDoPdv($id_caixa, $id_produto_pdv)
    {
        $this->produto_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_pdv', $id_produto_pdv)
            ->delete();

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Produto removido com sucesso!'
            ]
        );

        return redirect()->to("/pdv/start/$id_caixa");
    }

    public function alteraQtdDoProduto($id_caixa)
    {
        $id_produto_pdv = $this->request
                                ->getvar('id_produto_pdv');
        
        $produto = $this->produto_pdv_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto_pdv', $id_produto_pdv)
                        ->first();

        // Prepara os dados para alterar
        $dados = $this->request
                        ->getvar();

        $dados['subtotal'] = ($dados['quantidade'] * $produto['valor_unitario']);
        $dados['valor_final'] = (($dados['quantidade'] * $produto['valor_unitario']) - $produto['desconto']);

        // Atualiza com os novos dados
        $this->produto_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->save($dados);

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Qtd. alterada com sucesso!'
            ]
        );

        return redirect()->to("/pdv/start/$id_caixa");
    }

    public function alteraValorUnitarioDoProduto($id_caixa)
    {
        $id_produto_pdv = $this->request
                                ->getvar('id_produto_pdv');
        
        $produto = $this->produto_pdv_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto_pdv', $id_produto_pdv)
                        ->first();

        // Prepara os dados para alterar
        $dados = $this->request
                        ->getvar();

        // Converte de BRL para USD
        $dados['valor_unitario'] = converteMoney($dados['valor_unitario']);

        $dados['subtotal'] = ($produto['quantidade'] * $dados['valor_unitario']);
        $dados['valor_final'] = (($produto['quantidade'] * $dados['valor_unitario']) - $produto['desconto']);

        // Atualiza com os novos dados
        $this->produto_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_pdv', $id_produto_pdv)
            ->set($dados)
            ->update();

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Valor uniátio alterado com sucesso!'
            ]
        );

        return redirect()->to("/pdv/start/$id_caixa");
    }

    public function alteraDescontoDoProduto($id_caixa)
    {
        $id_produto_pdv = $this->request
                                ->getvar('id_produto_pdv');

        $produto = $this->produto_pdv_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_produto_pdv', $id_produto_pdv)
                        ->first();

        // Prepara os dados para alterar
        $dados = $this->request
                        ->getvar();

        // Converte de BRL para USD
        $dados['desconto'] = converteMoney($dados['desconto']);

        $dados['valor_final'] = (($produto['quantidade'] * $produto['valor_unitario']) - $dados['desconto']);

        // Atualiza com os novos dados
        $this->produto_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_produto_pdv', $id_produto_pdv)
            ->set($dados)
            ->update();

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Desconto alterado com sucesso!'
            ]
        );

        return redirect()->to("/pdv/start/$id_caixa");
    }

    public function format($valor)
    {
        return number_format($valor, 2, '.', '');
    }

    public function finalizaVenda($id_caixa)
    {
        $dados = $this->request->getvar();

        // Adiciona data e hora da venda
        $dados['data']     = date('Y-m-d');
        $dados['hora']     = date('H:i:s');
        $dados['id_caixa'] = $id_caixa;

        // Adiciona id da empresa
        $dados['id_empresa'] = $this->id_empresa;

        $id_venda = $this->venda_model
                        ->insert($dados);

        // ---------------------------------------- PRODUTOS
        $produtos_do_pdv = $this->produto_pdv_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $produtos_para_o_cupom_nao_fiscal = "";

        foreach ($produtos_do_pdv as $produto) :
            $produto['id_venda'] = $id_venda;
			
			// Decrementa da quantidade do estoque a quantidade do produto vendido
            $produto_do_estoque = $this->produto_model
                                        ->where('id_empresa', $this->id_empresa)
                                        ->where('id_produto', $produto['id_produto'])
                                        ->first();

            $nova_qtd = $produto_do_estoque['quantidade'] - $produto['quantidade'];

            $this->produto_model
                ->where('id_empresa', $this->id_empresa)
                ->where('id_produto', $produto['id_produto'])
                ->set('quantidade', $nova_qtd)
                ->update();
			
            $this->produto_da_venda_model
                ->insert($produto);

            // Guarda os dados dos produtos em uma variável para inserir no cupom
            $subtotal = $produto['quantidade'] * $produto['valor_unitario'];

            $produtos_para_o_cupom_nao_fiscal .= "
                <tr>
                    <td>{$produto['nome']}</td>
                    <td>{$produto['quantidade']} x {$produto['valor_unitario']}</td>
                    <td>{$subtotal}</td>
                </tr>
            ";
        endforeach;

        // Remove todos os registros da tabela produtos_do_pdv.
        $this->produto_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // ---------------------------------------- FORMAS DE PAGAMENTO

        $formas_de_pagamento_do_pdv = $this->forma_de_pagamento_do_pdv_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->findAll();
        
        foreach($formas_de_pagamento_do_pdv as $forma):
            // Remove id_id_forma_de_pagamento
            // Para não dar erro de chave duplicada
            unset($forma['id_forma_de_pagamento']);
            
            // Adiciona id_empresa ao array
            $forma['id_venda'] = $id_venda;

            $this->forma_de_pagamento_da_venda_model
                                        ->insert($forma);
        endforeach;

        // Remove todos os registros da tabela formas_de_pagamento_do_pdv.
        $this->forma_de_pagamento_do_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // VENDA CREDITO NA LOJA ----------------------- //
        // Caso esteja marcado o botão insere o registro
        if($dados['botao_usar_credito_na_loja'] == 1):
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

        // ---------------------------------- MONTAGEM DO CUPOM NÃO FISCAL ------------------------------------------- //
        $empresa  = $this->empresa_model
                        ->where('id_empresa', $this->id_empresa)
                        ->first();

        $cliente  = $this->cliente_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_cliente', $dados['id_cliente'])
                        ->first();

        $vendedor = $this->vendedor_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_vendedor', $dados['id_vendedor'])
                        ->first();

        $data = date('d/m/Y');
        $hora = date('H:i');

        echo "
            <p style='text-align: center'>
                <b>{$empresa['xFant']}</b><br>
                {$empresa['xNome']}<br>
                {$empresa['xLgr']}<br>
                {$empresa['fone']}
            </p>

            <p>
                <b>CNPJ:</b> {$empresa['CNPJ']}<br>
                <b>Cliente:</b> {$cliente['nome']}<br>
                {$data} às {$hora} - <b>Nº {$id_venda}</b>
            </p>

            <hr>

            <table width='100%'>
                <thead>
                    <tr>
                        <th>Desc.</th>
                        <th>Qtd X Unit.</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    {$produtos_para_o_cupom_nao_fiscal}
                </tbody>
            </table>

            <hr>

            <p>
                <b>Total:</b>    {$dados['valor_a_pagar']}<br>
                <b>Recebido:</b> {$dados['valor_recebido']}<br>
                <b>Troco:</b>    {$dados['troco']}<br>
            </p>
            
            <hr>

            <p><b>Vendedor:</b> {$vendedor['nome']}</p>

            <hr>

            <p style='text-align: center'>
                ____________________________
                <br>
                Assinatura do Cliente
            </p>

            <a href='/vendas/show/$id_venda?emitir_nfce_pdv=true' target='_blank' class='btn btn-info btn-block no-print'>EMITIR NFCe DA VENDA</a>
        ";

        $this->session->setFlashdata(
            'alert',
            [
                'type'  => 'success',
                'title' => 'Venda finalizada com sucesso!'
            ]
        );
    }

    public function createFormaDePagamento()
    {
        $dados = $this->request
                        ->getVar();

        // Converte BRL para USD
        $dados['valor'] = converteMoney($dados['valor']);

        // // Adiciona id_empresa ao array
        $dados['id_empresa'] = $this->id_empresa;

        $this->forma_de_pagamento_do_pdv_model
            ->insert($dados);

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Forma de Pagamento adicionada com sucesso!',
                    'abrir_modal_finalizar_venda' => 'ok'
                ]
            );

        echo 1;
    }

    public function deleteFormaDePagamentoDaVendaRapida($id_forma_de_pagamento, $id_caixa)
    {
        $this->forma_de_pagamento_do_pdv_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_forma_de_pagamento', $id_forma_de_pagamento)
            ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type'  => 'success',
                    'title' => 'Forma de Pagamento excluida com sucesso!',
                    'abrir_modal_finalizar_venda' => 'ok'
                ]
            );

        return redirect()->to(base_url("pdv/start/{$id_caixa}"));
    }

    public function cancelarVenda($id_caixa)
    {
        $this->produto_pdv_model
                            ->where('id_empresa', $this->id_empresa)
                            ->delete();

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Venda cancelada com sucesso!'
                ]
            );

        return redirect()->to(base_url("pdv/start/$id_caixa"));
    }

    public function adicionarDescontoGeral($id_caixa)
    {
        $count = $this->produto_pdv_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->countAllResults();

        $desconto_geral = $this->request->getVar('desconto_geral');

        // Converte de BRL para USD
        $desconto_geral = converteMoney($desconto_geral);

        $desconto = $desconto_geral / $count;

        $produtos_do_pdv = $this->produto_pdv_model
                                                ->where('id_empresa', $this->id_empresa)
                                                ->findAll();

        foreach($produtos_do_pdv as $produto):
            $valor_final = $produto['subtotal'] - $desconto;

            $dados = [
                'desconto' => $desconto,
                'valor_final' => $valor_final
            ];

            $this->produto_pdv_model
                            ->where('id_empresa', $this->id_empresa)
                            ->where('id_produto_pdv', $produto['id_produto_pdv'])
                            ->set($dados)
                            ->update();
        endforeach;

        $this->session
            ->setFlashdata(
                'alert',
                [
                    'type' => 'success',
                    'title' => 'Desconto geral adicionado com sucesso!',
                    'abrir_modal_finalizar_venda' => 'ok'
                ]
            );

        return redirect()->to(base_url("/pdv/start/$id_caixa?modal_finalizar_venda=true"));
    }
}
