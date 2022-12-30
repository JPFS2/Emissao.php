<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="/ordemDeServico/storePeca" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?></h6>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <a href="/ordemDeServico/gerar" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
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
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Peça/Produto</label>
                                    <input type="text" class="form-control" name="nome" value="<?= $servico['nome'] ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Detalhes</label>
                                    <input type="text" class="form-control" name="detalhes" value="<?= $servico['detalhes'] ?>" disabled>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Quantidade</label>
                                    <input type="text" class="form-control" name="quantidade" value="<?= $servico['quantidade'] ?>" disabled>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Valor</label>
                                    <input type="text" class="form-control money" name="valor" value="<?= number_format($servico['valor'], 2, ',', '.') ?>" disabled>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Desconto</label>
                                    <input type="text" class="form-control money" name="desconto" value="<?= number_format($servico['desconto'], 2, ',', '.') ?>" disabled>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Subtotal</label>
                                    <input type="text" class="form-control" name="subtotal" value="<?= number_format((($servico['quantidade'] * $servico['valor']) - $servico['desconto']), 2, ',', '.') ?>" disabled>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </form>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->