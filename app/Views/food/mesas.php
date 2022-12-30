<meta http-equiv="refresh" content="60">

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

            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php if (!empty($mesas)) : ?>
                            <?php foreach ($mesas as $mesa) : ?>
                                <div class="col-lg-4">
                                    <div class="card card-<?= ($mesa['status'] == "Aberta") ? "success" : "info" ?>">
                                        <div class="card-header" style="height: 47px">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h3 class="card-title"><?= $mesa['nome'] ?></h3>
                                                </div>
                                                <?php if ($mesa['status'] == "Ocupada") : ?>
                                                    <div class="col-lg-4">
                                                        <button type="button" class="btn btn-warning style-action" onclick="confirmaAcaoLiberarMesa(<?= $mesa['id_mesa'] ?>)">Liberar</button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- /.card-footer -->
                                        <div class="card-body">
                                            <!-- <p style="text-align: center"><span class="fas fa-edit" style="font-size: 70px"></span></p> -->
                                            <p style="text-align: center"><img src="<?= base_url('assets/img/') ?>/<?= ($mesa['status'] == "Aberta") ? "mesa.png" : "mesa-ocupada.png" ?>" style="width: 100px" /></p>
                                            <p>
                                                <b>Status:</b> <?= $mesa['status'] ?> <br>
                                                <?= ($mesa['novo_produto_adicionado'] == "SIM") ? "<b style='color:red'>Novo produto adicionado!</b>" : "<br>" ?>
                                            </p>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="/food/mesa/<?= $mesa['id_mesa'] ?>" class="btn btn-default btn-block <?= ($mesa['status'] == "Aberta") ? "disabled" : "" ?>">Acessar</a>
                                        </div>
                                        <!-- /.card-footer -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-lg-12">
                                <p>
                                    <b>Nenhuma mesa!</b> <br>
                                    Acesse as configurações do módulo food e cadastre as mesas.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <table class="table table-bordered" style="background: white">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center">NOVOS PRODUTOS ADICIONADOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produtos_novos)) : ?>
                                <?php foreach ($produtos_novos as $produto) : ?>
                                    <tr>
                                        <td><?= $produto['produto'] ?></td>
                                        <td><?= $produto['mesa'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">Nenhum registro!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    function confirmaAcaoLiberarMesa(id_mesa) {
        if (confirm("Deseja realmente liberar a mesa?")) {
            window.location.href = "/food/liberarMesa/" + id_mesa;
        }
    }
</script>