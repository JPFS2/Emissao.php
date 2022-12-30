<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="/ordemDeServico/storeEquipamento" method="post">
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
                                    <input type="text" class="form-control" name="equipamento" value="<?= (isset($equipamento)) ? $equipamento['equipamento'] : "" ?>" required="">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Marca</label>
                                    <input type="text" class="form-control" name="marca" value="<?= (isset($equipamento)) ? $equipamento['marca'] : "" ?>">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Modelo</label>
                                    <input type="text" class="form-control" name="modelo" value="<?= (isset($equipamento)) ? $equipamento['modelo'] : "" ?>">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Série</label>
                                    <input type="text" class="form-control" name="serie" value="<?= (isset($equipamento)) ? $equipamento['serie'] : "" ?>">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Defeitos</label>
                                    <textarea class="form-control" name="defeitos" rows="5" required><?= (isset($equipamento)) ? $equipamento['defeitos'] : "" ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Condições</label>
                                    <textarea class="form-control" name="condicoes" rows="5"><?= (isset($equipamento)) ? $equipamento['condicoes'] : "" ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Acessórios</label>
                                    <textarea class="form-control" name="acessorios" rows="5"><?= (isset($equipamento)) ? $equipamento['acessorios'] : "" ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Solução</label>
                                    <textarea class="form-control" name="solucao" rows="5" required><?= (isset($equipamento)) ? $equipamento['solucao'] : "" ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Laudo Técnico</label>
                                    <textarea class="form-control" name="laudo_tecnico" rows="5"><?= (isset($equipamento)) ? $equipamento['laudo_tecnico'] : "" ?></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Termos de garantia</label>
                                    <textarea class="form-control" name="termos_de_garantia" rows="5"><?= (isset($equipamento)) ? $equipamento['termos_de_garantia'] : "" ?></textarea>
                                </div>
                            </div>

                            <?php if(isset($equipamento)): ?>
                                <!-- HIDDEN -->
                                <input type="hidden" name="id_equipamento" value="<?= $equipamento['id_equipamento'] ?>">
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: right">
                                <button type="submit" class="btn btn-primary"><?= (isset($equipamento)) ? "Atualizar" : "Cadastrar" ?></button>
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