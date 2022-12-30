<!-- Modal Selecionar Serviço/mão de obra -->
<div class="modal fade" id="seleciona-servico-mao-de-obra">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecionar Serviço/Mão de Obra</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/laboratorio/createServico/<?= $id_laboratorio ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Serviço/Mão de Obra</label>
                                <select class="form-control select2" name="id_servico" style="width: 100%" required>
                                    <?php if (!empty($servicos_mao_de_obra)) : ?>
                                        <?php foreach ($servicos_mao_de_obra as $servico) : ?>
                                            <option value="<?= $servico['id_servico'] ?>"><?= $servico['nome'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Quantidade</label>
                                <input type="number" class="form-control" name="quantidade" required>
                            </div>
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
                        <div class="col-lg-8">
                            <h6 class="m-0 text-dark">Dentes</h6>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6" style="margin-top: 80px">
                            <div class="form-group">
                                <label for="">Maxilar</label>
                                <input type="text" class="form-control" id="dentes_do_maxilar" value="<?= $ordem_do_laboratorio['dentes_do_maxilar'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Mandíbula</label>
                                <input type="text" class="form-control" id="dentes_da_mandibula" value="<?= $ordem_do_laboratorio['dentes_da_mandibula'] ?>">
                            </div>
                            <div class="form-group" style="text-align: right">
                                <button type="button" class="btn btn-primary" onclick="salvaProvisorioDentesDoLaboratorio()"><i class="fas fa-save"></i> Salvar</button>
                            </div>
                        </div>
                        <div class="col-lg-6" style="text-align: center">
                            <img src="<?= base_url('assets/img/odontograma.png') ?>" style="width: 220px" alt="">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h6 class="m-0 text-dark">Serviço/Mão de Obra</h6>
                        </div>
                        <div class="col-lg-4" style="text-align: right">
                            <a href="#" class="btn btn-info style-action" data-toggle="modal" data-target="#seleciona-servico-mao-de-obra"><i class="fa fa-plus-circle"></i> Adicionar</a>
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
                                <th class="no-print" style="width: 60px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($servicos_mao_de_obra_provisorio)) : ?>
                                <?php foreach ($servicos_mao_de_obra_provisorio as $servico) : ?>
                                    <tr>
                                        <td><?= $servico['nome'] ?></td>
                                        <td><?= $servico['detalhes'] ?></td>
                                        <td><?= $servico['quantidade'] ?></td>
                                        <td><?= number_format($servico['valor'], 2, ',', '.') ?></td>
                                        <td><?= number_format($servico['desconto'], 2, ',', '.') ?></td>
                                        <td><?= number_format((($servico['quantidade'] * $servico['valor']) - $servico['desconto']), 2, ',', '.') ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Serviço?', '/laboratorio/deleteServico/<?= $servico['id_servico'] ?>/<?= $id_laboratorio ?>')"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td style="font-size: 20px" colspan="7"><b>Total:</b> <?= number_format($somatorio_servicos_mao_de_obra, 2, ',', '.') ?></td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7">Nenhum registro!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6 class="m-0 text-dark">Dados Finais</h6>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <form action="/laboratorio/finalizar" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Data de entrada</label>
                                    <input type="date" class="form-control" name="data_de_entrada" value="<?= $ordem_do_laboratorio['data_de_entrada'] ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Data prevista</label>
                                    <input type="date" class="form-control" name="data_prevista" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <div class="form-group">
                                    <label for="">Valor Total</label>
                                    <input type="text" class="form-control" value="<?= number_format($somatorio_servicos_mao_de_obra, 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Cor do dente</label>
                                    <input type="text" class="form-control" name="cor_do_dente" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Caixa</label>
                                    <input type="text" class="form-control" name="caixa" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <select class="form-control select2" name="id_cliente" required>
                                        <?php foreach ($clientes as $cliente) : ?>
                                            <option value="<?= $cliente['id_cliente'] ?>"><?= ($cliente['tipo'] == 1) ? $cliente['nome'] : $cliente['razao_social'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Paciente</label>
                                    <input type="text" class="form-control" name="paciente" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Observações</label>
                                    <textarea class="form-control" name="observacoes" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id_laboratorio" value="<?= $id_laboratorio ?>">

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Gerar Ordem</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function salvaProvisorioDentesDoLaboratorio() {
        var dentes_do_maxilar, dentes_da_mandibula;

        dentes_do_maxilar = document.getElementById('dentes_do_maxilar').value;
        dentes_da_mandibula = document.getElementById('dentes_da_mandibula').value;

        $.post(
            "/Laboratorio/salvaProvisorioDentesDoLaboratorio/<?= $id_laboratorio ?>", {
                'dentes_do_maxilar': dentes_do_maxilar,
                'dentes_da_mandibula': dentes_da_mandibula
            },

            function(data, status) {
                if (status == "success") {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000
                    });

                    Toast.fire({
                        type: 'success',
                        title: 'Dados dos dentes salvos com sucesso!'
                    })
                }
            }
        );
    }
</script>