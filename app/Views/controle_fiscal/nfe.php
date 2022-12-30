<!-- Modal Cancelar Nota -->
<div class="modal fade" id="modal-cancelar-nota">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cancelar NFe</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/NFe/cancelar" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Justificativa</label>
                                <textarea class="form-control" name="justificativa" rows="10" required></textarea>
                                <p>
                                    <b>Obs:</b> O prazo para cancelamento da NFe é de 1 dia (24 horas) a partir da hora de emissão.
                                </p>
                            </div>
                        </div>

                        <input type="hidden" id="id_nfe" name="id_nfe" type="text">

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

<!-- Modal Cancelar Nota AVULSA -->
<div class="modal fade" id="modal-cancelar-nota-avulsa">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cancelar NFe Avulsa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/NFe/cancelar_avulsa" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Justificativa</label>
                                <textarea class="form-control" name="justificativa" rows="10" required></textarea>
                                <p>
                                    <b>Obs:</b> O prazo para cancelamento da NFe é de 1 dia (24 horas) a partir da hora de emissão.
                                </p>
                            </div>
                        </div>

                        <input type="hidden" id="id_nfe_avulsa" name="id_nfe" type="text">

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
                    <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?> - <b>NFe</b></h6>
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
                            <form action="/controleFiscal/nfe" method="get">
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
                                            <a href="/controleFiscal/baixaXMLS_NFe/<?= $data_inicio ?>/<?= $data_final ?>" class="btn btn-info" style="margin-top: 30px"><i class="fas fa-print"></i> Baixar XMLs</a>
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
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nfes-tab" data-toggle="pill" href="#nfes" role="tab" aria-controls="nfes" aria-selected="true">NFes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nfes-avulsa-tab" data-toggle="pill" href="#nfes-avulsa" role="tab" aria-controls="nfes-avulsa" aria-selected="false">NFes Avulsa</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="nfes" role="tabpanel" aria-labelledby="nfes-tab">
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
                                                    <?php if (!empty($nfes)) : ?>
                                                        <?php foreach ($nfes as $nfe) : ?>
                                                            <tr>
                                                                <td><?= $nfe['id_nfe'] ?></td>
                                                                
                                                                <?php if ($nfe['status'] == "Emitida") : ?>
                                                                    <td><span class="right badge badge-success"><?= $nfe['status'] ?></span></td>
                                                                <?php elseif($nfe['status'] == "Cancelada"): ?>
                                                                    <td><span class="right badge badge-warning"><?= $nfe['status'] ?></span></td>
                                                                <?php else : ?>
                                                                    <td><span class="right badge badge-danger"><?= $nfe['status'] ?></span></td>
                                                                <?php endif; ?>
                                                                
                                                                <td><?= $nfe['numero_da_nota'] ?></td>
                                                                <td><?= number_format($nfe['valor_da_nota'], 2, ',', '.') ?></td>
                                                                <td><?= $nfe['chave'] ?></td>
                                                                <td><?= date('d/m/Y', strtotime($nfe['data'])) ?></td>
                                                                <td><?= $nfe['hora'] ?></td>
                                                                <td><?= $nfe['nome_do_cliente'] ?></td>
                                                                <td><?= $nfe['id_venda'] ?></td>
                                                                
                                                                <td>
                                                                    <?php if ($nfe['status'] == "Emitida") : ?>
                                                                        <a href="/controleFiscal/baixaXML/<?= $nfe['id_nfe'] ?>/1" class="btn btn-info style-action">Baixar XML</a>
                                                                        <button type="button" class="btn btn-warning style-action" onclick="document.getElementById('id_nfe').value = <?= $nfe['id_nfe'] ?>" data-toggle="modal" data-target="#modal-cancelar-nota">Cancelar</button>
                                                                    <?php elseif($nfe['status'] == "Cancelada"): ?>
                                                                        <a href="/controleFiscal/baixaXML/<?= $nfe['id_nfe'] ?>/1" class="btn btn-info style-action">Baixar XML</a>
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
                                <div class="tab-pane fade" id="nfes-avulsa" role="tabpanel" aria-labelledby="nfes-avulsa-tab">
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
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($nfes_avulsa)) : ?>
                                                        <?php foreach ($nfes_avulsa as $nfe) : ?>
                                                            <tr>
                                                                <td><?= $nfe['id_nfe'] ?></td>
                                                                
                                                                <?php if ($nfe['status'] == "Emitida") : ?>
                                                                    <td><span class="right badge badge-success"><?= $nfe['status'] ?></span></td>
                                                                <?php elseif($nfe['status'] == "Cancelada"): ?>
                                                                    <td><span class="right badge badge-warning"><?= $nfe['status'] ?></span></td>
                                                                <?php else : ?>
                                                                    <td><span class="right badge badge-danger"><?= $nfe['status'] ?></span></td>
                                                                <?php endif; ?>
                                                                
                                                                <td><?= $nfe['numero_da_nota'] ?></td>
                                                                <td><?= number_format($nfe['valor_da_nota'], 2, ',', '.') ?></td>
                                                                <td><?= $nfe['chave'] ?></td>
                                                                <td><?= date('d/m/Y', strtotime($nfe['data'])) ?></td>
                                                                <td><?= $nfe['hora'] ?></td>
                                                                
                                                                <td>
                                                                    <?php if ($nfe['status'] == "Emitida") : ?>
                                                                        <a href="/controleFiscal/baixaXML_Avulsa/<?= $nfe['id_nfe'] ?>/1" class="btn btn-info style-action">Baixar XML</a>
                                                                        <button type="button" class="btn btn-warning style-action" onclick="document.getElementById('id_nfe_avulsa').value = <?= $nfe['id_nfe'] ?>" data-toggle="modal" data-target="#modal-cancelar-nota-avulsa">Cancelar</button>
                                                                    <?php elseif($nfe['status'] == "Cancelada"): ?>
                                                                        <a href="/controleFiscal/baixaXML_Avulsa/<?= $nfe['id_nfe'] ?>/1" class="btn btn-info style-action">Baixar XML</a>
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