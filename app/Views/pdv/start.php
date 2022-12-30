<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Nx Gestão</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/fontawesome-free/css/all.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/select2/css/select2.css') ?>">
    <link rel="stylesheet" href="<?= base_url('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('theme/dist/css/adminlte.css') ?>">
    <!-- Style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- ========= Scripts com prioridade ============= -->
    <!-- jQuery -->
    <script src="<?= base_url('theme/plugins/jquery/jquery.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('theme/plugins/sweetalert2/sweetalert2.js') ?>"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="<?= base_url('theme/plugins/chart.js/Chart.min.js') ?>"></script>
</head>

<body style="background: lightgrey">
    <!-- Modal Procura Produto por Nome -->
    <div class="modal fade" id="procurar-produto-por-nome">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Procurar Produto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Nome</label>
                                <input type="text" class="form-control" id="nome_do_produto_pesquisar">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" style="margin-top: 32px" onclick="pesquisarProdutoPorNome()"><i class="fas fa-search"></i> Pesquisar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cód.:</th>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th>Estoque</th>
                                        <th style="width: 90px">Qtd.</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="lista-de-produtos-procurados">
                                    <!-- CONTEUDO -->
                                    <tr>
                                        <td colspan="6">Digite o nome do produto para continuar..</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
                <form action="/pdv/alteraQtdDoProduto/<?= $id_caixa ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Nova QTD</label>
                                    <input type="text" class="form-control" id="altera_qtd_do_produto_quantidade" name="quantidade" onkeyup="trocaVirguraPorPonto('altera_qtd_do_produto_quantidade')">
                                    <input type="hidden" class="form-control" id="altera_qtd_do_produto_id_pdv_produto" name="id_produto_pdv" onkeyup="trocaVirguraPorPonto('altera_qtd_do_produto_id_pdv_produto')">
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
                <form action="/pdv/alteraValorUnitarioDoProduto/<?= $id_caixa ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Valor Unitário</label>
                                    <input type="text" class="form-control money" id="altera_valor_unitario_do_produto_valor_unitario" name="valor_unitario">
                                    <input type="hidden" class="form-control" id="altera_valor_unitario_do_produto_id_pdv_produto" name="id_produto_pdv">
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
                <form action="/pdv/alteraDescontoDoProduto/<?= $id_caixa ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Desconto</label>
                                    <input type="text" class="form-control money" id="altera_desconto_do_produto_valor_unitario" name="desconto">
                                    <input type="hidden" class="form-control" id="altera_desconto_do_produto_id_pdv_produto" name="id_produto_pdv">
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

    <!-- Modal Finalizar Venda -->
    <div class="modal fade" id="finalizar-venda">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Finalizar Venda</span></b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Valor da Venda</label>
                                <input type="text" class="form-control" value="<?= number_format($valor_a_pagar['valor_final'], 2, ',', '.') ?>" style="height: 70px; font-size: 50px; text-align: center" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Valor Recebido</label>
                                <input type="text" class="form-control" value="<?= number_format($somatorio_formas_de_pagamento, 2, ',', '.') ?>" style="height: 70px; font-size: 50px; text-align: center" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Restante</label>
                                <input type="text" class="form-control" value="<?= number_format($restante, 2, ',', '.') ?>" style="height: 70px; font-size: 50px; text-align: center" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Troco</label>
                                <input type="text" class="form-control" value="<?= number_format($troco, 2, ',', '.') ?>" style="height: 70px; font-size: 50px; text-align: center" disabled>
                            </div>
                        </div>
                    </div>
                    <form action="/pdv/adicionarDescontoGeral/<?= $id_caixa ?>" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="text-align: center; background: #007BFF; color: white">FORMAS DE PAGAMENTO</th>
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
                                                <input type="text" class="form-control money" id="valor_da_forma_de_pagamento" value="<?= number_format($restante, 2, ',', '.') ?>" required>
                                            </th>
                                            <th width=70>
                                                <button type="button" class="btn btn-success" onclick="adicionaFormaDePagamento()"><i class="fas fa-plus-circle"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($formas_de_pagamento_do_pdv)) : ?>
                                            <?php foreach ($formas_de_pagamento_do_pdv as $forma) : ?>
                                                <tr>
                                                    <td><?= $forma['nome'] ?></td>
                                                    <td><?= number_format($forma['valor'], 2, ',', '.') ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir essa Forma de Pagamento?', '/pdv/deleteFormaDePagamentoDaVendaRapida/<?= $forma['id_forma_de_pagamento'] ?>/<?= $id_caixa ?>')"><i class="fas fa-trash"></i></button>
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
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Desconto Geral</label>
                                    <input type="text" class="form-control money" name="desconto_geral" value="<?= number_format($desconto_geral, 2, ',', '.') ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" style="margin-top: 32px"><i class="fas fa-plus-circle"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Vendedor</label>
                                <select class="form-control select2" id="id_vendedor" style="width: 100%;">
                                    <?php foreach ($vendedores as $vendedor) : ?>
                                        <option value="<?= $vendedor['id_vendedor'] ?>"><?= $vendedor['nome'] ?></option>]
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Cliente</label>
                                <select class="form-control select2" id="id_cliente" style="width: 100%;">
                                    <?php foreach ($clientes as $cliente) : ?>
                                        <?php if ($cliente['tipo'] == 1) : ?>
                                            <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nome'] ?></option>]
                                        <?php else : ?>
                                            <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['razao_social'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
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
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar (F5)</button>
                    <button type="button" class="btn btn-primary" onclick="finalizaVenda()" <?= ($somatorio_formas_de_pagamento == 0 || $somatorio_formas_de_pagamento < $valor_a_pagar['valor_final']) ? "disabled" : "" ?>>Finalizar (F10)</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal LOADING -->
    <div class="modal fade no-print" id="modal-loading">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="<?= base_url('assets/img/loading.gif') ?>" alt="Aguarde carregando.." style="width: 100%">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal CUPOM NÃO FISCAL -->
    <div class="modal fade" id="modal-cupom-nao-fiscal">
        <div class="modal-dialog modal-md" style="width: 300px">
            <!-- 300px = 80mm -->
            <div class="modal-content">
                <div class="modal-header no-print">
                    <h4 class="modal-title">Cupom não fiscal <button type="button" class="btn btn-success style-action" onclick="print()"><i class="fas fa-print"></i></button></h4>
                    <button type="button" class="close" onclick="location.reload()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="cupom-nao-fiscal"></div>
                </div>
                <div class="modal-footer justify-content-between no-print">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload()">Fechar (F5)</button>
                    <button type="button" class="btn btn-success" onclick="print()"><i class="fas fa-print"></i> Imprimir Cupom</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="container-fluid no-print" style="margin-top: 15px">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Pesq. produto</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="/pdv/adicionaProdutoPorCodigoDeBarras/<?= $id_caixa ?>" method="post">
                                    <div class="form-group">
                                        <label for="">Cód. Produto / Cód. barras</label>
                                        <input type="text" class="form-control" name="codigo_de_barras" autofocus="" <?= (empty($produtos)) ? "disabled" : "" ?>>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-info style-action" data-toggle="modal" data-target="#procurar-produto-por-nome"><i class="fas fa-search"></i> Pesquisar Produto (F8)</button>
                            </div>
                            <div class="col-lg-12" style="margin-top: 10px">
                                <div class="form-group">
                                    <label for="">Valor à Pagar</label>
                                    <input type="text" class="form-control" style="height: 65px; text-align: center; font-size: 50px" value="<?= (!empty($valor_a_pagar['valor_final'])) ? number_format($valor_a_pagar['valor_final'], 2, ',', '.') : "R$ 0,00" ?>" disabled="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#finalizar-venda" <?= (!empty($valor_a_pagar['valor_final'])) ? "" : "disabled" ?>>Finalizar Venda (F6)</button>
                        <button type="button" class="btn btn-warning" onclick="cancelarVenda()" <?= (!empty($valor_a_pagar['valor_final'])) ? "" : "disabled" ?>>Cancelar Venda (F9)</button>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-lg-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Produtos</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cód.</th>
                                            <th>Nome</th>
                                            <th>Qtd</th>
                                            <th>Valor Unit.</th>
                                            <th>Subtotal</th>
                                            <th>Desconto</th>
                                            <th>Valor Final</th>
                                            <th style="width: 10px; text-align: center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($produtos_do_pdv)) : ?>
                                            <?php foreach ($produtos_do_pdv as $produto) : ?>
                                                <tr>
                                                    <td><?= $produto['id_produto'] ?></td>
                                                    <td><?= $produto['nome'] ?></td>
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#alterar-qtd-do-produto" onclick="preparaParaAlterarQtdDoProduto(<?= $produto['id_produto_pdv'] ?>, <?= $produto['quantidade'] ?>)">
                                                            <?= $produto['quantidade'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#alterar-valor-unitario-do-produto" onclick="preparaParaAlterarValoUnitarioDoProduto(<?= $produto['id_produto_pdv'] ?>, <?= $produto['valor_unitario'] ?>)">
                                                            <?= number_format($produto['valor_unitario'], 2, ',', '.') ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?= number_format($produto['subtotal'], 2, ',', '.') ?>
                                                    </td>
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#alterar-desconto-do-produto" onclick="preparaParaAlterarDescontoDoProduto(<?= $produto['id_produto_pdv'] ?>, <?= $produto['desconto'] ?>)">
                                                            <?= number_format($produto['desconto'], 2, ',', '.') ?>
                                                        </a>
                                                    </td>
                                                    <td><?= number_format($produto['valor_final'], 2, ',', '.') ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse produto da venda?', '/pdv/removeProdutoDoPdv/<?= $id_caixa ?>/<?= $produto['id_produto_pdv'] ?>')"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="8">Nenhum produto!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- <div class="card-footer">
                        Qtd de produtos: 10, Valor final: 110,65.
                    </div> -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

    <input type="hidden" id="aux_id_venda">

    <!-- REQUIRED SCRIPTS -->
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('theme/plugins/bootstrap/js/bootstrap.bundle.js') ?>"></script>
    <!-- Select2 -->
    <script src="<?= base_url('theme/plugins/select2/js/select2.full.js') ?>"></script>
    <!-- DataTables -->
    <script src="<?= base_url('theme/plugins/datatables/jquery.dataTables.js') ?>"></script>
    <script src="<?= base_url('theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('theme/dist/js/adminlte.js') ?>"></script>
    <!-- Plugin Mascaras -->
    <script src="<?= base_url('assets/js/jquery.mask.js') ?>"></script>
    <!-- Scripts Mascaras -->
    <script src="<?= base_url('assets/js/mascaras.js') ?>"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
            $('.select2-1').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        function usarCreditoNaLoja() {
            var botao_usar_credito_na_loja = document.getElementById('customSwitch1').checked;

            if (botao_usar_credito_na_loja) {
                alert('Não esqueça de selecionar o Cliente!');
            }
        }

        function confirmaAcaoExcluir(msg, rota) {
            if (confirm(msg)) {
                window.location.href = rota;
            }
        }

        function adicionaProdutoPorNome() {
            var id_produto = document.getElementById('pesq_de_produto_por_nome').value;
            window.location.href = "/pdv/adicionaProdutoPorNome/<?= $id_caixa ?>/" + id_produto;
        }

        function preparaParaAlterarQtdDoProduto(id_produto_pdv, quantidade) {
            document.getElementById('altera_qtd_do_produto_quantidade').value = quantidade;
            document.getElementById('altera_qtd_do_produto_id_pdv_produto').value = id_produto_pdv;
        }

        function preparaParaAlterarValoUnitarioDoProduto(id_produto_pdv, valor_unitario) {
            document.getElementById('altera_valor_unitario_do_produto_valor_unitario').value = valor_unitario.toLocaleString('pt-br', {
                minimumFractionDigits: 2
            });;
            document.getElementById('altera_valor_unitario_do_produto_id_pdv_produto').value = id_produto_pdv;
        }

        function preparaParaAlterarDescontoDoProduto(id_produto_pdv, desconto) {
            document.getElementById('altera_desconto_do_produto_valor_unitario').value = desconto.toLocaleString('pt-br', {
                minimumFractionDigits: 2
            });;
            document.getElementById('altera_desconto_do_produto_id_pdv_produto').value = id_produto_pdv;
        }

        function finalizaVenda() {
            var valor_a_pagar, valor_recebido, troco, id_cliente, id_vendedor;

            var botao_usar_credito_na_loja = document.getElementById('customSwitch1').checked; // checked retorna TRUE ou FALSE

            if (botao_usar_credito_na_loja) {
                botao_usar_credito_na_loja = 1;
            } else {
                botao_usar_credito_na_loja = 0;
            }

            valor_a_pagar = <?= (!empty($valor_a_pagar['valor_final'])) ? $valor_a_pagar['valor_final'] : "0" ?>;
            valor_recebido = <?= $somatorio_formas_de_pagamento ?>;
            troco = <?= $troco ?>;
            id_cliente = document.getElementById('id_cliente').value;
            id_vendedor = document.getElementById('id_vendedor').value;

            // ---------------------- ---------------------------------------- --------------------------------- //
            if (botao_usar_credito_na_loja) // Caso seja TRUE então faz a verificação se tem crédito na loja
            {
                id_cliente = document.getElementById('id_cliente').value;

                $.get(
                    "/VendaRapida/verificaSeClienteTemCredito", {
                        'id_cliente': id_cliente,
                        'valor_da_venda': valor_a_pagar,
                    },

                    function(data, status) {
                        if (status == "success") {
                            if (data == 1) {
                                $('#finalizar-venda').modal('hide');
                                $('#modal-loading').modal('show');

                                $.post(
                                    "/pdv/finalizaVenda/<?= $id_caixa ?>", {
                                        valor_a_pagar: valor_a_pagar,
                                        valor_recebido: valor_recebido,
                                        troco: troco,
                                        id_vendedor: id_vendedor,
                                        id_cliente: id_cliente,
                                        botao_usar_credito_na_loja: botao_usar_credito_na_loja
                                    },

                                    function(data, status) {
                                        if (status == "success") {
                                            // Adiciona data (cupom não fiscal) no modal e exibe ele
                                            document.getElementById('cupom-nao-fiscal').innerHTML = data;
                                            $('#modal-cupom-nao-fiscal').modal('show');
                                        }
                                    }
                                );
                            } else {
                                alert('O cliente selecionado não possui créditos na loja suficiente para realizar a compra. Favor, adicione mais crédito na loja.');
                            }
                        }
                    }
                );
            } else // Não faz a verificação, pois não foi marcado que será debitado do credito na loja
            {
                $('#finalizar-venda').modal('hide');
                $('#modal-loading').modal('show');

                $.post(
                    "/pdv/finalizaVenda/<?= $id_caixa ?>", {
                        valor_a_pagar: valor_a_pagar,
                        valor_recebido: valor_recebido,
                        troco: troco,
                        id_vendedor: id_vendedor,
                        id_cliente: id_cliente,
                        botao_usar_credito_na_loja: botao_usar_credito_na_loja
                    },

                    function(data, status) {
                        if (status == "success") {
                            // Adiciona data (cupom não fiscal) no modal e exibe ele
                            document.getElementById('cupom-nao-fiscal').innerHTML = data;
                            $('#modal-cupom-nao-fiscal').modal('show');
                        }
                    }
                );
            }
        }
    </script>

    <script>
        $(function() {
            // -------------- ALERTAS ---------------- //
            <?php
            $session = session();
            $alert = $session->getFlashdata('alert');

            if (isset($alert)) : ?>

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                });

                Toast.fire({
                    type: '<?= $alert['type'] ?>',
                    title: '<?= $alert['title'] ?>'
                })

                // Somente para o PDV
                <?php if (isset($alert['abrir_modal_finalizar_venda'])) : ?>
                    $('#finalizar-venda').modal('show');
                <?php endif; ?>

            <?php endif;
            ?>
        });

        function adicionaFormaDePagamento() {
            var forma_de_pagamento, valor;

            id_forma = document.getElementById('id_forma').value;
            valor = document.getElementById('valor_da_forma_de_pagamento').value;

            if (valor == "" || valor <= 0) {
                alert('O Valor da forma de pagamento é inválido, favor digite um valor valido!');
            } else {
                $.post(
                    "/Pdv/createFormaDePagamento", {
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

        function pesquisarProdutoPorNome() {
            var nome_do_produto = document.getElementById('nome_do_produto_pesquisar').value;

            if (nome_do_produto != "") {
                $.get(
                    "/Pdv/listaProdutosPesquisadosPorNome", {
                        'nome_do_produto': nome_do_produto,
                        'id_caixa': <?= $id_caixa ?>
                    },

                    function(data, status) {
                        if (status == "success") {
                            $('#lista-de-produtos-procurados').html(data);
                        }
                    }
                );

                document.getElementById('nome_do_produto_pesquisar').className = "form-control";
            } else {
                document.getElementById('nome_do_produto_pesquisar').className = "form-control is-invalid";
            }
        }

        function cancelarVenda() {
            if (confirm('Deseja realmente cancelar a venda?')) {
                window.location.href = '/pdv/cancelarVenda/<?= $id_caixa ?>';
            }
        }

        function acionaFormAdicionarDescontoGeral() {
            document.getElementById("form_desconto_geral").submit();
        }

        function acionaFormPesquisaProdutoPorNome(id_form) {
            document.getElementById(id_form).submit();
        }

        $(document).keydown(function(e) {
            <?php if (!empty($valor_a_pagar['valor_final'])) : ?>
                // Abrir modal finalizar venda (F6)
                if (e.which == 117) {
                    $('#finalizar-venda').modal('show');
                }
            <?php endif; ?>

            // Abrir modal pesquisar produto por nome (F8)
            if (e.which == 119) {
                $('#procurar-produto-por-nome').modal('show');
            }

            <?php if (!empty($valor_a_pagar['valor_final']) && $somatorio_formas_de_pagamento > 0) : ?>
                // Finalizar venda (F10)
                if (e.which == 121) {
                    finalizaVenda();
                }
            <?php endif; ?>

            <?php if (!empty($valor_a_pagar['valor_final'])) : ?>
                // Cancelar Venda (F9)
                if (e.which == 120) {
                    cancelarVenda();
                }
            <?php endif; ?>
        });
    </script>
</body>

</html>