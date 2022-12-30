<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row" style="margin-bottom: 15px">
                <div class="col-lg-6">
                    <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?> <button type="button" class="btn btn-success no-print" onclick="print()"><i class="fas fa-print"></i> Imprimir/Gerar PDF</button></h6>
                </div>
                <div class="col-sm-6 no-print">
                    <ol class="breadcrumb float-sm-right">
                        <a href="/ordemDeServico" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
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
                            <h6 class="m-0 text-dark">Dados da O.S.</h6>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">                    
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Mão de Obra</label>
                                <input type="text" class="form-control" value="<?= number_format($somatorio_servicos_mao_de_obra, 2, ',', '.') ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Peças</label>
                                <input type="text" class="form-control" value="<?= number_format($somatorio_produtos_pecas, 2, ',', '.') ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Frete</label>
                                <input type="text" class="form-control" value="<?= number_format($ordem_de_servico['frete'], 2, ',', '.') ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Outros</label>
                                <input type="text" class="form-control" value="<?= number_format($ordem_de_servico['outros'], 2, ',', '.') ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Desconto</label>
                                <input type="text" class="form-control" value="<?= number_format($ordem_de_servico['desconto'], 2, ',', '.') ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Total</label>
                                <input type="text" class="form-control" value="<?= number_format(($somatorio_servicos_mao_de_obra + $somatorio_produtos_pecas), 2, ',', '.') ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="">Situação</label>
                                <input type="text" class="form-control" value="<?= $ordem_de_servico['situacao'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Data de Entrada</label>
                                <input type="date" class="form-control" value="<?= $ordem_de_servico['data_de_entrada'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Hora de Entrada</label>
                                <input type="time" class="form-control" value="<?= $ordem_de_servico['hora_de_entrada'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Data de Saída</label>
                                <input type="date" class="form-control" value="<?= $ordem_de_servico['data_de_saida'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label for="">Hora de Saída</label>
                                <input type="time" class="form-control" value="<?= $ordem_de_servico['hora_de_saida'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="">Cliente</label>
                                <input type="text" class="form-control" value="<?= $ordem_de_servico['nome_do_cliente'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="">Vendedor</label>
                                <input type="text" class="form-control" value="<?= $ordem_de_servico['nome_do_vendedor'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="">Tecnico</label>
                                <input type="text" class="form-control" value="<?= $ordem_de_servico['nome_do_tecnico'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label for="">Canal de Venda</label>
                                <input type="text" class="form-control" value="<?= $ordem_de_servico['canal_de_venda'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label for="">Forma de Pagamento</label>
                                <input type="text" class="form-control" value="<?= $ordem_de_servico['forma_de_pagamento'] ?>" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="">Endereço de Entrega</label>
                                <input type="text" class="form-control" value="<?= $ordem_de_servico['endereco_de_entrega'] ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="">Observações</label>
                                <textarea class="form-control" name="observacoes" rows="5" disabled><?= $ordem_de_servico['observacoes'] ?></textarea>
                                <p class="no-print" style="font-size: 12px">Esta observação será impressa no pedido.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 no-print">
                            <div class="form-group">
                                <label for="">Observações Internas</label>
                                <textarea class="form-control" name="observacoes_internas" rows="5" disabled><?= $ordem_de_servico['observacoes_internas'] ?></textarea>
                                <p style="font-size: 12px">Esta observação é de uso interno, portanto não será impressa no pedido.</p>
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
                            <h6 class="m-0 text-dark">Equipamentos</h6>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">                    
                    <table class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Equipamento</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($equipamentos)): ?>
                                <?php foreach($equipamentos as $equipamento): ?>
                                    <tr>
                                        <td><?= $equipamento['equipamento'] ?></td>
                                        <td><?= $equipamento['marca'] ?></td>
                                        <td><?= $equipamento['modelo'] ?></td>
                                        <td><?= $equipamento['serie'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">Nenhum registro!</td>
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
                            <h6 class="m-0 text-dark">Produtos/Peças</h6>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">                    
                    <table class="table table-hover text-nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Detalhes</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                                <th>Desconto</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($produtos_pecas)): ?>
                                <?php foreach($produtos_pecas as $produto): ?>
                                    <tr>
                                        <td><?= $produto['nome'] ?></td>
                                        <td><?= $produto['detalhes'] ?></td>
                                        <td><?= $produto['quantidade'] ?></td>
                                        <td><?= number_format($produto['valor'], 2, ',', '.') ?></td>
                                        <td><?= number_format($produto['desconto'], 2, ',', '.') ?></td>
                                        <td><?= number_format((($produto['quantidade'] * $produto['valor']) - $produto['desconto']), 2, ',', '.') ?></td>
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
                            <?php if(!empty($servicos_mao_de_obra)): ?>
                                <?php foreach($servicos_mao_de_obra as $servico): ?>
                                    <tr>
                                        <td><?= $servico['nome'] ?></td>
                                        <td><?= $servico['detalhes'] ?></td>
                                        <td><?= $servico['quantidade'] ?></td>
                                        <td><?= number_format($servico['valor'], 2, ',', '.') ?></td>
                                        <td><?= number_format($servico['desconto'], 2, ',', '.') ?></td>
                                        <td><?= number_format((($servico['quantidade'] * $servico['valor']) - $servico['desconto']), 2, ',', '.') ?></td>
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

<?php if(isset($_GET['print'])): ?>
    <script>
        print();
    </script>
<?php endif; ?>