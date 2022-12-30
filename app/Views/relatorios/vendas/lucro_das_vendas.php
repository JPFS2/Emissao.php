<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card no-print">
                <div class="card-body">
                    <form action="/relatorios/lucroDasVendas" method="post">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Data Inicio</label>
                                    <input type="date" class="form-control" name="data_inicio" value="<?= $data_inicio ?>">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Data Final</label>
                                    <input type="date" class="form-control" name="data_final" value="<?= $data_final ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-success" style="margin-top: 30px">Gerar Relatório</button>
                                <button type="button" class="btn btn-info" onclick="print()" style="margin-top: 30px"><i class="fas fa-print"></i> Imprimir / Salvar PDF</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row" style="margin-top: 30px">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p style="text-align: center"><b><?= $empresa['xNome'] ?></b></p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <p>
                                        <b>CNPJ:</b> <span class="cnpj"><?= $empresa['CNPJ'] ?></span> <br>
                                        <b>CONTATO:</b> <span class="celular"><?= $empresa['fone'] ?></span> <br>
                                        <b>ENDEREÇO:</b> <?= $empresa['xLgr'] ?>, <?= $empresa['nro'] ?>, <?= $empresa['xCpl'] ?>, <?= $empresa['xBairro'] ?>.
                                    </p>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 30px">
                                <div class="col-lg-12">
                                    <h6 class="m-0 text-dark" style="text-align: center"><b><?= $titulo['modulo'] ?></b></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body table-responsive p-0">
                                        <table class="table table-hover text-nowrap table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <td>Total de Vendas: <?= $total_de_vendas ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total de produtos vendidos: <?= $total_de_produtos_vendidos ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Lucro Total: <?= number_format($lucro_total, 2, ',', '.') ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p>Relatório gerado em: <?= date('d/m/Y') ?> às <?= date('H:i') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->