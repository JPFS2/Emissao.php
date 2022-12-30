<!-- Modal Altera Dados Fiscais -->
<div class="modal fade" id="modal-editar-dados-fiscais">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Dados Fiscais</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/NFeAvulsa/alteraDadosFiscaisDoProduto" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">NCM</label>
                                <input type="text" class="form-control" id="NCM" name="NCM" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">CFOP</label>
                                <input type="text" class="form-control" id="CFOP_NFe" name="CFOP_NFe" required>
                            </div>
                        </div>

                        <input type="hidden" id="id_produto_nfe_avulsa" name="id_produto_nfe_avulsa">
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
                    <form action="/NFeAvulsa/addProduto/1" method="post">
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
                                        <?php if (!empty($produtos_da_nfe)) : ?>
                                            <?php foreach ($produtos_da_nfe as $produto) : ?>
                                                <tr>
                                                    <td><?= $produto['id_produto_nfe_avulsa'] ?></td>
                                                    <td><?= $produto['nome'] ?></td>
                                                    <td><?= $produto['quantidade'] ?></td>
                                                    <td><?= $produto['valor_unitario'] ?></td>
                                                    <td><?= $produto['quantidade'] * $produto['valor_unitario'] ?></td>
                                                    <td><?= $produto['desconto'] ?></td>
                                                    <td><?= ($produto['quantidade'] * $produto['valor_unitario']) - $produto['desconto'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Produto?', '/NFeAvulsa/deleteProduto/<?= $produto['id_produto_nfe_avulsa'] ?>/1')"><i class="fas fa-trash"></i></button>
                                                        <button type="button" class="btn btn-warning style-action" onclick="alterarDadosFiscais(<?= $produto['id_produto_nfe_avulsa'] ?>, '<?= $produto['NCM'] ?>', '<?= $produto['CFOP_NFe'] ?>')" data-toggle="modal" data-target="#modal-editar-dados-fiscais"><i class="fas fa-edit"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">Nenhum registro!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <p style="color: red; font-size: 12px; text-align: right"><b>Atenção:</b> Mude o CFOP do produto para um CFOP de Entrada!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <form id="form-emitir-nota" action="/NFe/NFeAvulsaEntrada" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="m-0 text-dark"><i class="fas fa-check"></i> Dados Finais</h6>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Natureza da Operação</label>
                                    <input type="text" class="form-control" name="natureza_da_operacao" value="ENTRADA DE MERCADORIAS">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Data</label>
                                    <input type="date" class="form-control" name="data" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Hora</label>
                                    <input type="time" class="form-control" name="hora" value="<?= date('H:i') ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Forma de Pagamento</label>
                                    <select class="form-control select2" name="forma_de_pagamento" style="width: 100%">
                                        <option value="0" selected>À Vista</option>
                                        <option value="1">À Prazo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Tipo de Pagamento</label>
                                    <select class="form-control select2" name="tipo_de_pagamento" style="width: 100%">
                                        <option value="01" selected>Dinheiro</option>
                                        <option value="02">Cheque</option>
                                        <option value="03">Cartão de Crédito</option>
                                        <option value="04">Cartão de Débito</option>
                                        <option value="05">Crédito Loja</option>
                                        <option value="10">Vale Alimentação</option>
                                        <option value="11">Vale Refeição</option>
                                        <option value="12">Vale Presente</option>
                                        <option value="13">Vale Combustível</option>
                                        <option value="15">Boleto Bancário</option>
                                        <option value="90">Sem Pagamento</option>
                                        <option value="99">Outros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Inf. Complementares</label>
                                    <input type="text" class="form-control" name="informacoes_complementares">
                                    <p style="font-size: 10px">Não entra na NFCe.</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Inf. para o Fisco</label>
                                    <input type="text" class="form-control" name="infomacoes_para_fisco">
                                    <p style="font-size: 10px">Não entra na NFCe.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="offset-lg-8 col-lg-4" style="text-align: right">
                                <button class="btn btn-success" type="submit"><i class="fas fa-plus-circle"></i> Emitir NFe</button>
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
    function alterarDadosFiscais(id_produto_nfe_avulsa, NCM, CFOP_NFe)
    {
        document.getElementById('id_produto_nfe_avulsa').value = id_produto_nfe_avulsa;
        document.getElementById('NCM').value        = NCM;
        document.getElementById('CFOP_NFe').value   = CFOP_NFe;
    }
</script>