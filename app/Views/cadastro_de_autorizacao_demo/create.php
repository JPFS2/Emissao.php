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

    <title><?= $configuracao['nome_do_app'] ?></title>

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
        <form id="form" action="/cadastroDeAutorizacaoDemo/store" method="post">
            <a href="/CadastroDeAutorizacaoDemo/index/<?= date('Ymd') ?>" class="btn btn-info">LISTAR CADASTROS</a>

            <div class="card" style="margin-top: 25px">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="m-0 text-dark">CADASTRO DE AUTORIZAÇÃO PARA ACESSAR DEMO</h6>
                        </div><!-- /.col -->
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Nome</label>
                                <input type="text" class="form-control" name="nome" required="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Telefone</label>
                                <input type="text" class="form-control" name="telefone" placeholder="ddd + numero" required="">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email" required="">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="">UF</label>
                                <select class="form-control select2" id="id_uf" name="id_uf" onchange="selecionaUF('id_uf')" style="width: 100%" required>
                                    <?php if(isset($cliente)) :?>
                                        <?php foreach($ufs as $uf) : ?>
                                            <option value="<?= $uf['id_uf'] ?>" <?= ($cliente['id_uf'] == $uf['id_uf']) ? "selected" : "" ?>><?= $uf['uf'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="" selected>Selecione</option>
                                        <?php foreach($ufs as $uf) : ?>
                                            <option value="<?= $uf['id_uf'] ?>"><?= $uf['uf'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Municipio</label>
                                <select class="form-control select2" id="id_municipio" name="id_municipio" style="width: 100%" required>
                                    <?php if(isset($cliente)): ?>
                                        <?php foreach($municipios as $municipio) : ?>
                                            <option value="<?= $municipio['id_municipio'] ?>" <?= ($cliente['id_municipio'] == $municipio['id_municipio']) ? "selected" : "" ?>><?= $municipio['municipio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <!-- MUNICIPIOS AJAX -->
                                        <option value="">Selecione a UF para carregas os municipios</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">CADASTRAR</button>
                </div>
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
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
</body>

</html>