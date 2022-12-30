<!-- Modal Altera Quantidade -->
<div class="modal fade" id="modal-atualizar-dados-do-produto">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Atualizar dados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/vendas/atualizarProdutoDaVenda/<?= $id_venda ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Qtd</label>
                                <input type="text" class="form-control" id="quantidade" name="quantidade">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Valor Unitário</label>
                                <input type="text" class="form-control money" id="valor_unitario" name="valor_unitario">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Desconto</label>
                                <input type="text" class="form-control money" id="desconto" name="desconto">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">NCM</label>
                                <input type="text" class="form-control" id="NCM" name="NCM">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">CSOSN</label>
                                <input type="text" class="form-control" id="CSOSN" name="CSOSN">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">CFOP NFe</label>
                                <input type="text" class="form-control" id="CFOP_NFe" name="CFOP_NFe">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">CFOP NFCe</label>
                                <input type="text" class="form-control" id="CFOP_NFCe" name="CFOP_NFCe">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">CFOP Externo</label>
                                <input type="text" class="form-control" id="CFOP_Externo" name="CFOP_Externo">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">PIS/COFINS</label>
                                <input type="text" class="form-control" id="pis_cofins" name="pis_cofins">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Porc. ICMS</label>
                                <input type="text" class="form-control" id="porcentagem_icms" name="porcentagem_icms">
                            </div>
                        </div>

                        <input type="hidden" id="id_produto_da_venda" name="id_produto_da_venda">
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
                        <a href="/vendas/show/<?= $id_venda ?>" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
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
                    <form action="/vendas/addProdutoDaVenda/<?= $id_venda ?>" method="post">
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
                                        <?php if (!empty($produtos_da_venda)) : ?>
                                            <?php foreach ($produtos_da_venda as $produto) : ?>
                                                <tr>
                                                    <td><?= $produto['id_produto'] ?></td>
                                                    <td><?= $produto['nome'] ?></td>
                                                    <td>
                                                        <?= $produto['quantidade'] ?>
                                                    </td>
                                                    <td>
                                                        <?= number_format($produto['valor_unitario'], 2, ',', '.') ?>
                                                    </td>
                                                    <td><?= number_format(($produto['quantidade'] * $produto['valor_unitario']), 2, ',', '.') ?></td>
                                                    <td>
                                                        <?= number_format($produto['desconto'], 2, ',', '.') ?>
                                                    </td>
                                                    <td><?= number_format((($produto['quantidade'] * $produto['valor_unitario'])-$produto['desconto']), 2, ',', '.') ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning style-action" onclick="pegaDadosDoProdutoParaAtualizar('<?= $produto['nome'] ?>', <?= $produto['quantidade'] ?>, <?= $produto['valor_unitario'] ?>, <?= $produto['desconto'] ?>, '<?= $produto['NCM'] ?>', '<?= $produto['CSOSN'] ?>', '<?= $produto['CFOP_NFe'] ?>', '<?= $produto['CFOP_NFCe'] ?>', '<?= $produto['CFOP_Externo'] ?>', '<?= $produto['pis_cofins'] ?>', '<?= $produto['porcentagem_icms'] ?>', '<?= $produto['id_produto_da_venda'] ?>')" data-toggle="modal" data-target="#modal-atualizar-dados-do-produto"><i class="fas fa-edit"></i></button>
                                                        <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse produto da venda?', '/vendas/deleteProduto/<?= $produto['id_produto_da_venda'] ?>/<?= $id_venda ?>')"><i class="fas fa-trash"></i></button>
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
                                            <?php if (!empty($formas_de_pagamento_da_venda)) : ?>
                                                <?php foreach ($formas_de_pagamento_da_venda as $forma) : ?>
                                                    <tr>
                                                        <td><?= $forma['nome'] ?></td>
                                                        <td><?= number_format($forma['valor'], 2, ',', '.') ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir essa Forma de Pagamento?', '/vendas/deleteFormaDePagamentoDaVenda/<?= $forma['id_forma_de_pagamento'] ?>/<?= $id_venda ?>')"><i class="fas fa-trash"></i></button>
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

            <form action="/vendas/storeEditVenda/<?= $id_venda ?>" method="post">
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
                                                    <option value="<?= $cliente['id_cliente'] ?>" <?= ($cliente['id_cliente'] == $cliente_da_venda['id_cliente']) ? "selected" : "" ?>><?= $cliente['nome'] ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $cliente['id_cliente'] ?>" <?= ($cliente['id_cliente'] == $cliente_da_venda['id_cliente']) ? "selected" : "" ?>><?= $cliente['razao_social'] ?></option>
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
                                                <option value="<?= $vendedor['id_vendedor'] ?>" <?= ($vendedor['id_vendedor'] == $vendedor_da_venda['id_vendedor']) ? "selected" : "" ?>><?= $vendedor['nome'] ?></option>
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
                                                <option value="<?= $caixa['id_caixa'] ?>" <?= ($caixa['id_caixa'] == $caixa_da_venda['id_caixa']) ? "selected" : "" ?>>Data Abert.: <?= date('d/m/Y', strtotime($caixa['data_de_abertura'])) ?> - Hora Abert.: <?= $caixa['hora_de_abertura'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <?= (empty($caixas)) ? "<p style='color: orange; text-align: right; font-size: 11px; font-weight: bold'>Abra um caixa para continuar!</p>" : "" ?>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Data</label>
                                    <input type="date" class="form-control" name="data" value="<?= $venda['data'] ?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Hora</label>
                                    <input type="time" class="form-control" name="hora" value="<?= $venda['hora'] ?>" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: right">
                                <button type="submit" class="btn btn-primary" <?= (empty($valor_da_venda['valor_final']) || empty($caixas) || empty($formas_de_pagamento_da_venda) || $somatorio_formas_de_pagamento < $valor_da_venda['valor_final']) ? "disabled" : "" ?>>Atualizar</button>
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
                "/vendas/createFormaDePagamento", {
                    'id_forma': id_forma,
                    'valor': valor,
                    'id_venda': '<?= $id_venda ?>'
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

    function pegaDadosDoProdutoParaAtualizar(nome, quantidade, valor_unitario, desconto, NCM, CSOSN, CFOP_NFe, CFOP_NFCe, CFOP_Externo, pis_cofins, porcentagem_icms, id_produto_da_venda) {
        var nome, quantidade, valor_unitario, desconto, NCM, CSOSN, CFOP_NFe, CFOP_NFCe, CFOP_Externo, pis_cofins, porcentagem_icms, id_produto_da_venda;

        document.getElementById('nome').value = nome;
        document.getElementById('quantidade').value = quantidade;
        document.getElementById('valor_unitario').value = valor_unitario.toLocaleString('pt-br', {minimumFractionDigits: 2});;
        document.getElementById('desconto').value = desconto.toLocaleString('pt-br', {minimumFractionDigits: 2});;
        document.getElementById('NCM').value = NCM;
        document.getElementById('CSOSN').value = CSOSN;
        document.getElementById('CFOP_NFe').value = CFOP_NFe;
        document.getElementById('CFOP_NFCe').value = CFOP_NFCe;
        document.getElementById('CFOP_Externo').value = CFOP_Externo;
        document.getElementById('pis_cofins').value = pis_cofins;
        document.getElementById('porcentagem_icms').value = porcentagem_icms;
        document.getElementById('id_produto_da_venda').value = id_produto_da_venda;
    }
</script>