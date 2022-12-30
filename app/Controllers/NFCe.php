<?php

namespace App\Controllers;

use App\Models\FormaDePagamentoDaVendaModel;
use App\Models\NFCeModel;
use App\Models\VendaModel;
use App\Models\ProdutoDaVendaModel;
use App\Models\EmpresaModel;

use CodeIgniter\Controller;

use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Complements;

use stdClass;


class NFCe extends Controller
{
    private $session;
    private $id_empresa;

    private $data_e_hora;

    private $forma_de_pagamento_da_venda_model;
    private $nfce_model;
    private $venda_model;
    private $produto_da_venda_model;
    private $uf_model;
    private $empresa_model;

    function __construct()
    {
        $this->helpers = ['app'];

        $this->session     = session();
        $this->id_empresa  = $this->session->get('id_empresa');

        $this->data_e_hora = date('Y-m-d\TH:i:sP');

        $this->forma_de_pagamento_da_venda_model = new FormaDePagamentoDaVendaModel();
        $this->nfce_model                        = new NFCeModel();
        $this->venda_model                       = new VendaModel();
        $this->produto_da_venda_model            = new ProdutoDaVendaModel();
        $this->empresa_model                     = new EmpresaModel();
        
        require_once APPPATH . "ThirdParty/sped-nfe/vendor/autoload.php";
    }

    public function montaXml($dados_do_emitente, $dados, $produtos_da_nota, $venda)
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
        $ide->natOp    = "VENDA DE MERCADORIAS";
        $ide->mod      = 65;
        $ide->serie    = $dados_do_emitente['serie'];

        if($dados_do_emitente['tpAmb_NFCe'] == 1) :
            $numero_da_nf = $dados_do_emitente['nNFC_producao'];
        else:
            $numero_da_nf = $dados_do_emitente['nNFC_homologacao'];
        endif;

        $ide->nNF      = $numero_da_nf;
        $ide->dhEmi    = $this->data_e_hora;
        $ide->dhSaiEnt = null;
        $ide->tpNF     = 1;
        $ide->idDest   = 1;
        $ide->cMunFG   = $dados_do_emitente['codigo'];
        $ide->tpImp    = 4;
        $ide->tpEmis   = 1;
        $ide->cDV      = 0;
        $ide->tpAmb    = $dados_do_emitente['tpAmb_NFCe'];
        $ide->finNFe   = 1;
        $ide->indFinal = 1;
        $ide->indPres  = 1;
        $ide->procEmi  = 0;
        $ide->verProc  = "4.0.5";
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

        // ------------ CPF/CNPJ na Nota -------------- //
        if(isset($dados['CPF']) || isset($dados['CNPJ'])) :

            $destinatario = new stdClass();

                if(isset($dados['CPF'])) :
                    $destinatario->CPF = removeMascara($dados['CPF']);
                else :
                    $destinatario->CNPJ = removeMascara($dados['CNPJ']);
                endif;

            $nfe->tagdest($destinatario);

        endif;

        // ------------------------------------------- //

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
            $std_produto->CFOP   = removeMascara($produto['CFOP_NFCe']);
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
        $transporte->modFrete = 9;
        $nfe->tagtransp($transporte);

        // ----------- Tag PAGAMENTO ------------- //
        $pagamento = new stdClass();
        $pagamento->vTroco = format($venda['troco']);
        $nfe->tagpag($pagamento);
        
        // Pega as formas de pagamento da venda
        $formas_de_pagamento_da_venda = $this->forma_de_pagamento_da_venda_model
                                                            ->where('id_empresa', $this->id_empresa)
                                                            ->where('id_venda', $dados['id_venda'])
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

        // Verifica se todos os campos foram preenchidos corretamente e depois gera o XML
        try
        {
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
            "tpAmb"       => intval($dados_do_emitente['tpAmb_NFCe']),
            "razaosocial" => $dados_do_emitente['xNome'],
            "cnpj"        => $dados_do_emitente['CNPJ'], // PRECISA SER VÁLIDO
            "ie"          => $dados_do_emitente['IE'], // PRECISA SER VÁLIDO
            "siglaUF"     => $dados_do_emitente['uf'],
            "schemes"     => "PL_009_V4",
            "versao"      => '4.00',
            "tokenIBPT"   => "AAAAAAA",
            "CSC"         => $dados_do_emitente['CSC'],
            "CSCid"       => $dados_do_emitente['CSC_Id']
        ];

        return json_encode($config);
    }

    public function assinaXML($dados_do_emitente, $config_json, $xml)
    {
        /*---------------------------------------------------------------------------------------------------------------------------------------*/
        $arq_certificado     = WRITEPATH . "uploads/certificados/" . $dados_do_emitente['certificado'];
        $certificado_digital = file_get_contents($arq_certificado);

        $this->tools = new Tools($config_json, Certificate::readPfx($certificado_digital, $dados_do_emitente['senha_do_certificado']));
        $this->tools->model('65'); // Informa que será usado para emissão do NFCe mod 65. Obrigatório pela API SpedNFe

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
            $resp    = $this->tools->sefazEnviaLote([$xml_assinado], $id_lote, 1);

            $st  = new Standardize();
            $std = $st->toStd($resp);

            if ($std->cStat != 103)
            {
                if ($std->cStat == '104') { //lote processado (tudo ok)
                    if ($std->protNFe->infProt->cStat == '100') { //Autorizado o uso da NF-e
                        return $resp;
                    } elseif (in_array($std->protNFe->infProt->cStat, ["110", "301", "302"])) { //DENEGADAS
                        exit("{[$std->protNFe->infProt->cStat]} {$std->protNFe->infProt->xMotivo}");
                    } else { //não autorizada (rejeição)
                        //erro registrar e voltar
                        exit("[{$std->protNFe->infProt->cStat}] {$std->protNFe->infProt->xMotivo}");
                    }
                }
            }
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

    public function emitirNota($id_venda)
    {
        $dados = $this->request->getVar();

        $dados['id_venda'] = $id_venda;

        $dados_do_emitente = $this->empresa_model
                                ->where('id_empresa', $this->id_empresa)
                                ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
                                ->first();

        $produtos_da_nota = $this->produto_da_venda_model
                                ->where('id_empresa', $this->id_empresa)
                                ->where('id_venda', $id_venda)
                                ->findAll();

        $venda = $this->venda_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_venda', $id_venda)
                        ->first();

        // ----- MONTA XML
        $nfce = $this->montaXml($dados_do_emitente, $dados, $produtos_da_nota, $venda);
        $xml = $nfce->getXML();
		

        // ----- PREPARA O CONFIG_JSON
        $config_json = $this->preparaConfigJson($dados_do_emitente);

        // ----- ASSINA XML
        $xml_assinado = $this->assinaXML($dados_do_emitente, $config_json, $xml);

        // ----- ENVIA LOTE PARA A SEFAZ
        $protocolo = $this->enviaLoteParaSefaz($xml_assinado);

        // ----- AUTORIZA USO DA NOTA - SEFAZ
        $xml_protocolado = $this->protocolaXmlNaSefaz($xml_assinado, $protocolo);

        // ------------------------------------------------------------- //
        if($dados_do_emitente['tpAmb_NFCe'] == 1) :

            $nova_nNFC = $dados_do_emitente['nNFC_producao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNFC_producao', $nova_nNFC)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNFC_producao'];
        
        else:

            $nova_nNFC = $dados_do_emitente['nNFC_homologacao'] +1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNFC_homologacao', $nova_nNFC)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNFC_homologacao'];

        endif;

        // ------------------------------------------------------------- //

        // Salva os dados da NFe no banco de dados
        $this->nfce_model->insert([
            'chave'           => $nfce->getChave(),
            'numero'          => $guarda_numero_da_nota,
            'valor_da_nota'   => $venda['valor_a_pagar'],
            'data'            => $venda['data'],
            'hora'            => $venda['hora'],
            'xml'             => $xml_protocolado,
            'protocolo'       => $protocolo,
            'status'          => "Emitida",
            'id_venda'        => $id_venda,
            'id_cliente'      => $venda['id_cliente'],
            'id_empresa'      => $this->id_empresa
        ]);

        return redirect()->to("/vendas/show/{$id_venda}");
    }

    public function emitirNotaPDV($id_venda)
    {
        $dados = $this->request->getVar();

        $dados['id_venda'] = $id_venda;

        $dados_do_emitente = $this->empresa_model
            ->where('id_empresa', $this->id_empresa)
            ->join('ufs', 'empresas.id_uf = ufs.id_uf')
            ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
            ->first();

        $produtos_da_nota = $this->produto_da_venda_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_venda', $id_venda)
            ->findAll();

        $venda = $this->venda_model
            ->where('id_empresa', $this->id_empresa)
            ->where('id_venda', $id_venda)
            ->first();

        // ----- MONTA XML
        $nfce = $this->montaXml($dados_do_emitente, $dados, $produtos_da_nota, $venda);
        $xml = $nfce->getXML();

        // ----- PREPARA O CONFIG_JSON
        $config_json = $this->preparaConfigJson($dados_do_emitente);

        // ----- ASSINA XML
        $xml_assinado = $this->assinaXML($dados_do_emitente, $config_json, $xml);

        // ----- ENVIA LOTE PARA A SEFAZ
        $protocolo = $this->enviaLoteParaSefaz($xml_assinado);

        // ----- AUTORIZA USO DA NOTA - SEFAZ
        $xml_protocolado = $this->protocolaXmlNaSefaz($xml_assinado, $protocolo);

        // ------------------------------------------------------------- //
        if ($dados_do_emitente['tpAmb_NFCe'] == 1) :

            $nova_nNFC = $dados_do_emitente['nNFC_producao'] + 1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNFC_producao', $nova_nNFC)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNFC_producao'];

        else :

            $nova_nNFC = $dados_do_emitente['nNFC_homologacao'] + 1; // Incrementa +1 e atualiza

            $this->empresa_model
                ->where('id_empresa', $this->id_empresa)
                ->set('nNFC_homologacao', $nova_nNFC)
                ->update();

            // Guarda o número da nota para salvar no banco de dados
            $guarda_numero_da_nota = $dados_do_emitente['nNFC_homologacao'];

        endif;

        // ------------------------------------------------------------- //

        // Salva os dados da NFe no banco de dados
        $id_nfce = $this->nfce_model->insert([
            'chave'           => $nfce->getChave(),
            'numero'          => $guarda_numero_da_nota,
            'valor_da_nota'   => $venda['valor_a_pagar'],
            'data'            => $venda['data'],
            'hora'            => $venda['hora'],
            'xml'             => $xml_protocolado,
            'protocolo'       => $protocolo,
            'status'          => "Emitida",
            'id_venda'        => $id_venda,
            'id_cliente'      => $venda['id_cliente'],
            'id_empresa'      => $this->id_empresa
        ]);

        // Retorna o endereço pra imprimir a DANFCe
        echo "/ImpressaoDANFe/imprimir/2/" . $id_nfce;
    }

    public function cancelar()
    {
        // Dados
        $id_nfce = $this->request
                        ->getvar('id_nfce');

        // Justificativa para o cancelamento
        $justificativa = $this->request
                            ->getvar('justificativa');

        $nfce = $this->nfce_model
                    ->where('id_empresa', $this->id_empresa)
                    ->where('id_nfce', $id_nfce)
                    ->first();

        // Pega o numero do protocolo da XML
        $string_1 = explode('<nProt>', $nfce['protocolo']);
        $string_2 = explode('</nProt>', $string_1[1]);

        $num_do_protocolo = $string_2[0];
        // ---------------------------------

        try {

            // Dados da config da NFe
            $dados_do_emitente = $this->empresa_model
                                    ->where('id_empresa', $this->id_empresa)
                                    ->join('ufs', 'empresas.id_uf = ufs.id_uf')
                                    ->join('municipios', 'empresas.id_municipio = municipios.id_municipio')
                                    ->first();

            $configJson = $this->preparaConfigJson($dados_do_emitente);
            // ----------------------------------------------------------------------

            // Certificado
            $arq_certificado    = WRITEPATH . "uploads/certificados/" . $dados_do_emitente['certificado'];
            $certificado_digital = file_get_contents($arq_certificado);
            // -----------

            $certificate = Certificate::readPfx($certificado_digital, $dados_do_emitente['senha_do_certificado']);
            $tools = new Tools($configJson, $certificate);
            $tools->model('65');

            $chave = $nfce['chave'];
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
                //TRATAR
                $this->session->setFlashdata(
                    'alert',
                    [
                        'type' => 'error',
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
                    $this->nfce_model
                        ->where('id_empresa', $this->id_empresa)
                        ->where('id_nfce', $id_nfce)
                        ->set([
                            'xml'     => $xml,
                            'status'  => 'Cancelada'
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
                            'type' => 'error',
                            'title' => 'Erro ao cancelar Nota!',
                        ]
                    );

                }
            }

            // Retorna para a página NFe/listar

            return redirect()->to(base_url('controleFiscal/nfce'));
        }
        catch (\Exception $e)
        {
            exit($e->getMessage());
        }
    }
}