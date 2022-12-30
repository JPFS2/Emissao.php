<!-- Modal Cancelar Nota -->
<div class="modal fade" id="modal-cancelar-nota">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cancelar NFCe</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/NFCe/cancelar" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Justificativa</label>
                                <textarea class="form-control" name="justificativa" rows="10" required></textarea>
                                <p>
                                    <b>Obs:</b> O prazo para cancelamento da NFCe é de 30min a partir da hora de emissão.
                                </p>
                            </div>
                        </div>

                        <input type="hidden" id="id_nfce" name="id_nfce" type="text">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Continuar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" style="margin-bottom: 15px">
                <div class="col-sm-6">
                    <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?> - <b>NFCe</b></h6>
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
                            <form action="/controleFiscal/nfce" method="get">
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
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select class="form-control select2" name="status">
                                                <option value="Todas" <?= (isset($status) && $status == "Todas") ? "selected" : "" ?>>Todas</option>
                                                <option value="Apenas Emitidas" <?= (isset($status) && $status == "Apenas Emitidas") ? "selected" : "" ?>>Apenas Emitidas</option>
                                                <option value="Apenas Canceladas" <?= (isset($status) && $status == "Apenas Canceladas") ? "selected" : "" ?>>Apenas Canceladas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="sutmit" class="btn btn-success" style="margin-top: 30px"><i class="fa fa-filter"></i> Filtrar</button>
                                        <?php if (isset($data_inicio) && isset($data_final) && !empty($nfes)) : ?>
                                            <a href="/controleFiscal/baixaXMLS_NFCe/<?= $data_inicio ?>/<?= $data_final ?>" class="btn btn-info" style="margin-top: 30px"><i class="fas fa-print"></i> Baixar XMLs</a>
                                        <?php endif; ?>
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
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 35px">Cód.</th>
                                        <th>Status</th>
                                        <th>Nº Nota</th>
                                        <th>Valor da Nota</th>
                                        <th>Chave</th>
                                        <th>Data</th>
                                        <th>Hora</th>
                                        <th>Cliente</th>
                                        <th>Cód. Venda</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($nfces)) : ?>
                                        <?php foreach ($nfces as $nfce) : ?>
                                            <tr>
                                                <td><?= $nfce['id_nfce'] ?></td>
                                                
                                                <?php if ($nfce['status'] == "Emitida") : ?>
                                                    <td><span class="right badge badge-success"><?= $nfce['status'] ?></span></td>
                                                <?php elseif($nfce['status'] == "Cancelada"): ?>
                                                    <td><span class="right badge badge-warning"><?= $nfce['status'] ?></span></td>
                                                <?php else : ?>
                                                    <td><span class="right badge badge-danger"><?= $nfce['status'] ?></span></td>
                                                <?php endif; ?>
                                                
                                                <td><?= $nfce['numero_da_nota'] ?></td>
                                                <td><?= number_format($nfce['valor_da_nota'], 2, ',', '.') ?></td>
                                                <td><?= $nfce['chave'] ?></td>
                                                <td><?= date('d/m/Y', strtotime($nfce['data'])) ?></td>
                                                <td><?= $nfce['hora'] ?></td>
                                                <td><?= $nfce['nome_do_cliente'] ?></td>
                                                <td><?= $nfce['id_venda'] ?></td>
                                                
                                                <td>
                                                    <?php if ($nfce['status'] == "Emitida") : ?>
                                                        <a href="/controleFiscal/baixaXML/<?= $nfce['id_nfce'] ?>/2" class="btn btn-info style-action">Baixar XML</a>
                                                        <button type="button" class="btn btn-warning style-action" onclick="document.getElementById('id_nfce').value = <?= $nfce['id_nfce'] ?>" data-toggle="modal" data-target="#modal-cancelar-nota">Cancelar</button>
                                                    <?php elseif($nfce['status'] == "Cancelada"): ?>
                                                        <a href="/controleFiscal/baixaXML/<?= $nfce['id_nfce'] ?>/2" class="btn btn-info style-action">Baixar XML</a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10">Nenhum registro!</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        <?php
        $session = session();
        $alert = $session->getFlashdata('alert');

        if (isset($alert)) :
        ?>
            <?php if ($alert == "success_create") : ?>
                Toast.fire({
                    type: 'success',
                    title: 'Conta à Receber cadastrada com sucesso!'
                })
            <?php elseif ($alert == "success_update") : ?>
                Toast.fire({
                    type: 'success',
                    title: 'Culto atualizado com sucesso!'
                })
            <?php elseif ($alert == "success_delete") : ?>
                Toast.fire({
                    type: 'success',
                    title: 'Conta à Receber excluida com sucesso!'
                })
            <?php elseif ($alert == "success_filter") : ?>
                Toast.fire({
                    type: 'success',
                    title: 'Filtro aplicado!'
                })
            <?php endif; ?>
        <?php endif; ?>
    });
</script>