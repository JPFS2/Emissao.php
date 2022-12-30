<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
                                <label for="">Equipamento</label>
                                <input type="text" class="form-control" value="<?= $equipamento['equipamento'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Marca</label>
                                <input type="text" class="form-control" value="<?= $equipamento['marca'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Modelo</label>
                                <input type="text" class="form-control" value="<?= $equipamento['modelo'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">Série</label>
                                <input type="text" class="form-control" value="<?= $equipamento['serie'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Defeitos</label>
                                <textarea class="form-control" rows="5" disabled><?= $equipamento['defeitos'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Condições</label>
                                <textarea class="form-control" rows="5" disabled><?= $equipamento['condicoes'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Acessórios</label>
                                <textarea class="form-control" rows="5" disabled><?= $equipamento['acessorios'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Solução</label>
                                <textarea class="form-control" rows="5" disabled><?= $equipamento['solucao'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Laudo Técnico</label>
                                <textarea class="form-control" rows="5" disabled><?= $equipamento['laudo_tecnico'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Termos de garantia</label>
                                <textarea class="form-control" rows="5" disabled><?= $equipamento['termos_de_garantia'] ?></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->