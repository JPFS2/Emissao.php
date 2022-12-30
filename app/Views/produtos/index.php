<!-- Modal SELECIONA XML -->
<div class="modal fade" id="modal-seleciona-xml">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecione o XML</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/produtos/add_por_xml" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Selecione o XML</label>
                                <div class="input-group">
                                    <input type="file" name="xml" required="">
                                </div>
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

<!-- Modal SELECIONA CSV -->
<div class="modal fade" id="modal-seleciona-csv">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Importar tabela CSV</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/produtos/add_por_csv" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Selecionar</label>
                                <div class="input-group">
                                    <input type="file" name="csv" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="text-align: center">
                            <a href="<?= base_url('assets/outros/planilha.csv') ?>" class="btn btn-info style-action"><i class="fas fa-download"></i> Baixar tabela modelo</a>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px">
                        <div class="col-lg-12">
                            <p>
                                <b>Obs:</b> Não esqueça de excluir a primeira linha (NOME DAS COLUNAS) da tabela modelo.
                            </p>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/produtos/create" class="btn btn-info"><i class="fa fa-plus-circle"></i> Novo Produto</a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-seleciona-xml"><i class="fa fa-plus-circle"></i> Cadastro por XML</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-seleciona-csv"><i class="fa fa-plus-circle"></i> Importar Tabela CSV</button>
                        </div>
                    </div>

                    <form action="produtos">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Cód.</label>
                                    <input type="text" class="form-control" id="id_produto" name="id_produto" onclick="limpaCampos()" value="<?= (isset($id_produto)) ? $id_produto : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" onclick="limpaCampos()" value="<?= (isset($nome)) ? $nome : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Código de Barras</label>
                                    <input type="text" class="form-control" id="codigo_de_barras" name="codigo_de_barras" onclick="limpaCampos()" value="<?= (isset($codigo_de_barras)) ? $codigo_de_barras : "" ?>">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" style="margin-top: 30px">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.card-header -->
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table id="" class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 35px">Cód.</th>
                                <th>Nome</th>
                                <th style="width: 180px">Valor de Venda</th>
                                <th style="width: 60px">Estoque</th>
                                <th style="width: 110px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produtos)) : ?>
                                <?php foreach ($produtos as $produto) : ?>
                                    <tr>
                                        <td><?= $produto['id_produto'] ?></td>
                                        <td><?= $produto['nome'] ?></td>
                                        <td><?= number_format($produto['valor_de_venda'], 2, ',', '.') ?></td>
                                        <td><?= ($produto['controlar_estoque'] == 1) ? $produto['quantidade'] : "N/C" ?></td>
                                        <td>
                                            <a href="/produtos/show/<?= $produto['id_produto'] ?>" class="btn btn-info style-action"><i class="fa fa-folder-open"></i></a>
                                            <a href="/produtos/edit/<?= $produto['id_produto'] ?>" class="btn btn-warning style-action"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Produto?', '/produtos/delete/<?= $produto['id_produto'] ?>')"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6">Nenhum registro encontrado!</td>
                                </tr>
                            <?php endif ?>
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
    function limpaCampos() {
        document.getElementById('id_produto').value = "";
        document.getElementById('nome').value = "";
        document.getElementById('codigo_de_barras').value = "";
    }
</script>