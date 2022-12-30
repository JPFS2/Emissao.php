<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <?php $session = session() ?>
                    <h1 class="m-0 text-dark">Seja bem vindo!</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Inicio</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                
                <?php if($controle_de_acesso['widget_clientes'] != 0): ?>
                    <div class="col-lg-2">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="far fa-user"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Clientes</span>
                                <span class="info-box-number"><?= $clientes ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endif; ?>

                <?php if($controle_de_acesso['widget_produtos'] != 0): ?>
                    <div class="col-lg-2">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-box-open"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Produtos</span>
                                <span class="info-box-number"><?= $produtos ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endif; ?>

                <?php if($controle_de_acesso['widget_vendas'] != 0): ?>
                    <div class="col-lg-2">
                        <div class="info-box" style="background: #F89C0E; color: white">
                            <span class="info-box-icon"><i class="fas fa-donate"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Vendas <?= date('m') ?>/<?= date('Y') ?></span>
                                <span class="info-box-number"><?= $quantidade_de_vendas_do_mes ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endif; ?>

                <?php if($controle_de_acesso['widget_lancamentos'] != 0): ?>
                    <div class="col-lg-2">
                        <div class="info-box" style="background: #B84CFB; color: white">
                            <span class="info-box-icon"><i class="fas fa-donate"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Lanç. <?= date('m') ?>/<?= date('Y') ?></span>
                                <span class="info-box-number"><?= $quantidade_de_lancamentos_do_mes ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endif; ?>

                <?php if($controle_de_acesso['widget_faturamento'] != 0): ?>
                    <div class="col-lg-2">
                        <div class="info-box bg-primary">
                            <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Fat. <?= date('m') ?>/<?= date('Y') ?></span>
                                <span class="info-box-number"><?= number_format($faturamento_do_mes, 2, ',', '.') ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endif; ?>

                <?php if($controle_de_acesso['widget_os'] != 0): ?>
                    <div class="col-lg-2">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-user-clock"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">O.S. <?= date('m') ?>/<?= date('Y') ?></span>
                                <span class="info-box-number"><?= $quantidade_de_os_do_mes ?></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                <?php endif; ?>

            </div>
            <div class="row">
                
                <?php if($controle_de_acesso['grafico_faturamento_linha'] != 0): ?>
                    <div class="col-lg-6">
                        <!-- AREA CHART -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Faturamento de <?= date('Y') ?></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="chartjs-1" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif; ?>

                <?php if($controle_de_acesso['grafico_faturamento_barras'] != 0): ?>
                    <div class="col-lg-6">
                        <!-- AREA CHART -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Faturamento de <?= date('Y') ?></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="chartjs-2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif; ?>
                
            </div>
            <div class="row">
                
                <?php if($controle_de_acesso['tabela_contas_a_pagar'] != 0): ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="background: #98FB98">
                                <h3 class="card-title">Contas a Receber <?= date('m') ?>/<?= date('Y') ?></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Nome</th>
                                            <th>Vencimento</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($contas_a_receber)): ?>
                                            <?php foreach($contas_a_receber as $conta): ?>
                                                <tr>
                                                    <td><?= $conta['status'] ?></td>
                                                    <td><?= $conta['nome'] ?></td>
                                                    <td><?= date('d/m/Y', strtotime($conta['data_de_vencimento'])) ?></td>
                                                    <td><?= number_format($conta['valor'], 2, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4">Nenhum registro!</td>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif; ?>

                <?php if($controle_de_acesso['tabela_contas_a_receber'] != 0): ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="background: #FFA07A">
                                <h3 class="card-title">Contas a Pagar <?= date('m') ?>/<?= date('Y') ?></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Nome</th>
                                            <th>Vencimento</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($contas_a_pagar)): ?>
                                            <?php foreach($contas_a_pagar as $conta): ?>
                                                <tr>
                                                    <td><?= $conta['status'] ?></td>
                                                    <td><?= $conta['nome'] ?></td>
                                                    <td><?= date('d/m/Y', strtotime($conta['data_de_vencimento'])) ?></td>
                                                    <td><?= number_format($conta['valor'], 2, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4">Nenhum registro!</td>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    <?php if($controle_de_acesso['grafico_faturamento_linha'] != 0): ?>
        new Chart(document.getElementById("chartjs-1"), {
            "type": "line",
            "data": {
                "labels": [
                    <?php foreach($nome_dos_meses as $nomes): ?>
                        "<?= $nomes ?>",
                    <?php endforeach; ?>
                ],
                "datasets": [{
                    "label": "Meses",
                    "data": [
                        <?php foreach($faturamento_por_mes as $faturamento): ?>
                            <?= $faturamento ?>,
                        <?php endforeach; ?>
                    ],
                    "fill": false,
                    "borderColor": "rgb(75, 192, 192)",
                    "lineTension": 0.1
                }]
            },
            "options": {}
        });
    <?php endif; ?>

    <?php if($controle_de_acesso['grafico_faturamento_barras'] != 0): ?>
        new Chart(document.getElementById("chartjs-2"), {
            "type": "bar",
            "data": {
                "labels": [
                    <?php foreach($nome_dos_meses as $nomes): ?>
                        "<?= $nomes ?>",
                    <?php endforeach; ?>
                ],
                "datasets": [{
                    "label": "Meses",
                    "data": [
                        <?php foreach($faturamento_por_mes as $faturamento): ?>
                            <?= $faturamento ?>,
                        <?php endforeach; ?>
                    ],
                    "fill": false,
                    "backgroundColor": ["#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2", "#DBF2F2"],
                    "borderColor": ["#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1", "#7AD1D1"],
                    "borderWidth": 1
                }]
            },
            "options": {
                "scales": {
                    "yAxes": [{
                        "ticks": {
                            "beginAtZero": true
                        }
                    }]
                }
            }
        });
    <?php endif; ?>

</script>