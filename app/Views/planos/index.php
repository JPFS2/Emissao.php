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
                            <a href="/planos/create" class="btn btn-info"><i class="fa fa-plus-circle"></i> Novo Plano</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table id="" class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 35px">Cód.</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Duração</th>
                                <th>Observações</th>
                                <th style="width: 110px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($planos)) : ?>
                                <?php foreach ($planos as $plano) : ?>
                                    <tr>
                                        <td><?= $plano['id_plano'] ?></td>
                                        <td><?= $plano['nome'] ?></td>
                                        <td><?= number_format($plano['valor'], 2, ',', '.') ?></td>
                                        <td><?= $plano['duracao'] ?> dias</td>
                                        <td><?= $plano['observacoes'] ?></td>
                                        <td>
                                            <a href="/planos/edit/<?= $plano['id_plano'] ?>" class="btn btn-warning style-action"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Plano? Ao excluir todas as empresas vinculadas a ele serão apagadas.', '/planos/delete/<?= $plano['id_plano'] ?>')"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">Nenhum registro!</td>
                                </tr>
                            <?php endif; ?>
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