<!-- Modal Altera Situação -->
<div class="modal fade" id="modal-altera-situacao">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Situação</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/ordemDeServico/alteraSituacao" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Situação</label>
                                <select class="form-control select2" name="situacao" style="width: 100%">
                                    <option value="Em aberto" selected>Em aberto</option>
                                    <option value="Em andamento">Em andamento</option>
                                    <option value="Finalizada">Finalizada</option>
                                    <option value="Cancelada">Cancelada</option>
                                </select>
                            </div>
                        </div>

                        <!-- HIDDEN -->
                        <input type="hidden" id="id_ordem_modal" name="id_ordem">
                    </div>
                    <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Caixa</label>
                                    <select class="form-control select2" id="id_caixa" name="id_caixa" style="width: 100%" disabled required>
                                        <?php foreach($caixas as $caixa): ?>
                                            <option value="<?= $caixa['id_caixa'] ?>">Cod.: <?= $caixa['id_caixa'] ?> - Data Abert.: <?= $caixa['data_de_abertura'] ?> - Hora Abert.: <?= $caixa['hora_de_abertura'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="inserir_valor_no_caixa" checked onclick="desabilitaSelectCaixa()">
                                        <label class="custom-control-label" for="customSwitch1">Não inserir valor da O.S. no caixa</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 25px">
                                <p><b>Obs:</b> Para inserir o valor da O.S. no caixa é necessário que a situação seja Finalizada.</p>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
                            <a href="/ordemDeServico/gerar" class="btn btn-info"><i class="fa fa-user-plus"></i> Gerar Ordem de Serviço</a>
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
                                <th>Nome/Razão Social</th>
                                <th>Situação</th>
                                <th>Data de Entrada</th>
                                <th>Data de Saída</th>
                                <th class="no-print" style="width: 130px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($ordens)): ?>
                                <?php foreach($ordens as $ordem): ?>
                                    <tr>
                                        <td><?= $ordem['id_ordem'] ?></td>
                                        <td><a href="/clientes/show/<?= $ordem['id_cliente'] ?>" style="color: black"><u><?= ($ordem['tipo'] == 1) ? $ordem['nome_do_cliente'] : $ordem['razao_social'] ?></u></a></td>
                                        <td><?= $ordem['situacao'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($ordem['data_de_entrada'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($ordem['data_de_saida'])) ?></td>
                                        <td>
                                            <a href="/ordemDeServico/show/<?= $ordem['id_ordem'] ?>?print=true" class="btn btn-info style-action"><i class="fas fa-print"></i></a>
                                            <button type="button" class="btn btn-success style-action" onclick="document.getElementById('id_ordem_modal').value=<?= $ordem['id_ordem']?>" data-toggle="modal" data-target="#modal-altera-situacao"><i class="fas fa-check-circle"></i></button>
                                            <a href="/ordemDeServico/show/<?= $ordem['id_ordem'] ?>" class="btn btn-primary style-action"><i class="fas fa-folder-open"></i></a>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir essa Ordem de Serviço?', '/ordemDeServico/delete/<?= $ordem['id_ordem'] ?>')"><i class="fas fa-trash"></i></button>
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
    function desabilitaSelectCaixa()
    {
        var opcao = document.getElementById('customSwitch1').checked;

        if(opcao)
        {
            document.getElementById('id_caixa').disabled = true;
        }
        else
        {
            document.getElementById('id_caixa').disabled = false;
        }
    }
</script>