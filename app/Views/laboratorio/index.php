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

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/laboratorio/iniciarNovaOrdemDoLaboratorio" class="btn btn-info"><i class="fa fa-user-plus"></i> Gerar Ordem</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-body">
                    <table id="example1" class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 35px">Cód.</th>
                                <th>Cliente</th>
                                <th>Data de Entrada</th>
                                <th>Data Prevista</th>
                                <th>Valor</th>
                                <th>Paciente</th>
                                <th>Caixa</th>
                                <th class="no-print" style="width: 60px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ordens)) : ?>
                                <?php foreach ($ordens as $ordem) : ?>
                                    <tr>
                                        <td><?= $ordem['id_laboratorio'] ?></td>
                                        <td><?= ($ordem['tipo'] == 1) ? $ordem['nome'] : $ordem['razao_social'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($ordem['data_de_entrada'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($ordem['data_prevista'])) ?></td>
                                        <td><?= number_format($ordem['somatorio'], 2, ',', '.') ?></td>
                                        <td><?= $ordem['paciente'] ?></td>
                                        <td><?= $ordem['caixa'] ?></td>
                                        <td>
                                            <a href="/laboratorio/impressao/<?= $ordem['id_laboratorio'] ?>" target="_blank" class="btn btn-success style-action"><i class="fas fa-print"></i></a>
                                            <a href="/laboratorio/show/<?= $ordem['id_laboratorio'] ?>" class="btn btn-primary style-action"><i class="fas fa-folder-open"></i></a>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir essa Ordem?', '/laboratorio/delete/<?= $ordem['id_laboratorio'] ?>')"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function desabilitaSelectCaixa() {
        var opcao = document.getElementById('customSwitch1').checked;

        if (opcao) {
            document.getElementById('id_caixa').disabled = true;
        } else {
            document.getElementById('id_caixa').disabled = false;
        }
    }
</script>