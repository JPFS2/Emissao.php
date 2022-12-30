<!-- Modal CUPOM NÃO FISCAL -->
<div class="modal fade" id="modal-cupom-nao-fiscal">
    <div class="modal-dialog modal-md" style="width: 300px">
        <!-- 300px = 80mm -->
        <div class="modal-content">
            <div class="modal-header no-print">
                <h4 class="modal-title">Cupom não fiscal <button type="button" class="btn btn-success style-action" onclick="print()"><i class="fas fa-print"></i></button></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="cupom-nao-fiscal">
                    <p style='text-align: center'>
                        <b><?= $empresa['xFant'] ?></b><br>
                        <?= $empresa['xNome'] ?><br>
                        <?= $empresa['xLgr'] ?>, <?= $empresa['xCpl'] ?>, <?= $empresa['nro'] ?> - <?= $empresa['municipio'] ?> - <?= $empresa['uf'] ?>.<br>
                        <?= $empresa['fone'] ?>
                    </p>

                    <p>
                        <b>CNPJ:</b> <span class="cnpj"><?= $empresa['CNPJ'] ?></span><br>
                        <b>Cliente:</b> <?= $venda['nome_do_cliente'] ?><br>
                        <?= date('d/m/Y', strtotime($venda['data'])) ?> às <?= $venda['hora'] ?> - <b>Nº <?= $venda['id_venda'] ?></b>
                    </p>

                    <hr>

                    <table width='100%'>
                        <thead>
                            <tr>
                                <th>Cód.</th>
                                <th>Desc.</th>
                                <th>Qtd X Unit.</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos_da_venda as $produto) : ?>
                                <tr>
                                    <td><?= $produto['id_produto'] ?></td>
                                    <td><?= $produto['nome'] ?></td>
                                    <td><?= $produto['quantidade'] ?> x <?= number_format($produto['valor_unitario'], 2, ',', '.') ?></td>
                                    <td><?= number_format($produto['valor_final'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <hr>

                    <p>
                        <b>Total:</b> <?= number_format($venda['valor_a_pagar'], 2, ',', '.') ?><br>
                        <b>Recebido:</b> <?= number_format($venda['valor_recebido'], 2, ',', '.') ?><br>
                        <b>Troco:</b> <?= number_format($venda['troco'], 2, ',', '.') ?><br>
                    </p>

                    <hr>

                    <p><b>Vendedor:</b> <?= $venda['nome_do_vendedor'] ?></p>

                    <hr>

                    <p style='text-align: center'>
                        ____________________________
                        <br>
                        Assinatura do Cliente
                    </p>
                </div>
            </div>
            <div class="modal-footer justify-content-between no-print">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="print()"><i class="fas fa-print"></i> Imprimir Cupom</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal CANCELAMENTO -->
<div class="modal fade" id="modal-justificativa-para-cancelamento-da-nfe">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h4 class="modal-title">Cancelar NFe</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/NFe/cancelar" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Justificativa</label>
                                <textarea class="form-control" name="justificativa" rows="10" required=""></textarea>
                            </div>
                        </div>

                        <!-- HIDDENS -->
                        <input type="hidden" id="cancelar_id_nfe" name="id_nfe">
                        <input type="hidden" id="cancelar_id_venda" name="id_venda">
                    </div>
                </div>
                <div class="modal-footer justify-content-between no-print">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Continuar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal CPF/CNPJ na Nota -->
<div class="modal fade" id="modal-cpf-cnpj-na-nota">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">CPF ou CNPJ na Nota</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-emitir-nota" action="/NFCe/emitirNota/<?= $id_venda ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Tipo</label>
                                <select class="form-control select2" id="tipo" onchange="alteraTipoIdentificacaoNaNota()" style="width: 100%">
                                    <option value="CPF" selected>CPF</option>
                                    <option value="CNPJ">CNPJ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">CPF</label>
                                <input type="text" class="form-control cpf" id="cpf" name="CPF" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">CNPJ</label>
                                <input type="text" class="form-control cnpj" id="cnpj" name="CNPJ" disabled required>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <a href="/NFCe/emitirNota/<?= $id_venda ?>" class="btn btn-success">Sem CPF/CNPJ na Nota</a>
                    <button type="submit" class="btn btn-success">Emitir NFCe</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal EMITIR NOTA -->
<div class="modal fade" id="modal-emitir-nfe">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h4 class="modal-title">Emitir NFe</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/NFe/emitirNotaDeSaida/<?= $id_venda ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Natureza da Operação</label>
                                <input type="text" class="form-control" name="natureza_da_operacao" value="VENDA DE MERCADORIAS" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 style="text-align: center">Transporte</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 25px">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Tipo</label>
                                <select class="form-control select2" id="tipo_do_transporte" name="tipo" onchange="habilitaCamposTransporte()" style="width: 100%" required>
                                    <option value="9">Sem transporte</option>
                                    <option value="0">Por conta do Remetete</option>
                                    <option value="1">Por conta do Destinatário</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Transportadora</label>
                                <select class="form-control select2" id="id_transportadora" name="id_transportadora" style="width: 100%" required disabled>
                                    <?php if (!empty($transportadoras)) : ?>
                                        <?php foreach ($transportadoras as $transportadora) : ?>
                                            <option value="<?= $transportadora['id_transportadora'] ?>"><?= $transportadora['xNome'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Qtd. Volume</label>
                                <input type="text" class="form-control" id="qtd_volume" name="qVol" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Unidade</label>
                                <select class="form-control select2" id="unidade" name="id_unidade" style="width: 100%" required disabled>
                                    <?php if (!empty($unidades)) :  ?>
                                        <?php foreach ($unidades as $unidade) : ?>
                                            <option value="<?= $unidade['id_unidade'] ?>"><?= $unidade['unidade'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Peso Liq.</label>
                                <input type="text" class="form-control" id="peso_liquido" name="pesoL" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Peso Bruto</label>
                                <input type="text" class="form-control" id="peso_bruto" name="pesoB" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 25px">
                        <div class="col-lg-12">
                            <h4 style="text-align: center">Informações</h4>
                            <hr>
                        </div>
                        <div class="col-lg-6">
                            <label for="">Inf. Complementares</label>
                            <input type="text" class="form-control" name="informacoes_complementares">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Inf. para o Fisco</label>
                            <input type="text" class="form-control" name="informacoes_para_fisco">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between no-print">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Finalizar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper no-print">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?></h6>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="/vendas" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
                                <?php foreach ($caminhos as $caminho) : ?>
                                    <?php if (!$caminho['active']) : ?>
                                        <li class="breadcrumb-item"><a href="<?= $caminho['rota'] ?>"><?= $caminho['titulo'] ?></a></li>
                                    <?php else : ?>
                                        <li class="breadcrumb-item active"><?= $caminho['titulo'] ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ol>
                        </div><!-- /.col -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body no-print">
                    <div class="row">
                        <div class="col-lg-8">

                            <?php // Caso exista id_nfe então foi emitida uma nfe 
                            ?>
                            <?php if (isset($id_nfe)) : ?>
                                <a href="/ImpressaoDANFe/imprimir/1/<?= $id_nfe ?>" target="_blank" class="btn btn-success">Imprimir NFe</a>
                            <?php else : ?>
                                <?php if ($venda['id_cliente'] != 1) : ?>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-emitir-nfe">Emitir NFe</button>
                                <?php else : ?>
                                    <button type="button" class="btn btn-info" onclick="alert('Não é permitido emitir NFe para o cliente CONSUMIDOR FINAL pois ele não possui CPF e Endereço.')">Emitir NFe</button>
                                <?php endif; ?>

                            <?php endif; ?>

                            <?php if (isset($id_nfce)) : ?>
                                <a href="/ImpressaoDANFe/imprimir/2/<?= $id_nfce ?>" target="_blank" class="btn btn-success">Imprimir NFCe</a>
                            <?php else : ?>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-cpf-cnpj-na-nota">Emitir NFCe</button>
                            <?php endif; ?>

                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-cupom-nao-fiscal" onclick="preparaImpressao()"><i class="fas fa-print"></i> Cupom NÃO Fiscal</button>
                        </div>
                        <div class="col-lg-4">
                            <a href="/vendas/edit/<?= $id_venda ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editar Venda</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?></h6>
                        </div><!-- /.col -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Cód. da Venda</label>
                                <input type="text" class="form-control" value="<?= $venda['id_venda'] ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Valor da Venda</label>
                                <input type="text" class="form-control" value="<?= number_format($venda['valor_a_pagar'], 2, ',', '.') ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Valor Recebido</label>
                                <input type="text" class="form-control" value="<?= number_format($venda['valor_recebido'], 2, ',', '.') ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Troco</label>
                                <input type="text" class="form-control" value="<?= number_format($venda['troco'], 2, ',', '.') ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Cliente</label>
                                <input type="text" class="form-control" value="<?= ($venda['tipo'] == 1) ? $venda['nome'] : $venda['razao_social'] ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Vendedor</label>
                                <input type="text" class="form-control" value="<?= $venda['nome_do_vendedor'] ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Cód. do Caixa</label>
                                <input type="text" class="form-control" value="<?= $venda['id_caixa'] ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Data</label>
                                <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($venda['data'])) ?>" disabled="">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Hora</label>
                                <input type="text" class="form-control" value="<?= $venda['hora'] ?>" disabled="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="14" style="text-align: center">FORMAS DE PAGAMENTO</th>
                                    </tr>
                                    <tr>
                                        <th>Forma</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($formas_de_pagamento_da_venda as $forma) : ?>
                                        <tr>
                                            <td><?= $forma['nome'] ?></td>
                                            <td><?= number_format($forma['valor'], 2, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="16" style="text-align: center">PRODUTOS DA VENDA</th>
                            </tr>
                            <tr>
                                <th>Cód.</th>
                                <th>Nome</th>
                                <th>UN</th>
                                <th>Cod. Barras</th>
                                <th>Qtd</th>
                                <th>Valor Unit.</th>
                                <th>Subtotal</th>
                                <th>Desc.</th>
                                <th>Valor Final</th>
                                <th>NCM</th>
                                <th>CSOSN</th>
                                <th>CFOP NFe</th>
                                <th>CFOP NFCe</th>
                                <th>CFOP Externo</th>
                                <th>Porc. ICMS</th>
                                <th>PIS/COFINS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $valor_calculado_da_venda = 0 ?>

                            <?php foreach ($produtos_da_venda as $produto) : ?>
                                <tr>
                                    <td><?= $produto['id_produto_da_venda'] ?></td>
                                    <td><?= $produto['nome'] ?></td>
                                    <td><?= $produto['unidade'] ?></td>
                                    <td><?= $produto['codigo_de_barras'] ?></td>
                                    <td><?= $produto['quantidade'] ?></td>
                                    <td><?= number_format($produto['valor_unitario'], 2, ',', '.') ?></td>
                                    <td><?= number_format($produto['subtotal'], 2, ',', '.') ?></td>
                                    <td><?= number_format($produto['desconto'], 2, ',', '.') ?></td>
                                    <td><?= number_format($produto['valor_final'], 2, ',', '.') ?></td>
                                    <td><?= $produto['NCM'] ?></td>
                                    <td><?= $produto['CSOSN'] ?></td>
                                    <td><?= $produto['CFOP_NFe'] ?></td>
                                    <td><?= $produto['CFOP_NFCe'] ?></td>
                                    <td><?= $produto['CFOP_Externo'] ?></td>
                                    <td><?= $produto['porcentagem_icms'] ?></td>
                                    <td><?= $produto['pis_cofins'] ?></td>
                                </tr>

                                <?php $valor_calculado_da_venda += $produto['valor_final'] ?>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function alteraTipoIdentificacaoNaNota() {
        var opcao = document.getElementById('tipo').value;

        if (opcao == 'CPF') {
            document.getElementById('cnpj').disabled = true;
            document.getElementById('cpf').disabled = false;
        } else {
            document.getElementById('cnpj').disabled = false;
            document.getElementById('cpf').disabled = true;
        }
    }

    function preparaImpressao() {
        document.getElementById('footer').className += " no-print";
    }

    function habilitaCamposTransporte() {
        var opcao = document.getElementById('tipo_do_transporte').value;

        if (opcao != 9) {
            document.getElementById('id_transportadora').disabled = false;
            document.getElementById('qtd_volume').disabled = false;
            document.getElementById('unidade').disabled = false;
            document.getElementById('peso_liquido').disabled = false;
            document.getElementById('peso_bruto').disabled = false;
        } else {
            document.getElementById('id_transportadora').disabled = true;
            document.getElementById('qtd_volume').disabled = true;
            document.getElementById('unidade').disabled = true;
            document.getElementById('peso_liquido').disabled = true;
            document.getElementById('peso_bruto').disabled = true;
        }
    }

    <?php if (isset($_GET['emitir_nfce_pdv'])) : ?>
        $(function() {
            //Abre modal
            $('#modal-cpf-cnpj-na-nota').modal('show')
        });
    <?php endif; ?>
</script>