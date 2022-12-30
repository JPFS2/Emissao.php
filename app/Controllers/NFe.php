<?php

namespace App\Controllers;

use App\Models\FormaDePagamentoDaVendaModel;
use App\Models\MunicipioModel;
use App\Models\UfModel;
use App\Models\NFeAvulsaModel;
use App\Models\NFeAvulsaProdutoModel;
use App\Models\UnidadeModel;
use App\Models\NFeModel;
use App\Models\TransportadoraModel;
use App\Models\ProdutoDaVendaModel;
use App\Models\ClienteModel;
use App\Models\VendaModel;
use App\Models\EmpresaModel;

use CodeIgniter\Controller;

use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Complements;

use stdClass;

class NFe extends Controller
{
    private $session;
    private $id_empresa;

    private $dh;

    private $forma_de_pagamento_da_venda_model;
    private $municipio_model;
    private $uf_model;
    private $nfe_avulsa_model;
    private $nfe_avulsa_produto_model;
    private $unidade_model;
    private $nfe_model;
    private $transportadora_model;
    private $produto_da_venda_model;
    private $cliente_model;
    private $venda_model;
    private $empresa_model;

    function __construct()
    {
        require_once APPPATH . "ThirdParty/sped-nfe/vendor/autoload.php";

        $this->helpers = ['app'];

        $this->session = session();
        $this->id_empresa = $this->session->get('id_empresa');

        // Data e Hora Atual
        $this->data_e_hora = date('Y-m-d\TH:i:sP');

        $this->forma_de_pagamento_da_venda_model = new FormaDePagamentoDaVendaModel();
        $this->municipio_model          = new MunicipioModel();
        $this->uf_model                 = new UfModel();
        $this->nfe_avulsa_model         = new NFeAvulsaModel();
        $this->nfe_avulsa_produto_model = new NFeAvulsaProdutoModel();
        $this->unidade_model            = new UnidadeModel();
        $this->nfe_model                = new NFeModel();
        $this->transportadora_model     = new TransportadoraModel();
        $this->produto_da_venda_model   = new ProdutoDaVendaModel();
        $this->cliente_model            = new ClienteModel();
        $this->venda_model              = new VendaModel();
        $this->empresa_model            = new EmpresaModel();
    }

    public function montaXml($dados_do_emitente, $dados_da_venda, $dados_do_destinatario, $produtos_da_nota, $dados)
    {
        $nfe = new Make();

        // ----------- Tag INFORMAÇÕES ------------- //
        $inf           = new stdClass();
        $inf->versao   = '4.00'; //versão do layout (string)
        $inf->Id       = null; //se o Id de 44 digitos não for passado será gerado automaticamente
        $inf->pk_nItem = null; //deixe essa variavel sempre como NULL
        $nfe->taginfNFe($inf);

        // ----------- Tag IDE ------------- //
        $ide           = new stdClass();
        $ide->cUF      = $dados_do_emitente['codigo_uf'];
        $ide->cNF      = rand(1, 99999999);
        $ide->natOp    = $dados['natureza_da_operacao'];
        // $ide->indPag   = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00
        $ide->mod      = 55;
        $ide->serie    = $dados_do_emitente['serie'];

        if($dados_do_emitente['tpAmb_NFe'] == 1) :
            $numero_da_nf = $dados_do_emitente['nNF_producao'];
        else:
            $numero_da_nf = $dados_do_emitente['nNF_homologacao'];
        endif;

        $ide->nNF      = $numero_da_nf;
        $ide->dhEmi    = $this->data_e_hora;
        $ide->dhSaiEnt = $this->data_e_hora;
        $ide->tpNF     = 1; // Tipo de operação: 0-entrada, 1-saida

        if($dados_do_emitente['uf'] != $dados_do_destinatario['uf']) :
            $ide->idDest = 2; // Estadual=1, Interestadual=2
        else:
            $ide->idDest   = 1; // Estadual=1, Interestadual=2
        endif;

        $ide->cMunFG   = $dados_do_emitente['codigo'];
        $ide->tpImp    = 1;
        $ide->tpEmis   = 1;
        $ide->cDV      = 0;
        $ide->tpAmb    = $dados_do_emitente['tpAmb_NFe'];
        $ide->finNFe   = 1;
        $ide->indFinal = 0; // 0=Consumidor Normal, 1=Consumidor Final
        $ide->indPres  = 1;
        $ide->procEmi  = 0;
        $ide->verProc  = "5.0.2";
        $ide->dhCont   = null;
        $ide->xJust    = null;
        $nfe->tagide($ide);

        // ----------- Tag EMITENTE ------------- //
        // -- Emitente -- //
        $emitente        = new stdClass();
        $emitente->CNPJ  = $dados_do_emitente['CNPJ'];
        $emitente->xNome = $dados_do_emitente['xNome'];
        $emitente->xFant = $dados_do_emitente['xFant'];
        $emitente->IE    = $dados_do_emitente['IE'];
        $emitente->CRT   = 1; // 1=Simples Nacional
        $nfe->tagemit($emitente);

        // -- Endereço do emitente -- //
        $endereco_do_emitente          = new stdClass();
        $endereco_do_emitente->xLgr    = $dados_do_emitente['xLgr'];
        $endereco_do_emitente->nro     = $dados_do_emitente['nro'];
        $endereco_do_emitente->xCpl    = $dados_do_emitente['xCpl'];
        $endereco_do_emitente->xBairro = $dados_do_emitente['xBairro'];
        $endereco_do_emitente->cMun    = $dados_do_emitente['codigo'];
        $endereco_do_emitente->xMun    = $dados_do_emitente['municipio'];
        $endereco_do_emitente->UF      = $dados_do_emitente['uf'];
        $endereco_do_emitente->CEP     = $dados_do_emitente['CEP'];
        $endereco_do_emitente->cPais   = "1058";
        $endereco_do_emitente->xPais   = "BRASIL";
        $endereco_do_emitente->fone    = $dados_do_emitente['fone'];
        $nfe->tagenderEmit($endereco_do_emitente);

        // ----------- Tag DESTINATÁRIO ------------- //
        // -- Destinatário -- //
        if($dados_do_destinatario['tipo'] == 1) : // Caso seja pessoa física
            $destinatario        = new stdClass();
            $destinatario->CPF   = $dados_do_destinatario['cpf'];
            $destinatario->xNome = $dados_do_destinatario['nome'];
            
            if($dados_do_destinatario['isento'] == 1) :
                
                $destinatario->indIEDest = 2; // 1=Não Isento, 2=Isento

            else:

                $destinatario->indIEDest = 1; // 1=Não Isento, 2=Isento
                $destinatario->IE = $dados_do_destinatario['ie'];

            endif;
        else : // Caso seja pessoa juridica
            $destinatario        = new stdClass();
            $destinatario->CNPJ  = $dados_do_destinatario['cnpj'];
            $destinatario->xNome = $dados_do_destinatario['razao_social'];

            if($dados_do_destinatario['isento'] == 1) :
                
                $destinatario->indIEDest = 2; // 1=Não Isento, 2=Isento

            else:

                $destinatario->indIEDest = 1; // 1=Não Isento, 2=Isento
                $destinatario->IE = $dados_do_destinatario['ie'];

            endif;
        endif;

        $nfe->tagdest($destinatario);


        // -- Endereço do destinatário -- //
        $endereco_do_destinatario = new stdClass();
        $endereco_do_destinatario->xLgr = $dados_do_destinatario['logradouro'];
        
        if($dados_do_destinatario['numero'] == "" || $dados_do_destinatario['numero'] == 0) :
            $endereco_do_destinatario->nro = "S/N"; 
        else :
            $endereco_do_destinatario->nro = $dados_do_destinatario['numero'];
        endif;

        $endereco_do_destinatario->xCpl    = $dados_do_destinatario['complemento'];
        $endereco_do_destinatario->xBairro = $dados_do_destinatario['bairro'];
        $endereco_do_destinatario->cMun    = $dados_do_destinatario['codigo']; // Código do municipio
        $endereco_do_destinatario->xMun    = $dados_do_destinatario['municipio']; // Nome do municipio
        $endereco_do_destinatario->UF      = $dados_do_destinatario['uf'];
        $endereco_do_destinatario->CEP     = $dados_do_destinatario['cep'];
        $endereco_do_destinatario->cPais   = '1058';
        $endereco_do_destinatario->xPais   = 'BRASIL';
        $nfe->tagenderDest($endereco_do_destinatario);

        // ------------------------------------------- TAG PRODUTOS ---------------------------------------------- //
        $i = 0;
        foreach ($produtos_da_nota as $produto) :
            $i += 1;

            // ----------- Tag PRODUTOS ------------- //
            $std_produto         = new \stdClass();
            $std_produto->item   = $i;
            $std_produto->cProd  = $produto['id_produto'];

            $std_produto->cEAN   = $produto['codigo_de_barras'];;
            $std_produto->xProd  = $produto['nome'];
            $std_produto->NCM    = removeMascara($produto['NCM']);

            // Verifica se a operação é fora do estado, se for pega o CFOP_Externo
            if($dados_do_emitente['uf'] != $dados_do_destinatario['uf']) :
                $std_produto->CFOP = removeMascara($produto['CFOP_Externo']);
            else:
                $std_produto->CFOP = removeMascara($produto['CFOP_NFe']);
            endif;

            $std_produto->uCom   = $produto['unidade'];
            $std_produto->qCom   = $produto['quantidade']; // QUANTIDADE COMPRADA -----------------------------------------------------------
            $std_produto->vUnCom = format($produto['valor_unitario']); // COLOCAR O VALOR UNITÁRIO DO PRODUTO --------------------------------------------------------------

            // CASO HAJA DESCONTO NO PRODUTO INSERIDO AUTOMATICAMENTE CONDIÇÃO = DIFENTE DE ZERO
            if($produto['desconto'] != 0) :
                $std_produto->vDesc  = format($produto['desconto']); // DESCONTO DO PRODUTO
            endif;

            $subtotal = format($produto['valor_unitario']) * $produto['quantidade'];

            $std_produto->vProd    = format($subtotal); // COLOCAR O VALOR TOTAL QTDxVALOR.UNITARIO --------------------------------------------------------
            $std_produto->cEANTrib = $produto['codigo_de_barras'];
            $std_produto->uTrib    = $produto['unidade'];
            $std_produto->qTrib    = $produto['quantidade']; // QUANTIDADE A SER TRIBUTADA ----------------------------------------------------------------------------
            $std_produto->vUnTrib  = format($produto['valor_unitario']); // COLOCAR O VALOR DA UNIDADE -----------------------------------------------------------------------
            $std_produto->indTot   = 1; // Indica se o valor do item (vProd) entra no total da NF-e. 0-não compoe, 1 compoe
            $nfe->tagprod($std_produto);

            // -- Tag imposto -- //
            $std_imposto       = new \stdClass();
            $std_imposto->item = $i;
            $nfe->tagimposto($std_imposto);

            // -- Tag ICMS -- //
            $std_icms       = new \stdClass();
            $std_icms->item = $i;
            $nfe->tagICMS($std_icms);

            // -- Tag ICMSSN -- //
            $std_icmssm                  = new stdClass();
            $std_icmssm->item            = $i; //item da NFe
            $std_icmssm->orig            = 0;
            $std_icmssm->CSOSN           = $produto['CSOSN'];
            $std_icmssm->pCredSN         = '0.00';
            $std_icmssm->vCredICMSSN     = '0.00';
            $std_icmssm->modBCST         = null;
            $std_icmssm->pMVAST          = null;
            $std_icmssm->pRedBCST        = null;
            $std_icmssm->vBCST           = null;
            $std_icmssm->pICMSST         = null;
            $std_icmssm->vICMSST         = null;
            $std_icmssm->vBCFCPST        = null; //incluso no layout 4.00
            $std_icmssm->pFCPST          = null; //incluso no layout 4.00
            $std_icmssm->vFCPST          = null; //incluso no layout 4.00
            $std_icmssm->vBCSTRet        = null;
            $std_icmssm->pST             = null;
            $std_icmssm->vICMSSTRet      = null;
            $std_icmssm->vBCFCPSTRet     = null; //incluso no layout 4.00
            $std_icmssm->pFCPSTRet       = null; //incluso no layout 4.00
            $std_icmssm->vFCPSTRet       = null; //incluso no layout 4.00
            $std_icmssm->modBC           = null;
            $std_icmssm->vBC             = null;
            $std_icmssm->pRedBC          = null;
            $std_icmssm->pICMS           = null;
            $std_icmssm->vICMS           = null;
            $std_icmssm->pRedBCEfet      = null;
            $std_icmssm->vBCEfet         = null;
            $std_icmssm->pICMSEfet       = null;
            $std_icmssm->vICMSEfet       = null;
            $std_icmssm->vICMSSubstituto = null;
            $nfe->tagICMSSN($std_icmssm);

            // -- Tag PIS -- //
            $std_pis = new \stdClass();
            $std_pis->item = $i;
            $std_pis->CST  = $produto['pis_cofins'];
            $std_pis->vBC  = '0.00';
            $std_pis->pPIS = '0.00';
            $std_pis->vPIS = '0.00';
            $nfe->tagPIS($std_pis);

            // -- COFINS -- //
            $std_cofins             = new \stdClass();
            $std_cofins->item       = $i;
            $std_cofins->CST        = $produto['pis_cofins'];
            $std_cofins->vBC        = '0.00';
            $std_cofins->pCOFINS    = '0.0000';
            $std_cofins->vCOFINS    = '00.0';
            // $std_cofins->qBCProd = 0;
            $std_cofins->vAliqProd  = 0;
            $nfe->tagCOFINS($std_cofins);
        endforeach;

        // ----------- Tag ICMS TOTAL ------------- //
        $icms_total             = new stdClass();
        $icms_total->vBC        = null;
        $icms_total->vICMS      = null;
        $icms_total->vICMSDeson = null;
        $icms_total->vFCP       = null;
        $icms_total->vBCST      = null;
        $icms_total->vST        = null;
        $icms_total->vFCPST     = null;
        $icms_total->vFCPSTRet  = null;
        $icms_total->vProd      = null;
        $icms_total->vFrete     = null;
        $icms_total->vSeg       = null;
        $icms_total->vDesc      = null;
        $icms_total->vII        = null;
        $icms_total->vIPI       = null;
        $icms_total->vIPIDevol  = null;
        $icms_total->vPIS       = null;
        $icms_total->vCOFINS    = null;
        $icms_total->vOutro     = null;
        $icms_total->vNF        = null;
        $icms_total->vTotTrib   = null;
        $nfe->tagICMSTot($icms_total);

        // ----------- Tag TRANSPORTE ------------- //
        $transporte           = new stdClass();
        if($dados['tipo'] != 9) : 
            $transporte->modFrete = $dados['tipo']; // 1=por conta do destinatario, 2=por conta de terceiros, 9=Sem transporte
        else:
            $transporte->modFrete = 9; // 1=com transporte, 9=Sem transporte
        endif;
        $nfe->tagtransp($transporte);

        if($dados['tipo'] != 9) : 
            // Dados da transportadora
            $dados_da_transportadora = $this->transportadora_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_transportadora', $dados['id_transportadora'])
                                            ->join('ufs', 'transportadoras.id_uf = ufs.id_uf')
                                            ->join('municipios', 'transportadoras.id_municipio = municipios.id_municipio')
                                            ->first();

            // dd($dados_da_nota);
            $transportadora = new stdClass();
            $transportadora->xNome  = $dados_da_transportadora['xNome'];
            
            // Verifica se a transportadora é isenta
            if($dados_da_transportadora['isento'] == 1) :
                $transportadora->IE = null;
            else:
                $transportadora->IE = $dados_da_transportadora['IE'];
            endif;

            $transportadora->xEnder = $dados_da_transportadora['xEnder'];
            $transportadora->xMun   = $dados_da_transportadora['municipio'];
            $transportadora->UF     = $dados_da_transportadora['uf'];
            $transportadora->CNPJ   = $dados_da_transportadora['CNPJ'];//só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
            $transportadora->CPF    = null;
            $nfe->tagtransporta($transportadora);

            // Pega os dados da Unidade
            $unidade = $this->unidade_model
                            ->where('id_unidade', $dados['id_unidade'])
                            ->first();

            $volume = new stdClass();
            $volume->item  = 1; //indicativo do numero do volume
            $volume->qVol  = $dados['qVol'];
            $volume->esp   = $unidade['unidade'];
            // $volume->marca = 'OLX';
            // $volume->nVol = '1250';
            $volume->pesoL = $dados['pesoL'];
            $volume->pesoB = $dados['pesoB'];
            $nfe->tagvol($volume);
        endif;
        
        // ----------- Tag PAGAMENTO ------------- //
        $pagamento         = new stdClass();
        $pagamento->vTroco = format($dados_da_venda['troco']);
        $nfe->tagpag($pagamento);

        // Pega as formas de pagamento da venda
        $formas_de_pagamento_da_venda = $this->forma_de_pagamento_da_venda_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->where('id_venda', $dados_da_venda['id_venda'])
                                                            ->join(
                                                                'formas_de_pagamento',
                                                                'formas_de_pagamento_da_venda.id_forma = formas_de_pagamento.id_forma'
                                                            )
                                                            ->findAll();

        foreach($formas_de_pagamento_da_venda as $forma):
            // // -- Tipo de pagamento -- //
            // $tipo_de_pagamento         = new stdClass();
            // $tipo_de_pagamento->tPag   = '01'; // 01=Dinheiro, 02=Cheque, 03=Cartão de Crédito ...
            // $tipo_de_pagamento->vPag   = format(10);; //Obs: deve ser informado o valor total da nota
            // $tipo_de_pagamento->indPag = 0; //0= Pagamento à Vista 1= Pagamento à Prazo
            // $nfe->tagdetPag($tipo_de_pagamento);

            /* SEGUNDA PARTE DO PAGAMENTO MASTERCARD CREDITO */
            $tipo_de_pagamento_dois            = new stdClass();
            $tipo_de_pagamento_dois->tPag      = $forma['codigo'];

            $tipo_de_pagamento_dois->vPag = format($forma['valor']);
            
            // Se o tipo for cartão então tem uma tag a mais
            if($forma['codigo'] == "03" || $forma['codigo'] == "04"):
                $tipo_de_pagamento_dois->tpIntegra = 2; //1=integrado com o sistema da empresa, 2=não integrado
            endif;

            $tipo_de_pagamento_dois->indPag    = 0; //pagamento a vista

            // se o código for 99 adiciona a descrição obrigatoria do pagamento
            if($forma['codigo'] == "99"):
                $tipo_de_pagamento_dois->xPag = $forma['nome'];
            endif;
            
            $nfe->tagdetPag($tipo_de_pagamento_dois); //pagamento com o Mastercard
        endforeach;

        // ----------- Tag RESPONSÁVEL TÉCNICO ------------- // 
        $responsavel_tecnico           = new stdClass();
        $responsavel_tecnico->CNPJ     = $dados_do_emitente['CNPJ']; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
        $responsavel_tecnico->xContato = $dados_do_emitente['xFant']; //Nome da pessoa a ser contatada
        $responsavel_tecnico->email    = "contato@gmail.com"; //E-mail da pessoa jurídica a ser contatada
        $responsavel_tecnico->fone     = "35710000"; //Telefone da pessoa jurídica/física a ser contatada
        $responsavel_tecnico->CSRT     = ''; //Código de Segurança do Responsável Técnico
        $responsavel_tecnico->idCSRT   = '0'; //Identificador do CSRT
        $nfe->taginfRespTec($responsavel_tecnico);
        
        // ----------- Tag INFORMAÇÕES ADICIONAIS --------- //
        if($dados['informacoes_complementares'] != "" || $dados['informacoes_para_fisco'] != "") :

            if($dados['informacoes_complementares'] != "" && $dados['informacoes_para_fisco'] != "") :
                
                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = $dados['informacoes_para_fisco'];
                $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                $nfe->taginfAdic($std_informacoes_adicionais);

            elseif($dados['informacoes_complementares'] != "") :

                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = null;
                $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                $nfe->taginfAdic($std_informacoes_adicionais);

            elseif($dados['informacoes_para_fisco'] != "") :

                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = $dados['informacoes_para_fisco'];
                $std_informacoes_adicionais->infCpl     = null;
                $nfe->taginfAdic($std_informacoes_adicionais);

            endif;

        endif;

        // Verifica se todos os campos foram preenchidos corretamente e depois gera o XML
        try
        {
            return $nfe; // Retorna a instância da nota
        }
        catch (\Exception $e)
        {
            $erros = $nfe->getErrors();
            exit($nfe->getErrors());
        }
    }

    public function montaXmlEntrada($dados_do_emitente, $produtos_da_nota, $dados)
    {
        // dd($dados_do_emitente);

        $nfe = new Make();

        // ----------- Tag INFORMAÇÕES ------------- //
        $inf           = new stdClass();
        $inf->versao   = '4.00'; //versão do layout (string)
        $inf->Id       = null; //se o Id de 44 digitos não for passado será gerado automaticamente
        $inf->pk_nItem = null; //deixe essa variavel sempre como NULL
        $nfe->taginfNFe($inf);

        // ----------- Tag IDE ------------- //
        $ide           = new stdClass();
        $ide->cUF      = $dados_do_emitente['codigo_uf'];
        $ide->cNF      = rand(1, 99999999);
        $ide->natOp    = $dados['natureza_da_operacao'];
        // $ide->indPag   = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00
        $ide->mod      = 55;
        $ide->serie    = $dados_do_emitente['serie'];

        if($dados_do_emitente['tpAmb_NFe'] == 1) :
            $numero_da_nf = $dados_do_emitente['nNF_producao'];
        else:
            $numero_da_nf = $dados_do_emitente['nNF_homologacao'];
        endif;

        // echo $dados_da_nota['data'].'T'.date("{$dados_da_nota['hora']}:sP");
        // exit();

        $ide->nNF      = $numero_da_nf;
        $ide->dhEmi    = $dados['data'].'T'.date("{$dados['hora']}:sP"); //date('Y-m-d\TH:i:sP');
        $ide->dhSaiEnt = $dados['data'].'T'.date("{$dados['hora']}:sP"); //date('Y-m-d\TH:i:sP');
        $ide->tpNF     = 0; // Tipo de operação: 0-entrada, 1-saida
        $ide->idDest   = 1;
        $ide->cMunFG   = $dados_do_emitente['codigo'];
        $ide->tpImp    = 1;
        $ide->tpEmis   = 1;
        $ide->cDV      = 0;
        $ide->tpAmb    = $dados_do_emitente['tpAmb_NFe'];
        $ide->finNFe   = 1;
        $ide->indFinal = 0;
        $ide->indPres  = 1;
        $ide->procEmi  = 0;
        $ide->verProc  = "xF 1.0.1";
        $ide->dhCont   = null;
        $ide->xJust    = null;
        $nfe->tagide($ide);

        // ----------- Tag EMITENTE ------------- //
        // -- Emitente -- //
        $emitente        = new stdClass();
        $emitente->CNPJ  = $dados_do_emitente['CNPJ'];
        $emitente->xNome = $dados_do_emitente['xNome'];
        $emitente->xFant = $dados_do_emitente['xFant'];
        $emitente->IE    = $dados_do_emitente['IE'];
        $emitente->CRT   = 1; // 1=Simples Nacional
        $nfe->tagemit($emitente);

        // -- Endereço do emitente -- //
        $endereco_do_emitente          = new stdClass();
        $endereco_do_emitente->xLgr    = $dados_do_emitente['xLgr'];
        $endereco_do_emitente->nro     = $dados_do_emitente['nro'];
        $endereco_do_emitente->xCpl    = $dados_do_emitente['xCpl'];
        $endereco_do_emitente->xBairro = $dados_do_emitente['xBairro'];
        $endereco_do_emitente->cMun    = $dados_do_emitente['codigo'];
        $endereco_do_emitente->xMun    = $dados_do_emitente['municipio'];
        $endereco_do_emitente->UF      = $dados_do_emitente['uf'];
        $endereco_do_emitente->CEP     = $dados_do_emitente['CEP'];
        $endereco_do_emitente->cPais   = "1058";
        $endereco_do_emitente->xPais   = "BRASIL";
        $endereco_do_emitente->fone    = $dados_do_emitente['fone'];
        $nfe->tagenderEmit($endereco_do_emitente);

        // ----------- Tag DESTINATÁRIO ------------- //
        // -- Destinatário -- //
        $destinatario        = new stdClass();
        $destinatario->CNPJ  = $dados_do_emitente['CNPJ'];
        $destinatario->xNome = $dados_do_emitente['xNome'];
        $destinatario->indIEDest = 1; // 1=Não Isento, 2=Isento
        $destinatario->IE = $dados_do_emitente['IE'];

        $nfe->tagdest($destinatario);

        // -- Endereço do destinatário -- //
        $endereco_do_destinatario = new stdClass();
        $endereco_do_destinatario->xLgr = $dados_do_emitente['xLgr'];
        
        if($dados_do_emitente['nro'] == "" || $dados_do_emitente['nro'] == 0) :
            $endereco_do_destinatario->nro = "S/N"; 
        else :
            $endereco_do_destinatario->nro = $dados_do_emitente['nro'];
        endif;

        $endereco_do_destinatario->xCpl    = $dados_do_emitente['xCpl'];
        $endereco_do_destinatario->xBairro = $dados_do_emitente['xBairro'];
        $endereco_do_destinatario->cMun    = $dados_do_emitente['codigo']; // Código do municipio
        $endereco_do_destinatario->xMun    = $dados_do_emitente['municipio']; // Nome do municipio
        $endereco_do_destinatario->UF      = $dados_do_emitente['uf'];
        $endereco_do_destinatario->CEP     = $dados_do_emitente['CEP'];
        $endereco_do_destinatario->cPais   = '1058';
        $endereco_do_destinatario->xPais   = 'BRASIL';
        $nfe->tagenderDest($endereco_do_destinatario);

        // ------------------------------------------- TAG PRODUTOS ---------------------------------------------- //
        $i = 0;
        $valor_da_nota = 0;

        foreach ($produtos_da_nota as $produto) :
            $i += 1;

            // ----------- Tag PRODUTOS ------------- //
            $std_produto         = new \stdClass();
            $std_produto->item   = $i;
            $std_produto->cProd  = $produto['id_produto'];

            $std_produto->cEAN   = $produto['codigo_de_barras'];
            $std_produto->xProd  = $produto['nome'];
            $std_produto->NCM    = removeMascara($produto['NCM']);
            $std_produto->CFOP   = removeMascara($produto['CFOP_NFe']);
            $std_produto->uCom   = $produto['unidade'];
            $std_produto->qCom   = $produto['quantidade']; // QUANTIDADE COMPRADA -----------------------------------------------------------
            $std_produto->vUnCom = format($produto['valor_unitario']); // COLOCAR O VALOR UNITÁRIO DO PRODUTO --------------------------------------------------------------

            // CASO HAJA DESCONTO NO PRODUTO INSERIDO AUTOMATICAMENTE CONDIÇÃO = DIFENTE DE ZERO
            if($produto['desconto'] != 0) :
                $std_produto->vDesc  = format($produto['desconto']); // DESCONTO DO PRODUTO
            endif;

            $subtotal = format($produto['valor_unitario']) * $produto['quantidade'];

            $std_produto->vProd    = format($subtotal); // COLOCAR O VALOR TOTAL QTDxVALOR.UNITARIO --------------------------------------------------------
            $std_produto->cEANTrib = $produto['codigo_de_barras'];
            $std_produto->uTrib    = $produto['unidade'];
            $std_produto->qTrib    = $produto['quantidade']; // QUANTIDADE A SER TRIBUTADA ----------------------------------------------------------------------------
            $std_produto->vUnTrib  = format($produto['valor_unitario']); // COLOCAR O VALOR DA UNIDADE -----------------------------------------------------------------------
            $std_produto->indTot   = 1; // Indica se o valor do item (vProd) entra no total da NF-e. 0-não compoe, 1 compoe
            $nfe->tagprod($std_produto);

            // -- Tag imposto -- //
            $std_imposto       = new \stdClass();
            $std_imposto->item = $i;
            $nfe->tagimposto($std_imposto);

            // -- Tag ICMS -- //
            $std_icms       = new \stdClass();
            $std_icms->item = $i;
            $nfe->tagICMS($std_icms);

            // -- Tag ICMSSN -- //
            $std_icmssm                  = new stdClass();
            $std_icmssm->item            = $i; //item da NFe
            $std_icmssm->orig            = 0;
            $std_icmssm->CSOSN           = $produto['CSOSN'];
            $std_icmssm->pCredSN         = '0.00';
            $std_icmssm->vCredICMSSN     = '0.00';
            $std_icmssm->modBCST         = null;
            $std_icmssm->pMVAST          = null;
            $std_icmssm->pRedBCST        = null;
            $std_icmssm->vBCST           = null;
            $std_icmssm->pICMSST         = null;
            $std_icmssm->vICMSST         = null;
            $std_icmssm->vBCFCPST        = null; //incluso no layout 4.00
            $std_icmssm->pFCPST          = null; //incluso no layout 4.00
            $std_icmssm->vFCPST          = null; //incluso no layout 4.00
            $std_icmssm->vBCSTRet        = null;
            $std_icmssm->pST             = null;
            $std_icmssm->vICMSSTRet      = null;
            $std_icmssm->vBCFCPSTRet     = null; //incluso no layout 4.00
            $std_icmssm->pFCPSTRet       = null; //incluso no layout 4.00
            $std_icmssm->vFCPSTRet       = null; //incluso no layout 4.00
            $std_icmssm->modBC           = null;
            $std_icmssm->vBC             = null;
            $std_icmssm->pRedBC          = null;
            $std_icmssm->pICMS           = null;
            $std_icmssm->vICMS           = null;
            $std_icmssm->pRedBCEfet      = null;
            $std_icmssm->vBCEfet         = null;
            $std_icmssm->pICMSEfet       = null;
            $std_icmssm->vICMSEfet       = null;
            $std_icmssm->vICMSSubstituto = null;
            $nfe->tagICMSSN($std_icmssm);

            // -- Tag PIS -- //
            $std_pis = new \stdClass();
            $std_pis->item = $i;
            $std_pis->CST  = '01';
            $std_pis->vBC  = '0.00';
            $std_pis->pPIS = '0.00';
            $std_pis->vPIS = '0.00';
            $nfe->tagPIS($std_pis);

            // -- COFINS -- //
            $std_cofins             = new \stdClass();
            $std_cofins->item       = $i;
            $std_cofins->CST        = '01';
            $std_cofins->vBC        = '0.00';
            $std_cofins->pCOFINS    = '0.0000';
            $std_cofins->vCOFINS    = '00.0';
            // $std_cofins->qBCProd = 0;
            $std_cofins->vAliqProd  = 0;
            $nfe->tagCOFINS($std_cofins);

            $valor_da_nota += ($subtotal - $produto['desconto']);
        endforeach;

        // ----------- Tag ICMS TOTAL ------------- //
        $icms_total             = new stdClass();
        $icms_total->vBC        = null;
        $icms_total->vICMS      = null;
        $icms_total->vICMSDeson = null;
        $icms_total->vFCP       = null;
        $icms_total->vBCST      = null;
        $icms_total->vST        = null;
        $icms_total->vFCPST     = null;
        $icms_total->vFCPSTRet  = null;
        $icms_total->vProd      = null;
        $icms_total->vFrete     = null;
        $icms_total->vSeg       = null;
        $icms_total->vDesc      = null;
        $icms_total->vII        = null;
        $icms_total->vIPI       = null;
        $icms_total->vIPIDevol  = null;
        $icms_total->vPIS       = null;
        $icms_total->vCOFINS    = null;
        $icms_total->vOutro     = null;
        $icms_total->vNF        = null;
        $icms_total->vTotTrib   = null;
        $nfe->tagICMSTot($icms_total);

        // ----------- Tag TRANSPORTE ------------- //
        $transporte           = new stdClass();
        $transporte->modFrete = 9; // 1=com transporte, 9=Sem transporte
        $nfe->tagtransp($transporte);
        
        // ----------- Tag PAGAMENTO ------------- //
        $pagamento         = new stdClass();
        $pagamento->vTroco = null;
        $nfe->tagpag($pagamento);

        // -- Tipo de pagamento -- //
        $tipo_de_pagamento            = new stdClass();
        $tipo_de_pagamento->tPag      = $dados['tipo_de_pagamento']; // 01=Dinheiro, 02=Cheque, 03=Cartão de Crédito ...
        $tipo_de_pagamento->vPag      = format($valor_da_nota); //Obs: deve ser informado o valor total da nota
        $tipo_de_pagamento->indPag    = $dados['forma_de_pagamento']; //0= Pagamento à Vista 1= Pagamento à Prazo
        $nfe->tagdetPag($tipo_de_pagamento);

        // ----------- Tag RESPONSÁVEL TÉCNICO ------------- // 
        $responsavel_tecnico           = new stdClass();
        $responsavel_tecnico->CNPJ     = $dados_do_emitente['CNPJ']; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
        $responsavel_tecnico->xContato = $dados_do_emitente['xFant']; //Nome da pessoa a ser contatada
        $responsavel_tecnico->email    = "contato@gmail.com"; //E-mail da pessoa jurídica a ser contatada
        $responsavel_tecnico->fone     = "35710000"; //Telefone da pessoa jurídica/física a ser contatada
        $responsavel_tecnico->CSRT     = ''; //Código de Segurança do Responsável Técnico
        $responsavel_tecnico->idCSRT   = '0'; //Identificador do CSRT
        $nfe->taginfRespTec($responsavel_tecnico);
        
        // ----------- Tag INFORMAÇÕES ADICIONAIS --------- //
        if($dados['informacoes_complementares'] != "" || $dados['infomacoes_para_fisco']) :

            if($dados['informacoes_complementares'] != "" && $dados['infomacoes_para_fisco'] != "") :
                
                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = $dados['infomacoes_para_fisco'];
                $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                $nfe->taginfAdic($std_informacoes_adicionais);

            elseif($dados['informacoes_complementares'] != "") :

                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = null;
                $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                $nfe->taginfAdic($std_informacoes_adicionais);

            elseif($dados['infomacoes_para_fisco'] != "") :

                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = $dados['infomacoes_para_fisco'];
                $std_informacoes_adicionais->infCpl     = null;
                $nfe->taginfAdic($std_informacoes_adicionais);

            endif;

        endif;

        // Verifica se todos os campos foram preenchidos corretamente e depois gera o XML
        try
        {
            return $nfe; // Retorna a instância da nota
        }
        catch (\Exception $e)
        {
            $erros = $nfe->getErrors();
            exit($nfe->getErrors());
        }
    }

    public function montaXmlSaidaNFeAvulsa($dados_do_emitente, $produtos_da_nota, $dados)
    {
        $uf_destinatario = $this->uf_model
                                ->where('id_uf', $dados['id_uf'])
                                ->first();

        $municipio_destinatario = $this->municipio_model
                                        ->where('id_municipio', $dados['id_municipio'])
                                        ->first();

        $nfe = new Make();

        // ----------- Tag INFORMAÇÕES ------------- //
        $inf           = new stdClass();
        $inf->versao   = '4.00'; //versão do layout (string)
        $inf->Id       = null; //se o Id de 44 digitos não for passado será gerado automaticamente
        $inf->pk_nItem = null; //deixe essa variavel sempre como NULL
        $nfe->taginfNFe($inf);

        // ----------- Tag IDE ------------- //
        $ide           = new stdClass();
        $ide->cUF      = $dados_do_emitente['codigo_uf'];
        $ide->cNF      = rand(1, 99999999);
        $ide->natOp    = "VENDA DE MERCADORIAS"; //$dados_da_nota['natureza_da_operacao'];
        // $ide->indPag   = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00
        $ide->mod      = 55;
        $ide->serie    = $dados_do_emitente['serie'];

        if($dados_do_emitente['tpAmb_NFe'] == 1) :
            $numero_da_nf = $dados_do_emitente['nNF_producao'];
        else:
            $numero_da_nf = $dados_do_emitente['nNF_homologacao'];
        endif;

        $ide->nNF      = $numero_da_nf;
        $ide->dhEmi    = date('Y-m-d\TH:i:sP');
        $ide->dhSaiEnt = date('Y-m-d\TH:i:sP');
        $ide->tpNF     = 1; // Tipo de operação: 0-entrada, 1-saida

        if($dados_do_emitente['uf'] != $uf_destinatario['uf']) :
            $ide->idDest = 2; // Estadual=1, Interestadual=2
        else:
            $ide->idDest   = 1; // Estadual=1, Interestadual=2
        endif;

        $ide->cMunFG   = $dados_do_emitente['codigo'];
        $ide->tpImp    = 1;
        $ide->tpEmis   = 1;
        $ide->cDV      = 0;
        $ide->tpAmb    = $dados_do_emitente['tpAmb_NFe'];
        $ide->finNFe   = 1;
        $ide->indFinal = 0; // 0=Consumidor Normal, 1=Consumidor Final
        $ide->indPres  = 1;
        $ide->procEmi  = 0;
        $ide->verProc  = "xF 1.0.1";
        $ide->dhCont   = null;
        $ide->xJust    = null;
        $nfe->tagide($ide);

        // ----------- Tag EMITENTE ------------- //
        // -- Emitente -- //
        $emitente        = new stdClass();
        $emitente->CNPJ  = $dados_do_emitente['CNPJ'];
        $emitente->xNome = $dados_do_emitente['xNome'];
        $emitente->xFant = $dados_do_emitente['xFant'];
        $emitente->IE    = $dados_do_emitente['IE'];
        $emitente->CRT   = 1; // 1=Simples Nacional
        $nfe->tagemit($emitente);

        // -- Endereço do emitente -- //
        $endereco_do_emitente          = new stdClass();
        $endereco_do_emitente->xLgr    = $dados_do_emitente['xLgr'];
        $endereco_do_emitente->nro     = $dados_do_emitente['nro'];
        $endereco_do_emitente->xCpl    = $dados_do_emitente['xCpl'];
        $endereco_do_emitente->xBairro = $dados_do_emitente['xBairro'];
        $endereco_do_emitente->cMun    = $dados_do_emitente['codigo'];
        $endereco_do_emitente->xMun    = $dados_do_emitente['municipio'];
        $endereco_do_emitente->UF      = $dados_do_emitente['uf'];
        $endereco_do_emitente->CEP     = $dados_do_emitente['CEP'];
        $endereco_do_emitente->cPais   = "1058";
        $endereco_do_emitente->xPais   = "BRASIL";
        $endereco_do_emitente->fone    = $dados_do_emitente['fone'];
        $nfe->tagenderEmit($endereco_do_emitente);

        // ----------- Tag DESTINATÁRIO ------------- //
        // -- Destinatário -- //
        if($dados['tipo'] == 1) : // Caso seja pessoa física
            $destinatario        = new stdClass();
            $destinatario->CPF   = $dados['cpf'];
            $destinatario->xNome = $dados['nome'];
            
            if($dados['isento'] == 1) :
                
                $destinatario->indIEDest = 2; // 1=Não Isento, 2=Isento

            else:

                $destinatario->indIEDest = 1; // 1=Não Isento, 2=Isento
                $destinatario->IE = $dados['ie'];

            endif;
        else : // Caso seja pessoa juridica
            $destinatario        = new stdClass();
            $destinatario->CNPJ  = $dados['cnpj'];
            $destinatario->xNome = $dados['razao_social'];

            if($dados['isento'] == 1) :
                
                $destinatario->indIEDest = 2; // 1=Não Isento, 2=Isento

            else:

                $destinatario->indIEDest = 1; // 1=Não Isento, 2=Isento
                $destinatario->IE = $dados['ie'];

            endif;
        endif;

        $nfe->tagdest($destinatario);

        // -- Endereço do destinatário -- //
        $endereco_do_destinatario = new stdClass();
        $endereco_do_destinatario->xLgr = $dados['logradouro'];
        
        if(!isset($dados['numero']) || $dados['numero'] == "" || $dados['numero'] == 0) :
            $endereco_do_destinatario->nro = "S/N"; 
        else :
            $endereco_do_destinatario->nro = $dados['numero'];
        endif;

        $endereco_do_destinatario->xCpl    = $dados['complemento'];
        $endereco_do_destinatario->xBairro = $dados['bairro'];
        $endereco_do_destinatario->cMun    = $municipio_destinatario['codigo']; // Código do municipio
        $endereco_do_destinatario->xMun    = $municipio_destinatario['municipio']; // Nome do municipio
        $endereco_do_destinatario->UF      = $uf_destinatario['uf'];
        $endereco_do_destinatario->CEP     = $dados['cep'];
        $endereco_do_destinatario->cPais   = '1058';
        $endereco_do_destinatario->xPais   = 'BRASIL';
        $nfe->tagenderDest($endereco_do_destinatario);

        // ------------------------------------------- TAG PRODUTOS ---------------------------------------------- //
        $i = 0;
        $valor_da_nota = 0;
        foreach ($produtos_da_nota as $produto) :
            $i += 1;

            // ----------- Tag PRODUTOS ------------- //
            $std_produto         = new \stdClass();
            $std_produto->item   = $i;
            $std_produto->cProd  = $produto['id_produto'];

            $std_produto->cEAN   = $produto['codigo_de_barras'];
            $std_produto->xProd  = $produto['nome'];
            $std_produto->NCM    = removeMascara($produto['NCM']);

            // Verifica se a operação é fora do estado, se for pega o CFOP_Externo
            if($dados_do_emitente['uf'] != $uf_destinatario['uf']) :
                $std_produto->CFOP = removeMascara($produto['CFOP_Externo']);
            else:
                $std_produto->CFOP = removeMascara($produto['CFOP_NFe']);
            endif;

            $std_produto->uCom   = $produto['unidade'];
            $std_produto->qCom   = $produto['quantidade']; // QUANTIDADE COMPRADA -----------------------------------------------------------
            $std_produto->vUnCom = format($produto['valor_unitario']); // COLOCAR O VALOR UNITÁRIO DO PRODUTO --------------------------------------------------------------

            // CASO HAJA DESCONTO NO PRODUTO INSERIDO AUTOMATICAMENTE CONDIÇÃO = DIFENTE DE ZERO
            if($produto['desconto'] != 0) :
                $std_produto->vDesc  = format($produto['desconto']); // DESCONTO DO PRODUTO
            endif;

            $subtotal = format($produto['valor_unitario']) * $produto['quantidade'];

            $std_produto->vProd    = format($subtotal); // COLOCAR O VALOR TOTAL QTDxVALOR.UNITARIO --------------------------------------------------------
            $std_produto->cEANTrib = $produto['codigo_de_barras'];
            $std_produto->uTrib    = $produto['unidade'];
            $std_produto->qTrib    = $produto['quantidade']; // QUANTIDADE A SER TRIBUTADA ----------------------------------------------------------------------------
            $std_produto->vUnTrib  = format($produto['valor_unitario']); // COLOCAR O VALOR DA UNIDADE -----------------------------------------------------------------------
            $std_produto->indTot   = 1; // Indica se o valor do item (vProd) entra no total da NF-e. 0-não compoe, 1 compoe
            $nfe->tagprod($std_produto);

            // -- Tag imposto -- //
            $std_imposto       = new \stdClass();
            $std_imposto->item = $i;
            $nfe->tagimposto($std_imposto);

            // -- Tag ICMS -- //
            $std_icms       = new \stdClass();
            $std_icms->item = $i;
            $nfe->tagICMS($std_icms);

            // -- Tag ICMSSN -- //
            $std_icmssm                  = new stdClass();
            $std_icmssm->item            = $i; //item da NFe
            $std_icmssm->orig            = 0;
            $std_icmssm->CSOSN           = $produto['CSOSN'];
            $std_icmssm->pCredSN         = '0.00';
            $std_icmssm->vCredICMSSN     = '0.00';
            $std_icmssm->modBCST         = null;
            $std_icmssm->pMVAST          = null;
            $std_icmssm->pRedBCST        = null;
            $std_icmssm->vBCST           = null;
            $std_icmssm->pICMSST         = null;
            $std_icmssm->vICMSST         = null;
            $std_icmssm->vBCFCPST        = null; //incluso no layout 4.00
            $std_icmssm->pFCPST          = null; //incluso no layout 4.00
            $std_icmssm->vFCPST          = null; //incluso no layout 4.00
            $std_icmssm->vBCSTRet        = null;
            $std_icmssm->pST             = null;
            $std_icmssm->vICMSSTRet      = null;
            $std_icmssm->vBCFCPSTRet     = null; //incluso no layout 4.00
            $std_icmssm->pFCPSTRet       = null; //incluso no layout 4.00
            $std_icmssm->vFCPSTRet       = null; //incluso no layout 4.00
            $std_icmssm->modBC           = null;
            $std_icmssm->vBC             = null;
            $std_icmssm->pRedBC          = null;
            $std_icmssm->pICMS           = null;
            $std_icmssm->vICMS           = null;
            $std_icmssm->pRedBCEfet      = null;
            $std_icmssm->vBCEfet         = null;
            $std_icmssm->pICMSEfet       = null;
            $std_icmssm->vICMSEfet       = null;
            $std_icmssm->vICMSSubstituto = null;
            $nfe->tagICMSSN($std_icmssm);

            // -- Tag PIS -- //
            $std_pis = new \stdClass();
            $std_pis->item = $i;
            $std_pis->CST  = '01';
            $std_pis->vBC  = '0.00';
            $std_pis->pPIS = '0.00';
            $std_pis->vPIS = '0.00';
            $nfe->tagPIS($std_pis);

            // -- COFINS -- //
            $std_cofins             = new \stdClass();
            $std_cofins->item       = $i;
            $std_cofins->CST        = '01';
            $std_cofins->vBC        = '0.00';
            $std_cofins->pCOFINS    = '0.0000';
            $std_cofins->vCOFINS    = '00.0';
            // $std_cofins->qBCProd = 0;
            $std_cofins->vAliqProd  = 0;
            $nfe->tagCOFINS($std_cofins);

            // Soma o valor total da nota
            $valor_da_nota += ($subtotal - $produto['desconto']);
        endforeach;

        // ----------- Tag ICMS TOTAL ------------- //
        $icms_total             = new stdClass();
        $icms_total->vBC        = null;
        $icms_total->vICMS      = null;
        $icms_total->vICMSDeson = null;
        $icms_total->vFCP       = null;
        $icms_total->vBCST      = null;
        $icms_total->vST        = null;
        $icms_total->vFCPST     = null;
        $icms_total->vFCPSTRet  = null;
        $icms_total->vProd      = null;
        $icms_total->vFrete     = null;
        $icms_total->vSeg       = null;
        $icms_total->vDesc      = null;
        $icms_total->vII        = null;
        $icms_total->vIPI       = null;
        $icms_total->vIPIDevol  = null;
        $icms_total->vPIS       = null;
        $icms_total->vCOFINS    = null;
        $icms_total->vOutro     = null;
        $icms_total->vNF        = null;
        $icms_total->vTotTrib   = null;
        $nfe->tagICMSTot($icms_total);

        // ----------- Tag TRANSPORTE ------------- //
        $transporte           = new stdClass();
        if($dados['id_transportadora'] != 0) : // Caso seja diferente de zero então o usuário escolheu uma transportadora
            $transporte->modFrete = 1; // 1=com transporte, 9=Sem transporte
        else:
            $transporte->modFrete = 9; // 1=com transporte, 9=Sem transporte
        endif;
        $nfe->tagtransp($transporte);

        if($dados['id_transportadora'] != 0) : // Caso seja diferente de zero então o usuário escolheu uma transportadora
            // Dados da transportadora
            $dados_da_transportadora = $this->transportadora_model
                                            ->where('id_empresa', $this->id_empresa)
                                            ->where('id_transportadora', $dados['id_transportadora'])
                                            ->join('ufs', 'transportadoras.id_uf = ufs.id_uf')
                                            ->join('municipios', 'transportadoras.id_municipio = municipios.id_municipio')
                                            ->first();

            // dd($dados_da_nota);
            $transportadora = new stdClass();
            $transportadora->xNome  = $dados_da_transportadora['xNome'];
            
            // Verifica se a transportadora é isenta
            if($dados_da_transportadora['isento'] == 1) :
                $transportadora->IE = null;
            else:
                $transportadora->IE = $dados_da_transportadora['IE'];
            endif;

            $transportadora->xEnder = $dados_da_transportadora['xEnder'];
            $transportadora->xMun   = $dados_da_transportadora['municipio'];
            $transportadora->UF     = $dados_da_transportadora['uf'];
            $transportadora->CNPJ   = $dados_da_transportadora['CNPJ'];//só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
            $transportadora->CPF    = null;
            $nfe->tagtransporta($transportadora);

            // Pega os dados da Unidade
            $unidade = $this->unidade_model
                            ->where('id_unidade', $dados['id_unidade'])
                            ->first();

            $volume = new stdClass();
            $volume->item  = 1; //indicativo do numero do volume
            $volume->qVol  = $dados['qVol'];
            $volume->esp   = $unidade['unidade'];
            // $volume->marca = 'OLX';
            // $volume->nVol = '1250';
            $volume->pesoL = $dados['pesoL'];
            $volume->pesoB = $dados['pesoB'];
            $nfe->tagvol($volume);
        endif;
        
        // ----------- Tag PAGAMENTO ------------- //
        $pagamento         = new stdClass();
        $pagamento->vTroco = format($dados['troco']);
        $nfe->tagpag($pagamento);

        // -- Tipo de pagamento -- //
        $tipo_de_pagamento            = new stdClass();
        $tipo_de_pagamento->tPag      = '01'; // 01=Dinheiro, 02=Cheque, 03=Cartão de Crédito ...
        $tipo_de_pagamento->vPag      = format($valor_da_nota); //Obs: deve ser informado o valor total da nota
        $tipo_de_pagamento->indPag    = 0; //0= Pagamento à Vista 1= Pagamento à Prazo
        $nfe->tagdetPag($tipo_de_pagamento);

        // ----------- Tag RESPONSÁVEL TÉCNICO ------------- // 
        $responsavel_tecnico           = new stdClass();
        $responsavel_tecnico->CNPJ     = $dados_do_emitente['CNPJ']; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
        $responsavel_tecnico->xContato = $dados_do_emitente['xFant']; //Nome da pessoa a ser contatada
        $responsavel_tecnico->email    = "contato@gmail.com"; //E-mail da pessoa jurídica a ser contatada
        $responsavel_tecnico->fone     = "35710000"; //Telefone da pessoa jurídica/física a ser contatada
        $responsavel_tecnico->CSRT     = ''; //Código de Segurança do Responsável Técnico
        $responsavel_tecnico->idCSRT   = '0'; //Identificador do CSRT
        $nfe->taginfRespTec($responsavel_tecnico);
        
        // ----------- Tag INFORMAÇÕES ADICIONAIS --------- //
        if($dados['informacoes_complementares'] != "" || $dados['informacoes_para_fisco'] != "") :

            if($dados['informacoes_complementares'] != "" && $dados['informacoes_para_fisco'] != "") :
                
                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = $dados['informacoes_para_fisco'];
                $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                $nfe->taginfAdic($std_informacoes_adicionais);

            elseif($dados['informacoes_complementares'] != "") :

                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = null;
                $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                $nfe->taginfAdic($std_informacoes_adicionais);

            elseif($dados['informacoes_para_fisco'] != "") :

                $std_informacoes_adicionais = new stdClass();
                $std_informacoes_adicionais->infAdFisco = $dados['informacoes_para_fisco'];
                $std_informacoes_adicionais->infCpl     = null;
                $nfe->taginfAdic($std_informacoes_adicionais);

            endif;

        endif;

        // Verifica se todos os campos foram preenchidos corretamente e depois gera o XML
        try
        {
            return $nfe; // Retorna a instância da nota
        }
        catch (\Exception $e)
        {
            $erros = $nfe->getErrors();
            exit($nfe->getErrors());
        }
    }

    public function montaXmlDevolucaoNFeAvulsa($dados_do_emitente, $produtos_da_nota, $dados)
    {
        $uf_destinatario = $this->uf_model
                                ->where('id_uf', $dados['id_uf'])
                                ->first();

        $municipio_destinatario = $this->municipio_model
                                        ->where('id_municipio', $dados['id_municipio'])
                                        ->first();

        $nfe = new Make();

        // Verifica se todos os campos foram preenchidos corretamente e depois gera o XML
        try
        {
            // ----------- Tag INFORMAÇÕES ------------- //
            $inf           = new stdClass();
            $inf->versao   = '4.00'; //versão do layout (string)
            $inf->Id       = null; //se o Id de 44 digitos não for passado será gerado automaticamente
            $inf->pk_nItem = null; //deixe essa variavel sempre como NULL
            $nfe->taginfNFe($inf);

            // ----------- Tag IDE ------------- //
            $ide           = new stdClass();
            $ide->cUF      = $dados_do_emitente['codigo_uf'];
            $ide->cNF      = rand(1, 99999999);
            $ide->natOp    = $dados['natureza_da_operacao'];
            // $ide->indPag   = 0; //NÃO EXISTE MAIS NA VERSÃO 4.00
            $ide->mod      = 55;
            $ide->serie    = $dados_do_emitente['serie'];

            if($dados_do_emitente['tpAmb_NFe'] == 1) :
                $numero_da_nf = $dados_do_emitente['nNF_producao'];
            else:
                $numero_da_nf = $dados_do_emitente['nNF_homologacao'];
            endif;

            $ide->nNF      = $numero_da_nf;
            $ide->dhEmi    = $dados['data'].'T'.date("{$dados['hora']}:sP"); //date('Y-m-d\TH:i:sP');
            $ide->dhSaiEnt = $dados['data'].'T'.date("{$dados['hora']}:sP"); //date('Y-m-d\TH:i:sP');
            $ide->tpNF     = 1; // Tipo de operação: 0-entrada, 1-saida
            
            if($dados_do_emitente['uf'] != $uf_destinatario['uf']) :
                $ide->idDest = 2; // Estadual=1, Interestadual=2
            else:
                $ide->idDest   = 1; // Estadual=1, Interestadual=2
            endif;

            $ide->cMunFG   = $dados_do_emitente['codigo'];
            $ide->tpImp    = 1;
            $ide->tpEmis   = 1;
            $ide->cDV      = 0;
            $ide->tpAmb    = $dados_do_emitente['tpAmb_NFe'];
            $ide->finNFe   = 4;
            $ide->indFinal = 1;
            $ide->indPres  = 1;
            $ide->procEmi  = 0;
            $ide->verProc  = "xF 1.0.1";
            $ide->dhCont   = null;
            $ide->xJust    = null;
            $nfe->tagide($ide);

            // ----------- Tag Referencia da Nota --------------- //
            $nota_referenciada = new stdClass();
            $nota_referenciada->refNFe = removeMascara($dados['chave_referenciada']);
            $nfe->tagrefNFe($nota_referenciada);

            // ----------- Tag EMITENTE ------------- //
            // -- Emitente -- //
            $emitente        = new stdClass();
            $emitente->CNPJ  = $dados_do_emitente['CNPJ'];
            $emitente->xNome = $dados_do_emitente['xNome'];
            $emitente->xFant = $dados_do_emitente['xFant'];
            $emitente->IE    = $dados_do_emitente['IE'];
            $emitente->CRT   = 1; // 1=Simples Nacional
            $nfe->tagemit($emitente);

            // -- Endereço do emitente -- //
            $endereco_do_emitente          = new stdClass();
            $endereco_do_emitente->xLgr    = $dados_do_emitente['xLgr'];
            $endereco_do_emitente->nro     = $dados_do_emitente['nro'];
            $endereco_do_emitente->xCpl    = $dados_do_emitente['xCpl'];
            $endereco_do_emitente->xBairro = $dados_do_emitente['xBairro'];
            $endereco_do_emitente->cMun    = $dados_do_emitente['codigo'];
            $endereco_do_emitente->xMun    = $dados_do_emitente['municipio'];
            $endereco_do_emitente->UF      = $dados_do_emitente['uf'];
            $endereco_do_emitente->CEP     = $dados_do_emitente['CEP'];
            $endereco_do_emitente->cPais   = "1058";
            $endereco_do_emitente->xPais   = "BRASIL";
            $endereco_do_emitente->fone    = $dados_do_emitente['fone'];
            $nfe->tagenderEmit($endereco_do_emitente);

            // ----------- Tag DESTINATÁRIO ------------- //
            // -- Destinatário -- //
            if($dados['tipo'] == 1) // Caso seja pessoa física
            {
                $destinatario = new stdClass();
                $destinatario->CPF   = $dados['cpf'];
                $destinatario->xNome = $dados['nome'];
                
                if($dados['isento'] == 1) :
                    
                    $destinatario->indIEDest = 2; // 1=Não Isento, 2=Isento

                else:

                    $destinatario->indIEDest = 1; // 1=Não Isento, 2=Isento
                    $destinatario->IE = $dados['ie'];

                endif;
            }
            else // Caso seja pessoa juridica
            {
                $destinatario        = new stdClass();
                $destinatario->CNPJ  = $dados['cnpj'];
                $destinatario->xNome = $dados['razao_social'];

                if($dados['isento'] == 1) :
                    
                    $destinatario->indIEDest = 2; // 1=Não Isento, 2=Isento

                else:

                    $destinatario->indIEDest = 1; // 1=Não Isento, 2=Isento
                    $destinatario->IE = $dados['ie'];

                endif;
            }

            $nfe->tagdest($destinatario);


            // -- Endereço do destinatário -- //
            $endereco_do_destinatario = new stdClass();
            $endereco_do_destinatario->xLgr = $dados['logradouro'];
            
            if(!isset($dados['numero']) || $dados['numero'] == "" || $dados['numero'] == 0)
            {
                $endereco_do_destinatario->nro = "S/N"; 
            }
            else
            {
                $endereco_do_destinatario->nro = $dados['numero'];
            }

            $endereco_do_destinatario->xCpl    = $dados['complemento'];
            $endereco_do_destinatario->xBairro = $dados['bairro'];
            $endereco_do_destinatario->cMun    = $municipio_destinatario['codigo']; // Código do municipio
            $endereco_do_destinatario->xMun    = $municipio_destinatario['municipio']; // Nome do municipio
            $endereco_do_destinatario->UF      = $uf_destinatario['uf'];
            $endereco_do_destinatario->CEP     = $dados['cep'];
            $endereco_do_destinatario->cPais   = '1058';
            $endereco_do_destinatario->xPais   = 'BRASIL';
            $nfe->tagenderDest($endereco_do_destinatario);

            // ------------------------------------------- TAG PRODUTOS ---------------------------------------------- //
            $i = 0;
            foreach ($produtos_da_nota as $produto) {
                $i += 1;

                // ----------- Tag PRODUTOS ------------- //
                $std_produto         = new \stdClass();
                $std_produto->item   = $i;
                $std_produto->cProd  = $produto['id_produto'];

                $std_produto->cEAN   = $produto['codigo_de_barras'];
                $std_produto->xProd  = $produto['nome'];
                $std_produto->NCM    = removeMascara($produto['NCM']);
                
                // Verifica se a devolução é dentro do estado
                // e coloca os CFOP corrretos
                if($dados_do_emitente['uf'] == $uf_destinatario['uf']):
                    $std_produto->CFOP   = removeMascara($produto['CFOP_NFe']);
                else:
                    $std_produto->CFOP   = removeMascara($produto['CFOP_Externo']);
                endif;

                $std_produto->uCom   = $produto['unidade'];
                $std_produto->qCom   = $produto['quantidade']; // QUANTIDADE COMPRADA -----------------------------------------------------------
                $std_produto->vUnCom = format($produto['valor_unitario']); // COLOCAR O VALOR UNITÁRIO DO PRODUTO --------------------------------------------------------------

                if($produto['desconto'] != 0) // CASO HAJA DESCONTO NO PRODUTO INSERIDO AUTOMATICAMENTE CONDIÇÃO = DIFENTE DE ZERO
                {
                    $std_produto->vDesc  = format($produto['desconto']); // DESCONTO DO PRODUTO
                }

                $subtotal = format($produto['valor_unitario']) * $produto['quantidade'];

                $std_produto->vProd    = format($subtotal); // COLOCAR O VALOR TOTAL QTDxVALOR.UNITARIO --------------------------------------------------------
                $std_produto->cEANTrib = $produto['codigo_de_barras'];
                $std_produto->uTrib    = $produto['unidade'];
                $std_produto->qTrib    = $produto['quantidade']; // QUANTIDADE A SER TRIBUTADA ----------------------------------------------------------------------------
                $std_produto->vUnTrib  = format($produto['valor_unitario']); // COLOCAR O VALOR DA UNIDADE -----------------------------------------------------------------------
                $std_produto->indTot   = 1; // Indica se o valor do item (vProd) entra no total da NF-e. 0-não compoe, 1 compoe
                $nfe->tagprod($std_produto);

                // -- Tag imposto -- //
                $std_imposto       = new \stdClass();
                $std_imposto->item = $i;
                $nfe->tagimposto($std_imposto);

                // -- Tag ICMS -- //
                $std_icms       = new \stdClass();
                $std_icms->item = $i;
                $nfe->tagICMS($std_icms);

                // -- Tag ICMSSN -- //
                $std_icmssm                  = new stdClass();
                $std_icmssm->item            = $i; //item da NFe
                $std_icmssm->orig            = 0;
                $std_icmssm->CSOSN           = $produto['CSOSN'];
                $std_icmssm->pCredSN         = '0.00';
                $std_icmssm->vCredICMSSN     = '0.00';
                $std_icmssm->modBCST         = null;
                $std_icmssm->pMVAST          = null;
                $std_icmssm->pRedBCST        = null;
                $std_icmssm->vBCST           = null;
                $std_icmssm->pICMSST         = null;
                $std_icmssm->vICMSST         = null;
                $std_icmssm->vBCFCPST        = null; //incluso no layout 4.00
                $std_icmssm->pFCPST          = null; //incluso no layout 4.00
                $std_icmssm->vFCPST          = null; //incluso no layout 4.00
                $std_icmssm->vBCSTRet        = null;
                $std_icmssm->pST             = null;
                $std_icmssm->vICMSSTRet      = null;
                $std_icmssm->vBCFCPSTRet     = null; //incluso no layout 4.00
                $std_icmssm->pFCPSTRet       = null; //incluso no layout 4.00
                $std_icmssm->vFCPSTRet       = null; //incluso no layout 4.00
                $std_icmssm->modBC           = null;
                $std_icmssm->vBC             = null;
                $std_icmssm->pRedBC          = null;
                $std_icmssm->pICMS           = null;
                $std_icmssm->vICMS           = null;
                $std_icmssm->pRedBCEfet      = null;
                $std_icmssm->vBCEfet         = null;
                $std_icmssm->pICMSEfet       = null;
                $std_icmssm->vICMSEfet       = null;
                $std_icmssm->vICMSSubstituto = null;
                $nfe->tagICMSSN($std_icmssm);

                // -- Tag PIS -- //
                $std_pis = new \stdClass();
                $std_pis->item = $i;
                $std_pis->CST  = '01';
                $std_pis->vBC  = '0.00';
                $std_pis->pPIS = '0.00';
                $std_pis->vPIS = '0.00';
                $nfe->tagPIS($std_pis);

                // -- COFINS -- //
                $std_cofins             = new \stdClass();
                $std_cofins->item       = $i;
                $std_cofins->CST        = '01';
                $std_cofins->vBC        = '0.00';
                $std_cofins->pCOFINS    = '0.0000';
                $std_cofins->vCOFINS    = '00.0';
                // $std_cofins->qBCProd = 0;
                $std_cofins->vAliqProd  = 0;
                $nfe->tagCOFINS($std_cofins);
            }

            // ----------- Tag ICMS TOTAL ------------- //
            $icms_total             = new stdClass();
            $icms_total->vBC        = null;
            $icms_total->vICMS      = null;
            $icms_total->vICMSDeson = null;
            $icms_total->vFCP       = null;
            $icms_total->vBCST      = null;
            $icms_total->vST        = null;
            $icms_total->vFCPST     = null;
            $icms_total->vFCPSTRet  = null;
            $icms_total->vProd      = null;
            $icms_total->vFrete     = null;
            $icms_total->vSeg       = null;
            $icms_total->vDesc      = null;
            $icms_total->vII        = null;
            $icms_total->vIPI       = null;
            $icms_total->vIPIDevol  = null;
            $icms_total->vPIS       = null;
            $icms_total->vCOFINS    = null;
            $icms_total->vOutro     = null;
            $icms_total->vNF        = null;
            $icms_total->vTotTrib   = null;
            $nfe->tagICMSTot($icms_total);

            // ----------- Tag TRANSPORTE ------------- //
            $transporte           = new stdClass();
            if($dados['id_transportadora'] != 0) : // Caso seja diferente de zero então o usuário escolheu uma transportadora
                $transporte->modFrete = 1; // 1=com transporte, 9=Sem transporte
            else:
                $transporte->modFrete = 9; // 1=com transporte, 9=Sem transporte
            endif;
            $nfe->tagtransp($transporte);

            if($dados['id_transportadora'] != 0) : // Caso seja diferente de zero então o usuário escolheu uma transportadora
                // Dados da transportadora
                $dados_da_transportadora = $this->transportadora_model
                                                ->where('id_transportadora', $dados['id_transportadora'])
                                                ->join('ufs', 'transportadoras.id_uf = ufs.id_uf')
                                                ->join('municipios', 'transportadoras.id_municipio = municipios.id_municipio')
                                                ->first();
                
                $dados_da_transportadora['CNPJ'] = removeMascaras($dados_da_transportadora['CNPJ']);

                // dd($dados_da_nota);
                $transportadora = new stdClass();
                $transportadora->xNome  = $dados_da_transportadora['xNome'];
                
                // Verifica se a transportadora é isenta
                if($dados_da_transportadora['isento'] == 1) :
                    $transportadora->IE = null;
                else:
                    $transportadora->IE = $dados_da_transportadora['IE'];
                endif;

                $transportadora->xEnder = $dados_da_transportadora['xEnder'];
                $transportadora->xMun   = $dados_da_transportadora['municipio'];
                $transportadora->UF     = $dados_da_transportadora['uf'];
                $transportadora->CNPJ   = $dados_da_transportadora['CNPJ'];//só pode haver um ou CNPJ ou CPF, se um deles é especificado o outro deverá ser null
                $transportadora->CPF    = null;
                $nfe->tagtransporta($transportadora);

                // Pega os dados da Unidade
                $unidade = $this->unidade_model
                                ->where('id_unidade', $dados['id_unidade'])
                                ->first();

                $volume = new stdClass();
                $volume->item  = 1; //indicativo do numero do volume
                $volume->qVol  = $dados['qtdVol'];
                $volume->esp   = $unidade['unidade'];
                // $volume->marca = 'OLX';
                // $volume->nVol = '1250';
                $volume->pesoL = $dados['qtdLiq'];
                $volume->pesoB = $dados['pBruto'];
                $nfe->tagvol($volume);
            endif;

            // ----------- Tag PAGAMENTO ------------- //
            $pagamento         = new stdClass();
            $pagamento->vTroco = null;
            $nfe->tagpag($pagamento);

            // -- Tipo de pagamento -- //
            $tipo_de_pagamento            = new stdClass();
            $tipo_de_pagamento->tPag      = '90'; // 90=Sem Pagamento
            $tipo_de_pagamento->vPag      = '0.00'; //Obs: deve ser informado o valor total da nota
            $tipo_de_pagamento->indPag    = '0'; //0= Pagamento à Vista 1= Pagamento à Prazo
            $nfe->tagdetPag($tipo_de_pagamento);

            // ----------- Tag RESPONSÁVEL TÉCNICO ------------- // 
            $responsavel_tecnico           = new stdClass();
            $responsavel_tecnico->CNPJ     = $dados_do_emitente['CNPJ']; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
            $responsavel_tecnico->xContato = $dados_do_emitente['xFant']; //Nome da pessoa a ser contatada
            $responsavel_tecnico->email    = "contato@gmail.com"; //E-mail da pessoa jurídica a ser contatada
            $responsavel_tecnico->fone     = "35710000"; //Telefone da pessoa jurídica/física a ser contatada
            $responsavel_tecnico->CSRT     = ''; //Código de Segurança do Responsável Técnico
            $responsavel_tecnico->idCSRT   = '0'; //Identificador do CSRT
            $nfe->taginfRespTec($responsavel_tecnico);

            // ----------- Tag Informações Adicionais --------- //
            if($dados['informacoes_complementares'] != "" || $dados['informacoes_para_fisco'] != "") :

                if($dados['informacoes_complementares'] != "" && $dados['informacoes_para_fisco'] != "") :
                    
                    $std_informacoes_adicionais = new stdClass();
                    $std_informacoes_adicionais->infAdFisco = $dados['informacoes_para_fisco'];
                    $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                    $nfe->taginfAdic($std_informacoes_adicionais);

                elseif($dados['informacoes_complementares'] != "") :

                    $std_informacoes_adicionais = new stdClass();
                    $std_informacoes_adicionais->infAdFisco = null;
                    $std_informacoes_adicionais->infCpl     = $dados['informacoes_complementares'];
                    $nfe->taginfAdic($std_informacoes_adicionais);

                elseif($dados['informacoes_para_fisco'] != "") :

                    $std_informacoes_adicionais = new stdClass();
                    $std_informacoes_adicionais->infAdFisco = $dados['informacoes_para_fisco'];
                    $std_informacoes_adicionais->infCpl     = null;
                    $nfe->taginfAdic($std_informacoes_adicionais);

                endif;

            endif;

            return $nfe; // Retorna a instância da nota
        }
        catch (\Exception $e)
        {
            exit($nfe->getErrors());
        }
    }

    public function preparaConfigJson($dados_do_emitente)
    {
        // ------------------------------------------------------------ CONFIG
        $config  = [
            "atualizacao" => $this->data_e_hora,
            "tpAmb"       => intval($dados_do_emitente['tpAmb_NFe']),
            "razaosocial" => $dados_do_emitente['xNome'],
            "cnpj"        => $dados_do_emitente['CNPJ'], // PRECISA SER VÁLIDO
            "ie"          => $dados_do_emitente['IE'], // PRECISA SER VÁLIDO
            "siglaUF"     => $dados_do_emitente['uf'],
            "schemes"     => "PL_009_V4",
            "versao"      => '4.00',
            "tokenIBPT"   => "AAAAAAA",
            "CSC"         => "AD6A9D2E-3F93-437F-BE5B-E8FA800A08F4",
            "CSCid"       => "000001"
        ];

        return json_encode($config);
    }

    public function assinaXML($dados_do_emitente, $config_json, $xml)
    {
        /*---------------------------------------------------------------------------------------------------------------------------------------*/
        $arq_certificado     = WRITEPATH . "uploads/certificados/" . $dados_do_emitente['certificado'];
        $certificado_digital = file_get_contents($arq_certificado);

        $this->tools = new Tools(
            $config_json,
            Certificate::readPfx(
                $certificado_digital,
                $dados_do_emitente['senha_do_certificado']
            )
        );

        try
        {
            $xml_assinado = $this->tools->signNFe($xml); // O conteúdo do XML assinado fica armazenado na variável $xmlAssinado

            return $xml_assinado;
        }
        catch (\Exception $e)
        {
            // $this->detalhaRejeicao($e->getMessage());
            exit($e->getMessage());
        }
    }

    public function enviaLoteParaSefaz($xml_assinado)
    {
        try
        {
            $id_lote = str_pad(100, 15, '0', STR_PAD_LEFT); // Identificador do lote
            $resp    = $this->tools->sefazEnviaLote([$xml_assinado], $id_lote);

            $st  = new Standardize();
            $std = $st->toStd($resp);
            
            if ($std->cStat != 103)
            {
                //erro registrar e voltar
                exit("[$std->cStat] $std->xMotivo");
            }
            
            $recibo = $std->infRec->nRec; // Vamos usar a variável $recibo para consultar o status da nota

            return $recibo;
        }
        catch (\Exception $e)
        {            
            // $this->detalhaRejeicao($e->getMessage());
            exit($e->getMessage());
        }
    }

    public function consultaReciboNaSefaz($numero_do_recibo)
    {
        try
        {
            $protocolo = $this->tools->sefazConsultaRecibo($numero_do_recibo);

            return $protocolo;
        }
        catch (\Exception $e)
        {
            // $this->detalhaRejeicao($e->getMessage());
            exit($e->getMessage());
        }
    }

    public function protocolaXmlNaSefaz($xml_assinado, $protocolo)
    {
        $request  = $xml_assinado;
        $response = $protocolo;

        try
        {
            $xml_protocolado = Complements::toAuthorize($request, $response);

            return $xml_protocolado;

        }
        catch (\Exception $e)
        {
            // $this->detalhaRejeicao($e->getMessage());
            exit($e->getMessage());
        }
    }
    
    public function emitirNotaDeSaida($id_venda)
    {
        $dados = $this->request->getVar();

        $dados_do_emitente = $this->empresa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
                                ->first();

        $dados_da_venda = $this->venda_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_venda', $id_venda)
                                ->first();

        $dados_do_destinatario = $this->cliente_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->where('id_cliente', $dados_da_venda['id_cliente'])
                                    ->join('ufs', 'clientes.id_uf = ufs.id_uf')
                                    ->join('municipios', 'clientes.id_municipio = municipios.id_municipio')
                                    ->first();

        $produtos_da_nota = $this->produto_da_venda_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_venda', $dados_da_venda['id_venda'])
                                ->findAll();

        // ----- MONTA XML
        $nfe = $this->montaXml($dados_do_emitente, $dados_da_venda, $dados_do_destinatario, $produtos_da_nota, $dados);
        $xml = $nfe->getXML();

        // ----- PREPARA O CONFIG_JSON
        $config_json = $this->preparaConfigJson($dados_do_emitente);

        // ----- ASSINA XML
        $xml_assinado = $this->assinaXML($dados_do_emitente, $config_json, $xml);

        // ----- ENVIA LOTE PARA A SEFAZ
        $numero_do_recibo = $this->enviaLoteParaSefaz($xml_assinado);

        // ----- CONSULTA RECIBO NA SEFAZ
        $protocolo = $this->consultaReciboNaSefaz($numero_do_recibo);

        // ----- AUTORIZA USO DA NOTA - SEFAZ
        $xml_protocolado = $this->protocolaXmlNaSefaz($xml_assinado, $protocolo);

        // ----------------- Adiciona +1 no número da nota ----------------- //
        if($dados_do_emitente['tpAmb_NFe'] == 1) :

            $nova_nNF = $dados_do_emitente['nNF_producao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_producao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_producao'];
        
        else:

            $nova_nNF = $dados_do_emitente['nNF_homologacao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_homologacao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_homologacao'];

        endif;

        // ------------------------------------------------------------- //
        
        // Salva os dados da NFe no banco de dados
        $id_nfe = $this->nfe_model->insert([
            'numero'          => $guarda_numero_da_nota,
            'chave'           => $nfe->getChave(),
            'valor_da_nota'   => $dados_da_venda['valor_a_pagar'],
            'data'            => date('Y-m-d'),
            'hora'            => date('H:i:s'),
            'xml'             => $xml_protocolado,
            'protocolo'       => $protocolo,
            'status'          => "Emitida",
            'tipo'            => 2, // 1=Entrada, 2=Saída, 3=Devolução
            'id_cliente'      => $dados_da_venda['id_cliente'],
            'id_venda'        => $dados_da_venda['id_venda'],
            'id_empresa'      => $this->id_empresa
        ]);

        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'Nota Fiscal emitida com sucesso!'
            ]
        );

        return redirect()->to("/vendas/show/{$dados_da_venda['id_venda']}");
    }

    public function NFeAvulsaEntrada()
    {
        $dados = $this->request->getVar();

        $dados_do_emitente = $this->empresa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
                                ->first();

        $produtos_da_nota = $this->nfe_avulsa_produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $valor_da_nota = 0;
        foreach($produtos_da_nota as $produto):
            $valor_da_nota += (($produto['quantidade'] * $produto['valor_unitario']) - $produto['desconto']);
        endforeach;

        // ----- MONTA XML
        $nfe = $this->montaXmlEntrada($dados_do_emitente, $produtos_da_nota, $dados);
        $xml = $nfe->getXML();

        // ----- PREPARA O CONFIG_JSON
        $config_json = $this->preparaConfigJson($dados_do_emitente);

        // ----- ASSINA XML
        $xml_assinado = $this->assinaXML($dados_do_emitente, $config_json, $xml);

        // ----- ENVIA LOTE PARA A SEFAZ
        $numero_do_recibo = $this->enviaLoteParaSefaz($xml_assinado);

        // ----- CONSULTA RECIBO NA SEFAZ
        $protocolo = $this->consultaReciboNaSefaz($numero_do_recibo);

        // ----- AUTORIZA USO DA NOTA - SEFAZ
        $xml_protocolado = $this->protocolaXmlNaSefaz($xml_assinado, $protocolo);

        // ----------------- Adiciona +1 no número da nota ----------------- //
        if($dados_do_emitente['tpAmb_NFe'] == 1) :

            $nova_nNF = $dados_do_emitente['nNF_producao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_producao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_producao'];
        
        else:

            $nova_nNF = $dados_do_emitente['nNF_homologacao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_homologacao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_homologacao'];

        endif;

        // ------------------------------------------------------------- //
        
        // Salva os dados da NFe no banco de dados
        $id_nfe = $this->nfe_avulsa_model->insert([
            'numero_da_nota' => $guarda_numero_da_nota,
            'chave'          => $nfe->getChave(),
            'valor_da_nota'  => $valor_da_nota,
            'data'           => date('Y-m-d'),
            'hora'           => date('H:i:s'),
            'xml'            => $xml_protocolado,
            'protocolo'      => $protocolo,
            'status'         => "Emitida",
            'tipo'           => 1, // 1=Entrada, 2=Saída, 3=Devolução
            'id_empresa'     => $this->id_empresa
        ]);

        // Remove todos os registros dos produtos da nfe avulsa
        $this->nfe_avulsa_produto_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // Emite um alerta na sessão
        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'NFe de Entrada Avulsa emitida com sucesso!'
            ]
        );

        return redirect()->to("/NFeAvulsa/entrada");
    }

    public function NFeAvulsaSaida()
    {
        $dados = $this->request->getVar();

        // Remove mascaras //
        if($dados['tipo'] == 2):
            $dados['cnpj'] = removeMascara($dados['cnpj']);
        else:
            $dados['cpf'] = removeMascara($dados['cpf']);
        endif;

        $dados['cep'] = removeMascara($dados['cep']);
        // ------- //

        // Converte de BRL para USD
        $dados['troco'] = converteMoney($dados['troco']);

        $dados_do_emitente = $this->empresa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
                                ->first();

        $produtos_da_nota = $this->nfe_avulsa_produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $valor_da_nota = 0;
        foreach($produtos_da_nota as $produto):
            $valor_da_nota += (($produto['quantidade'] * $produto['valor_unitario']) - $produto['desconto']);
        endforeach;

        // ----- MONTA XML
        $nfe = $this->montaXmlSaidaNFeAvulsa($dados_do_emitente, $produtos_da_nota, $dados);
        $xml = $nfe->getXML();

        // ----- PREPARA O CONFIG_JSON
        $config_json = $this->preparaConfigJson($dados_do_emitente);

        // ----- ASSINA XML
        $xml_assinado = $this->assinaXML($dados_do_emitente, $config_json, $xml);

        // ----- ENVIA LOTE PARA A SEFAZ
        $numero_do_recibo = $this->enviaLoteParaSefaz($xml_assinado);

        // ----- CONSULTA RECIBO NA SEFAZ
        $protocolo = $this->consultaReciboNaSefaz($numero_do_recibo);

        // ----- AUTORIZA USO DA NOTA - SEFAZ
        $xml_protocolado = $this->protocolaXmlNaSefaz($xml_assinado, $protocolo);

        // ----------------- Adiciona +1 no número da nota ----------------- //
        if($dados_do_emitente['tpAmb_NFe'] == 1) :

            $nova_nNF = $dados_do_emitente['nNF_producao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_producao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_producao'];
        
        else:

            $nova_nNF = $dados_do_emitente['nNF_homologacao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_homologacao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_homologacao'];

        endif;

        // ------------------------------------------------------------- //
        
        // Salva os dados da NFe no banco de dados
        $id_nfe = $this->nfe_avulsa_model->insert([
            'numero_da_nota' => $guarda_numero_da_nota,
            'chave'          => $nfe->getChave(),
            'valor_da_nota'  => $valor_da_nota,
            'data'           => date('Y-m-d'),
            'hora'           => date('H:i:s'),
            'xml'            => $xml_protocolado,
            'protocolo'      => $protocolo,
            'status'         => "Emitida",
            'tipo'           => 2, // 1=Entrada, 2=Saída, 3=Devolução
            'id_empresa'     => $this->id_empresa
        ]);

        // Remove todos os registros dos produtos da nfe avulsa
        $this->nfe_avulsa_produto_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // Emite um alerta na sessão
        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'NFe de Saída Avulsa emitida com sucesso!'
            ]
        );

        return redirect()->to("/NFeAvulsa/saida");
    }

    public function NFeAvulsaDevolucao()
    {
        $dados = $this->request->getVar();

        // Remove mascaras //
        if($dados['tipo'] == 2):
            $dados['cnpj'] = removeMascara($dados['cnpj']);
        else:
            $dados['cpf'] = removeMascara($dados['cpf']);
        endif;

        $dados['cep'] = removeMascara($dados['cep']);
        // ------- //

        $dados_do_emitente = $this->empresa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
                                ->first();

        $produtos_da_nota = $this->nfe_avulsa_produto_model
                                ->where('id_empresa', $this->id_empresa)
                                ->findAll();

        $valor_da_nota = 0;
        foreach($produtos_da_nota as $produto):
            $valor_da_nota += (($produto['quantidade'] * $produto['valor_unitario']) - $produto['desconto']);
        endforeach;

        // ----- MONTA XML
        $nfe = $this->montaXmlDevolucaoNFeAvulsa($dados_do_emitente, $produtos_da_nota, $dados);
        $xml = $nfe->getXML();

        // ----- PREPARA O CONFIG_JSON
        $config_json = $this->preparaConfigJson($dados_do_emitente);

        // ----- ASSINA XML
        $xml_assinado = $this->assinaXML($dados_do_emitente, $config_json, $xml);

        // ----- ENVIA LOTE PARA A SEFAZ
        $numero_do_recibo = $this->enviaLoteParaSefaz($xml_assinado);

        // ----- CONSULTA RECIBO NA SEFAZ
        $protocolo = $this->consultaReciboNaSefaz($numero_do_recibo);

        // ----- AUTORIZA USO DA NOTA - SEFAZ
        $xml_protocolado = $this->protocolaXmlNaSefaz($xml_assinado, $protocolo);

        // ----------------- Adiciona +1 no número da nota ----------------- //
        if($dados_do_emitente['tpAmb_NFe'] == 1) :

            $nova_nNF = $dados_do_emitente['nNF_producao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_producao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_producao'];
        
        else:

            $nova_nNF = $dados_do_emitente['nNF_homologacao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNF_homologacao', $nova_nNF)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNF_homologacao'];

        endif;

        // ------------------------------------------------------------- //
        
        // Salva os dados da NFe no banco de dados
        $id_nfe = $this->nfe_avulsa_model->insert([
            'numero_da_nota' => $guarda_numero_da_nota,
            'chave'          => $nfe->getChave(),
            'valor_da_nota'  => $valor_da_nota,
            'data'           => date('Y-m-d'),
            'hora'           => date('H:i:s'),
            'xml'            => $xml_protocolado,
            'protocolo'      => $protocolo,
            'status'         => "Emitida",
            'tipo'           => 2, // 1=Entrada, 2=Saída, 3=Devolução
            'id_empresa'     => $this->id_empresa
        ]);

        // Remove todos os registros dos produtos da nfe avulsa
        $this->nfe_avulsa_produto_model
            ->where('id_empresa', $this->id_empresa)
            ->delete();

        // Emite um alerta na sessão
        $this->session->setFlashdata(
            'alert',
            [
                'type' => 'success',
                'title' => 'NFe de Devolução Avulsa emitida com sucesso!'
            ]
        );

        return redirect()->to("/NFeAvulsa/devolucao");
    }

    public function cancelar()
    {
        // Dados
        $id_nfe = $this->request
                        ->getvar('id_nfe');

        // Justificativa para o cancelamento
        $justificativa = $this->request
                                ->getvar('justificativa');

        $nfe = $this->nfe_model
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_nfe', $id_nfe)
                    ->first();

        // Pega o numero do protocolo da XML
        $string_1 = explode('<nProt>', $nfe['protocolo']);
        $string_2 = explode('</nProt>', $string_1[1]);

        $num_do_protocolo = $string_2[0];
        // ---------------------------------

        try {

            // Dados da config da NFe
            $dados_do_emitente = $this->empresa_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                    ->first();

            $configJson = $this->preparaConfigJson($dados_do_emitente);
            // ----------------------------------------------------------------------

            // Certificado
            $arq_certificado = WRITEPATH . "uploads/certificados/" . $dados_do_emitente['certificado'];

            $certificado_digital = file_get_contents($arq_certificado);
            // -----------

            $certificate = Certificate::readPfx($certificado_digital, $dados_do_emitente['senha_do_certificado']);
            $tools = new Tools($configJson, $certificate);
            $tools->model('55');

            $chave = $nfe['chave'];
            $xJust = $justificativa;
            $nProt = $num_do_protocolo;

            $response = $tools->sefazCancela($chave, $xJust, $nProt);

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
            //      quando houver a necessidade de protocolos
            $stdCl = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $stdCl->toStd();
            //nesse caso o $arr irá conter uma representação em array do XML
            $arr = $stdCl->toArray();
            //nesse caso o $json irá conter uma representação em JSON do XML
            $json = $stdCl->toJson();
            
            // Cria sessão para mostrar os alertas
            $session = session();

            //verifique se o evento foi processado
            if ($std->cStat != 128)
            {
                //houve alguma falha e o evento não foi processado
                $this->session->setFlashdata(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Erro ao cancelar Nota!'
                    ]    
                );
            }
            else
            {
                $cStat = $std->retEvento->infEvento->cStat;
                if ($cStat == '101' || $cStat == '135' || $cStat == '155')
                {
                    //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
                    $xml = Complements::toAuthorize($tools->lastRequest, $response);
                    
                    // Adiciona o XML Protocolado no banco de dados e altera o status
                    $this->nfe_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_nfe', $id_nfe)
                        ->set([
                            'xml' => $xml,
                            'status' => 'Cancelada'
                        ])
                        ->update();

                    $this->session->setFlashdata(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Nota cancelada com sucesso!'
                        ]    
                    );
                }
                else
                {
                    //houve alguma falha no evento 
                    //TRATAR
                    $this->session->setFlashdata(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Erro ao cancelar Nota!'
                        ]    
                    );
                }
            }

            // Retorna para a página NFe/listar

            return redirect()->to(base_url('controleFiscal/nfe'));
        }
        catch (\Exception $e)
        {
            exit($e->getMessage());
        }
    }

    public function cancelar_avulsa()
    {
        // Dados
        $id_nfe = $this->request
                        ->getvar('id_nfe');

        // Justificativa para o cancelamento
        $justificativa = $this->request
                                ->getvar('justificativa');

        $nfe = $this->nfe_avulsa_model
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_nfe', $id_nfe)
                    ->first();

        // Pega o numero do protocolo da XML
        $string_1 = explode('<nProt>', $nfe['protocolo']);
        $string_2 = explode('</nProt>', $string_1[1]);

        $num_do_protocolo = $string_2[0];
        // ---------------------------------

        try {

            // Dados da config da NFe
            $dados_do_emitente = $this->empresa_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                    ->first();

            $configJson = $this->preparaConfigJson($dados_do_emitente);
            // ----------------------------------------------------------------------

            // Certificado
            $arq_certificado = WRITEPATH . "uploads/certificados/" . $dados_do_emitente['certificado'];

            $certificado_digital = file_get_contents($arq_certificado);
            // -----------

            $certificate = Certificate::readPfx($certificado_digital, $dados_do_emitente['senha_do_certificado']);
            $tools = new Tools($configJson, $certificate);
            $tools->model('55');

            $chave = $nfe['chave'];
            $xJust = $justificativa;
            $nProt = $num_do_protocolo;

            $response = $tools->sefazCancela($chave, $xJust, $nProt);

            //você pode padronizar os dados de retorno atraves da classe abaixo
            //de forma a facilitar a extração dos dados do XML
            //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
            //      quando houver a necessidade de protocolos
            $stdCl = new Standardize($response);
            //nesse caso $std irá conter uma representação em stdClass do XML
            $std = $stdCl->toStd();
            //nesse caso o $arr irá conter uma representação em array do XML
            $arr = $stdCl->toArray();
            //nesse caso o $json irá conter uma representação em JSON do XML
            $json = $stdCl->toJson();
            
            // Cria sessão para mostrar os alertas
            $session = session();

            //verifique se o evento foi processado
            if ($std->cStat != 128)
            {
                //houve alguma falha e o evento não foi processado
                $this->session->setFlashdata(
                    'alert',
                    [
                        'type' => 'success',
                        'title' => 'Erro ao cancelar Nota!'
                    ]    
                );
            }
            else
            {
                $cStat = $std->retEvento->infEvento->cStat;
                if ($cStat == '101' || $cStat == '135' || $cStat == '155')
                {
                    //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
                    $xml = Complements::toAuthorize($tools->lastRequest, $response);
                    
                    // Adiciona o XML Protocolado no banco de dados e altera o status
                    $this->nfe_avulsa_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_nfe', $id_nfe)
                        ->set([
                            'xml' => $xml,
                            'status' => 'Cancelada'
                        ])
                        ->update();

                    $this->session->setFlashdata(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Nota cancelada com sucesso!'
                        ]    
                    );
                }
                else
                {
                    //houve alguma falha no evento 
                    //TRATAR
                    $this->session->setFlashdata(
                        'alert',
                        [
                            'type' => 'success',
                            'title' => 'Erro ao cancelar Nota!'
                        ]    
                    );
                }
            }

            // Retorna para a página NFe/listar

            return redirect()->to(base_url('controleFiscal/nfe'));
        }
        catch (\Exception $e)
        {
            exit($e->getMessage());
        }
    }
}

?>