<!-- Modal Altera Quantidade -->
<div class="modal fade" id="alterar-qtd-do-produto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar QTD</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/vendaRapida/alteraQuantidade" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Nova QTD</label>
                                <input type="hidden" class="form-control" id="id_produto_da_venda_rapida" name="id_produto_da_venda_rapida">
                                <input type="number" class="form-control" name="quantidade">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Continuar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Altera Desconto -->
<div class="modal fade" id="alterar-desconto-do-produto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Desconto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/vendaRapida/alteraDesconto" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Desconto</label>
                                <input type="hidden" class="form-control" id="id_produto_da_venda_rapida_desconto" name="id_produto_da_venda_rapida">
                                <input type="text" class="form-control money" name="desconto">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Continuar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Altera Valor Unitário -->
<div class="modal fade" id="alterar-valor-unitario-do-produto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Valor Unitário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/vendaRapida/alteraValorUnitario" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Valor Unitário</label>
                                <input type="hidden" class="form-control" id="id_produto_da_venda_rapida_valor_unitario" name="id_produto_da_venda_rapida">
                                <input type="text" class="form-control money" name="valor_unitario">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Continuar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" style="margin-bottom: 15px">
                <div class="col-sm-6">
                    <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?></h6>
                </div><!-- /.col -->
                <div class="col-sm-6 no-print">
                    <ol class="breadcrumb float-sm-right">
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
            <div class="card">
                <div class="card-body">
                    <form action="/vendaRapida/addProdutoDaVenda" method="post">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Produto</label>
                                    <select class="form-control select2" name="id_produto" style="width: 100%;" required="">
                                        <?php if (!empty($produtos_do_estoque)) : ?>
                                            <?php foreach ($produtos_do_estoque as $produto) : ?>
                                                <option value="<?= $produto['id_produto'] ?>"><?= $produto['nome'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Cód. de Barras</label>
                                    <input type="text" class="form-control" name="codigo_de_barras" autofocus>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Qtd</label>
                                    <input type="text" class="form-control" name="quantidade" value="1" required="">
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-block" style="margin-top: 31px"><i class="fas fa-plus-circle"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cód</th>
                                            <th>Nome</th>
                                            <th>Qtd</th>
                                            <th>Valor Unit.</th>
                                            <th>Subtotal</th>
                                            <th>Desconto</th>
                                            <th>Valor Final</th>
                                            <th style="width: 10px">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($produtos_da_venda_rapida)) : ?>
                                            <?php foreach ($produtos_da_venda_rapida as $produto) : ?>
                                                <tr>
                                                    <td><?= $produto['id_produto'] ?></td>
                                                    <td><?= $produto['nome'] ?></td>
                                                    <!-- <td><?= $produto['quantidade'] ?></td> -->
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#alterar-qtd-do-produto" onclick="document.getElementById('id_produto_da_venda_rapida').value = <?= $produto['id_produto_da_venda_rapida'] ?>">
                                                            <?= $produto['quantidade'] ?>
                                                        </a>
                                                    </td>
                                                    <!-- <td><?= number_format($produto['valor_unitario'], 2, ',', '.') ?></td> -->
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#alterar-valor-unitario-do-produto" onclick="document.getElementById('id_produto_da_venda_rapida_valor_unitario').value = <?= $produto['id_produto_da_venda_rapida'] ?>">
                                                            <?= number_format($produto['valor_unitario'], 2, ',', '.') ?>
                                                        </a>
                                                    </td>
                                                    <td><?= number_format($produto['subtotal'], 2, ',', '.') ?></td>
                                                    <!-- <td><?= number_format($produto['desconto'], 2, ',', '.') ?></td> -->
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#alterar-desconto-do-produto" onclick="document.getElementById('id_produto_da_venda_rapida_desconto').value = <?= $produto['id_produto_da_venda_rapida'] ?>">
                                                            <?= number_format($produto['desconto'], 2, ',', '.') ?>
                                                        </a>
                                                    </td>
                                                    <td><?= number_format($produto['valor_final'], 2, ',', '.') ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse produto da venda?', '/vendaRapida/deleteProduto/<?= $produto['id_produto_da_venda_rapida'] ?>')"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="8">Nenhum registro!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="text-align: center; background: #E9ECEF">FORMAS DE PAGAMENTO</th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <select class="form-control select2" id="id_forma" style="width: 100%;" required="">
                                                        <?php foreach ($formas_de_pagamento as $forma) : ?>
                                                            <option value="<?= $forma['id_forma'] ?>"><?= $forma['nome'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                                <th width=110>
                                                    <input type="text" class="form-control money" id="valor" value="<?= number_format($restante, 2, ',', '.') ?>" required>
                                                </th>
                                                <th width=70>
                                                    <button type="button" class="btn btn-success" onclick="adicionaFormaDePagamento()"><i class="fas fa-plus-circle"></i></button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($formas_de_pagamento_da_venda_rapida)) : ?>
                                                <?php foreach ($formas_de_pagamento_da_venda_rapida as $forma) : ?>
                                                    <tr>
                                                        <td><?= $forma['nome'] ?></td>
                                                        <td><?= number_format($forma['valor'], 2, ',', '.') ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir essa Forma de Pagamento?', '/VendaRapida/deleteFormaDePagamentoDaVendaRapida/<?= $forma['id_forma_de_pagamento'] ?>')"><i class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3">Nenhum registro!</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <input type="hidden" id="input_tipo">
            <input type="hidden" id="input_id_cliente" value="1">

            <form id="form_finalizar_venda" action="/vendaRapida/store" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="m-0 text-dark"><i class="fas fa-list"></i> Dados Finais</h6>
                            </div><!-- /.col -->
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Valor da Venda</label>
                                    <input type="hidden" name="valor_a_pagar" value="<?= $valor_da_venda['valor_final'] ?>">
                                    <input type="text" class="form-control" value="<?= (!empty($valor_da_venda['valor_final'])) ? number_format($valor_da_venda['valor_final'], 2, ',', '.') : "0" ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Valor Recebido</label>
                                    <input type="hidden" name="valor_recebido" value="<?= $somatorio_formas_de_pagamento ?>">
                                    <input type="text" class="form-control" value="<?= number_format($somatorio_formas_de_pagamento, 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Restante</label>
                                    <input type="text" class="form-control" value="<?= number_format($restante, 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Troco</label>
                                    <input type="hidden" name="troco" value="<?= $troco ?>">
                                    <input type="text" class="form-control" value="<?= number_format($troco, 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <select class="form-control select2" id="id_cliente" name="id_cliente" style="width: 100%;" required="">
                                        <?php if (!empty($clientes)) : ?>
                                            <?php foreach ($clientes as $cliente) : ?>
                                                <?php if ($cliente['tipo'] == 1) : ?>
                                                    <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nome'] ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['razao_social'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Vendedor</label>
                                    <select class="form-control select2" name="id_vendedor" style="width: 100%;" required="">
                                        <?php if (!empty($vendedores)) : ?>
                                            <?php foreach ($vendedores as $vendedor) : ?>
                                                <option value="<?= $vendedor['id_vendedor'] ?>"><?= $vendedor['nome'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Caixa</label>
                                    <select class="form-control select2" name="id_caixa" style="width: 100%;" required="">
                                        <?php if (!empty($caixas)) : ?>
                                            <?php foreach ($caixas as $caixa) : ?>
                                                <option value="<?= $caixa['id_caixa'] ?>">Data Abert.: <?= date('d/m/Y', strtotime($caixa['data_de_abertura'])) ?> - Hora Abert.: <?= $caixa['hora_de_abertura'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <?= (empty($caixas)) ? "<p style='color: orange; text-align: right; font-size: 11px; font-weight: bold'>Abra um caixa para continuar!</p>" : "" ?>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select class="form-control select2" name="tipo" style="width: 100%;" required="">
                                        <option value="Venda" selected>Venda</option>
                                        <option value="Orçamento">Orçamento</option>
                                        <option value="Pedido">Pedido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Data</label>
                                    <input type="date" class="form-control" name="data" value="<?= date('Y-m-d') ?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Hora</label>
                                    <input type="time" class="form-control" name="hora" value="<?= date('H:i:s') ?>" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="usar_credito_na_loja" onclick="usarCreditoNaLoja()">
                                        <label class="custom-control-label" for="customSwitch1">Usar crédito na loja</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2" name="venda_no_crediario">
                                        <label class="custom-control-label" for="customSwitch2">Venda no Crediário</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: right">
                                <button type="button" class="btn btn-warning" onclick="confirmaAcaoCancelarVenda()" <?= (empty($valor_da_venda['valor_final']) || empty($formas_de_pagamento_da_venda_rapida)) ? "disabled" : "" ?>>Cancelar Venda</button>
                                <button type="button" class="btn btn-primary" onclick="verificaSeClienteTemCredito()" <?= (empty($valor_da_venda['valor_final']) || empty($caixas) || empty($formas_de_pagamento_da_venda_rapida) || $somatorio_formas_de_pagamento < $valor_da_venda['valor_final']) ? "disabled" : "" ?>>Finalizar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </form>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function adicionaFormaDePagamento() {
        var forma_de_pagamento, valor;

        id_forma = document.getElementById('id_forma').value;
        valor = document.getElementById('valor').value;

        if (valor == "" || valor <= 0) {
            alert('O Valor da forma de pagamento é inválido, favor digite um valor valido!');
        } else {
            // Emite NFCe com CPF na nota
            $.post(
                "/VendaRapida/createFormaDePagamento", {
                    'id_forma': id_forma,
                    'valor': valor
                },

                function(data, status) {
                    if (status == "success") {
                        if (data == 1) {
                            window.location.reload();
                        }
                    }
                }
            );
        }
    }

    function verificaSeClienteTemCredito() {
        var botao_usar_credito_na_loja, id_cliente;

        botao_usar_credito_na_loja = document.getElementById('customSwitch1').checked; // checked retorna TRUE ou FALSE

        if (botao_usar_credito_na_loja) // Caso seja TRUE então faz a verificação se tem crédito na loja
        {
            id_cliente = document.getElementById('id_cliente').value;

            $.get(
                "/VendaRapida/verificaSeClienteTemCredito", {
                    'id_cliente': id_cliente,
                    'valor_da_venda': '<?= $valor_da_venda['valor_final'] ?>',
                },

                function(data, status) {
                    if (status == "success") {
                        if (data == 1) {
                            document.getElementById('form_finalizar_venda').submit();
                        } else {
                            alert('O cliente selecionado não possui créditos na loja suficiente para realizar a compra. Favor, adicione mais crédito na loja.');
                        }
                    }
                }
            );
        } else // Não faz a verificação, pois não foi marcado que será debitado do credito na loja
        {
            document.getElementById('form_finalizar_venda').submit();
        }
    }

    function usarCreditoNaLoja() {
        var botao_usar_credito_na_loja = document.getElementById('customSwitch1').checked;

        if (botao_usar_credito_na_loja) {
            alert('Não esqueça de selecionar o Cliente!');
        }
    }

    function confirmaAcaoCancelarVenda() {
        if (confirm("Deseja realmente cancelar essa venda?")) {
            window.location.href = "<?= base_url('vendaRapida/cancelaVenda') ?>";
        }
    }
</script>