<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="pt_BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>NxGestão</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/fontawesome-free/css/all.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css') ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/select2/css/select2.css') ?>">
    <link rel="stylesheet" href="<?= base_url('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.css') ?>">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/icheck-bootstrap/icheck-bootstrap.css') ?>">
    <!-- pace-progress -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/pace-progress/themes/purple/pace-theme-flat-top.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('theme/dist/css/adminlte.css') ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
    <!-- Style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- ========= Scripts com prioridade ============= -->
    <!-- jQuery -->
    <script src="<?= base_url('theme/plugins/jquery/jquery.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('theme/plugins/sweetalert2/sweetalert2.js') ?>"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="<?= base_url('theme/plugins/chart.js/Chart.min.js') ?>"></script>

    <!-- ========= IMPRESSÃO ========== -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/print.css') ?>" media="print" />
</head>

<body class="hold-transition" style="background: #F4F6F9">

    <div class="container" style="margin-top: 60px">

        <form id="form" action="/cadastroDeAutorizacaoDemo/index/<?= date('Ymd') ?>" method="post">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                               <label for="">Data Início</label>
                               <input type="date" class="form-control" name="data_inicio" value="<?= (isset($data_inicio)) ? $data_inicio : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                               <label for="">Data Final</label>
                               <input type="date" class="form-control" name="data_final" value="<?= (isset($data_final)) ? $data_final : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                               <button type="submit" class="btn btn-success" style="margin-top: 30px">Pesquisar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </form>

        <form id="form" action="/cadastroDeAutorizacaoDemo/store" method="post">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="m-0 text-dark">Lista de cadastrados para acessar demo</h6>
                        </div><!-- /.col -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="table-responsive p-0">
                                    <table class="table table-hover text-nowrap table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Telefone</th>
                                                <th>Email</th>
                                                <th>UF</th>
                                                <th>Municipio</th>
                                                <th>Data de Cadastro</th>
                                                <th>Hora de Cadastro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($cadastros)): ?>
                                                <?php foreach($cadastros as $cadastro): ?>
                                                    <tr>
                                                        <td><?= $cadastro['nome'] ?></td>
                                                        <td><?= $cadastro['telefone'] ?></td>
                                                        <td><?= $cadastro['email'] ?></td>
                                                        <td><?= $cadastro['uf'] ?></td>
                                                        <td><?= $cadastro['municipio'] ?></td>
                                                        <td><?= $cadastro['data_de_cadastro'] ?></td>
                                                        <td><?= $cadastro['hora_de_cadastro'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8">Nenhum registro!</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </form>
    </div><!-- /.container-fluid -->

    <!-- Bootstrap 4 -->
    <script src="<?= base_url('theme/plugins/bootstrap/js/bootstrap.bundle.js') ?>"></script>
    <!-- Select2 -->
    <script src="<?= base_url('theme/plugins/select2/js/select2.full.js') ?>"></script>
    <!-- DataTables -->
    <script src="<?= base_url('theme/plugins/datatables/jquery.dataTables.js') ?>"></script>
    <script src="<?= base_url('theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js') ?>"></script>
    <!-- Bootstrap Switch -->
    <script src="<?= base_url('theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
    <!-- pace-progress -->
    <script src="<?= base_url('theme/plugins/pace-progress/pace.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('theme/dist/js/adminlte.js') ?>"></script>
    <!-- Scripts internos do sistema -->
    <script src="<?= base_url('assets/js/funcoes.js') ?>"></script>
    <!-- ViaCep -->
    <script src="<?= base_url('assets/js/viaCep.js') ?>"></script>
    <!-- Plugin Mascaras -->
    <script src="<?= base_url('assets/js/jquery.mask.js') ?>"></script>
    <!-- Scripts Mascaras -->
    <script src="<?= base_url('assets/js/mascaras.js') ?>"></script>
    <!-- Scripts validação CPF e CNPJ -->
    <script src="<?= base_url('assets/js/validador.js') ?>"></script>

    <script>

        $(function() {
            // -------------- ALERTAS ---------------- //
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });
            
            <?php
                $session = session();
                $alert = $session->getFlashdata('alert');

                if (isset($alert)) : ?>

                    

                    Toast.fire({
                        type: '<?= $alert['type'] ?>',
                        title: '<?= $alert['title']?>'
                    })
                    
                <?php endif;
            ?>

            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

    </script>
</body>

</html>