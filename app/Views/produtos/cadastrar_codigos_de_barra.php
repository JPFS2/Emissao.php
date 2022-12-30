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
                        <a href="/produtos/edit/<?= $id_produto ?>" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
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

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <form action="/produtos/storeCadastraCodigoDeBarras/<?= $id_produto ?>" method="post">
                                <div class="row" style="margin-top: 15px">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Código de barra</label>
                                            <input type="text" class="form-control" name="codigo_de_barra" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 30px">Cadastrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="" class="table table-hover text-nowrap table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Código de barra</th>
                                                <th style="width: 60px">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($codigos_de_barras)) : ?>
                                                <?php foreach ($codigos_de_barras as $codigo) : ?>
                                                    <tr>
                                                        <td><?= $codigo['codigo_de_barra'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Código de Barra?', '/produtos/deleteCodigoDeBarra/<?= $id_produto ?>/<?= $codigo['id_codigo'] ?>')"><i class="fas fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6">Nenhum registro!</td>
                                                </tr>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-footer" style="text-align: right">
                            <a href="/produtos/show/<?= $id_produto ?>" class="btn btn-success">Finalizar</a>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
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