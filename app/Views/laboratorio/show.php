<!-- Modal SELECIONA CSV -->
<div class="modal fade" id="modal-alterar-status">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/laboratorio/alterarStatusDaEntrega" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Status</label>
                                <div class="input-group">
                                    <select class="form-control select2" name="status" style="width: 100%">
                                        <option value="Aberta" selected>Aberta</option>
                                        <option value="Entregue">Entregue</option>
                                        <option value="Cancelada">Cancelada</option>
                                        <option value="Devolvida">Devolvida</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="id_laboratorio_modal_alterar_status" name="id_laboratorio">
                        <input type="hidden" id="id_entrega_modal_alterar_status" name="id_entrega">

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
                <div class="col-lg-6">
                    <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?><button class="btn btn-info style-action no-print" onclick="imprimirGerarPdf()"><i class="fas fa-print"></i> IMPRIMIR/GERAR PDF</button> <a href="/laboratorio/impressao/<?= $ordem['id_laboratorio'] ?>" target="_blank" class="btn btn-success style-action no-print"><i class="fas fa-print"></i> IMPRIMIR FICHA</a></h6>
                </div>
                <div class="col-sm-6 no-print">
                    <ol class="breadcrumb float-sm-right">
                        <a href="/laboratorio" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
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
                            <?php if (!empty($entrega)) : ?>
                                <h6 class="m-0 text-dark">Dados da Ordem</h6>
                            <?php else : ?>
                                <h6 class="m-0 text-dark">Dados da Ordem <a href="/laboratorio/createEntrega/<?= $ordem['id_laboratorio'] ?>/<?= $ordem['id_cliente'] ?>" class="btn btn-primary style-action no-print"><i class="fas fa-plus-circle"></i> CADASTRAR ENTREGA</a></h6>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Data de entrada</label>
                                <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($ordem['data_de_entrada'])) ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Data prevista</label>
                                <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($ordem['data_prevista'])) ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Valor Total</label>
                                <input type="text" class="form-control" value="<?= number_format($somatorio_servicos_mao_de_obra, 2, ',', '.') ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="">Cor do dente</label>
                                <input type="text" class="form-control" value="<?= $ordem['cor_do_dente'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Caixa</label>
                                <input type="text" class="form-control" value="<?= $ordem['caixa'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="">Cliente</label>
                                <input type="text" class="form-control" value="<?= ($ordem['tipo'] == 1) ? $ordem['nome'] : $ordem['razao_social'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="">Paciente</label>
                                <input type="text" class="form-control" value="<?= $ordem['paciente'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Observações</label>
                            <textarea class="form-control" rows="5" disabled><?= $ordem['observacoes'] ?></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6 class="m-0 text-dark">Dentes</h6>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="">Dentes do Maxiliar</label>
                                <input type="text" class="form-control" value="<?= $ordem['dentes_do_maxilar'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="">Dentes da Mandibula</label>
                                <input type="text" class="form-control" value="<?= $ordem['dentes_da_mandibula'] ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6 class="m-0 text-dark">Serviço/Mão de Obra</h6>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Serviço</th>
                                <th>Detalhes</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                                <th>Desconto</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($servicos_mao_de_obra)) : ?>
                                <?php foreach ($servicos_mao_de_obra as $servico) : ?>
                                    <tr>
                                        <td><?= $servico['nome'] ?></td>
                                        <td><?= $servico['detalhes'] ?></td>
                                        <td><?= $servico['quantidade'] ?></td>
                                        <td><?= number_format($servico['valor'], 2, ',', '.') ?></td>
                                        <td><?= number_format($servico['desconto'], 2, ',', '.') ?></td>
                                        <td><?= number_format((($servico['quantidade'] * $servico['valor']) - $servico['desconto']), 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td style="font-size: 20px" colspan="7"><b>Total:</b> <?= number_format($somatorio_servicos_mao_de_obra, 2, ',', '.') ?></td>
                                </tr>
                            <?php else : ?>
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

            <?php if (!empty($entrega)) : ?>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8">
                                <h6 class="m-0 text-dark">Entrega</h6>
                            </div>
                            <div class="col-lg-4" style="text-align: right">
                                <button 
                                    type="button"
                                    class="btn btn-primary style-action no-print"
                                    onclick="
                                        document.getElementById('id_laboratorio_modal_alterar_status').value = <?= $entrega['id_laboratorio'] ?>,
                                        document.getElementById('id_entrega_modal_alterar_status').value = <?= $entrega['id_entrega'] ?>
                                    "
                                    data-toggle="modal"
                                    data-target="#modal-alterar-status"    
                                >
                                        <i class="fa fa-check"></i> Alterar Status
                                </button>
                                <button type="button" class="btn btn-danger style-action no-print" onclick="confirmaAcaoExcluir('Deseja realmente excluir os dados de entrega?', '/laboratorio/deleteEntrega/<?= $entrega['id_laboratorio'] ?>/<?= $entrega['id_entrega'] ?>')"><i class="fa fa-trash"></i> Excluir</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <input type="text" class="form-control" value="<?= $entrega['status'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="form-group">
                                    <label for="">Data</label>
                                    <input type="date" class="form-control" value="<?= $entrega['data'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label for="">Entregador</label>
                                    <input type="text" class="form-control" value="<?= $entrega['nome'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="">Fixo</label>
                                    <input type="text" class="form-control fixo" value="<?= $cliente['fixo'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="">Celular 1</label>
                                    <input type="text" class="form-control celular" value="<?= $cliente['celular_1'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label for="">Celular 2</label>
                                    <input type="text" class="form-control celular" value="<?= $cliente['celular_1'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">Observações</label>
                                    <input type="text" class="form-control" value="<?= $entrega['observacoes'] ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            <?php endif; ?>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function imprimirGerarPdf() {
        print();
    }
</script>