<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="/empresas/storeLinkAdicionalDaSidebar/<?= $id_empresa ?>" method="post">

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="m-0 text-dark"><i class="<?=$titulo['icone']?>"></i> <?=$titulo['modulo']?></h6>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <a href="/empresas/show/<?= $id_empresa ?>" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
                                    <?php foreach ($caminhos as $caminho): ?>
                                        <?php if (!$caminho['active']): ?>
                                            <li class="breadcrumb-item"><a href="<?=$caminho['rota']?>"><?=$caminho['titulo']?></a></li>
                                        <?php else: ?>
                                            <li class="breadcrumb-item active"><?=$caminho['titulo']?></li>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </ol>
                            </div><!-- /.col -->
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <?php if (isset($empresa)): ?>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select class="form-control select2" name="status" style="width: 100%">
                                            <?php if ($empresa['status'] == "Ativo"): ?>
                                                <option value="Ativo" selected>Ativo</option>
                                                <option value="Desativado">Desativado</option>
                                            <?php else: ?>
                                                <option value="Ativo">Ativo</option>
                                                <option value="Desativado" selected>Desativado</option>
                                            <?php endif;?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif;?>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="">Link</label>
                                    <input type="text" class="form-control" name="link" value="<?= (isset($link_da_sidebar)) ? $link_da_sidebar['link'] : "" ?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="">Descrição</label>
                                    <input type="text" class="form-control" name="descricao" value="<?= (isset($link_da_sidebar)) ? $link_da_sidebar['descricao'] : "" ?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Icone</label>
                                    <input type="text" class="form-control" name="icone" value="<?= (isset($link_da_sidebar)) ? $link_da_sidebar['icone'] : "fas fa-circle-notch" ?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Tipo</label>
                                    <select class="form-control select2" name="tipo" style="width: 100%">
                                        <?php if(isset($link_da_sidebar)): ?>
                                            <?php if($link_da_sidebar['tipo'] == 1): ?>
                                                <option value="1" selected>Normal</option>
                                                <option value="2">Nova Aba</option>
                                            <?php else: ?>
                                                <option value="1">Normal</option>
                                                <option value="2" selected>Nova Aba</option>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <option value="1">Normal</option>
                                            <option value="2">Nova Aba</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="id_empresa" value="<?= $id_empresa ?>">

                            <?php if(isset($link_da_sidebar)): ?>
                                <input type="hidden" name="id_link" value="<?= $link_da_sidebar['id_link'] ?>">
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: right">
                                <button type="submit" class="btn btn-primary"><?=(isset($empresa)) ? "Atualizar" : "Cadastrar"?></button>
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