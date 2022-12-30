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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body no-print">
                            <form action="/controleFiscal/relatorioMonofasico" method="get">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Data Inicio</label>
                                            <input type="date" class="form-control" name="data_inicio" value="<?= isset($data_inicio) ? $data_inicio : "" ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Data Final</label>
                                            <input type="date" class="form-control" name="data_final" value="<?= isset($data_final) ? $data_final : "" ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="sutmit" class="btn btn-success" style="margin-top: 30px"><i class="fa fa-filter"></i> Gerar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Relatório</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><b>Total de Produtos:</b> </td>
                                        <td><?= $cont_produto ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Somatório: </b> </td>
                                        <td><?= number_format($somatorio, 2, ',', '.') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->