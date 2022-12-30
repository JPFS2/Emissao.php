<!-- Modal Altera Quantidade -->
<div class="modal fade" id="seleciona-produto-peca">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecionar Produto/Peça</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/ordemDeServico/createPeca" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Produtos/Peças</label>
                                <select class="form-control select2" name="id_produto" style="width: 100%" required>
                                    <?php if(!empty($produtos)): ?>
                                        <?php foreach($produtos as $produto): ?>
                                            <option value="<?= $produto['id_produto'] ?>"><?= $produto['nome'] ?></option>
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

<!-- Modal Altera Quantidade -->
<div class="modal fade" id="seleciona-servico-mao-de-obra">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecionar Serviço/Mão de Obra</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/ordemDeServico/createServico" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Serviço/Mão de Obra</label>
                                <select class="form-control select2" name="id_servico" style="width: 100%" required>
                                    <?php if(!empty($servicos_mao_de_obra)): ?>
                                        <?php foreach($servicos_mao_de_obra as $servico): ?>
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
                            <h6 class="m-0 text-dark">Equipamentos</h6>
                        </div>
                        <div class="col-lg-4" style="text-align: right">
                            <a href="/ordemDeServico/createEquipamento" class="btn btn-info style-action"><i class="fa fa-plus-circle"></i> Adicionar</a>
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
                                <th class="no-print" style="width: 130px">Ações</th>
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
                                        <td>
                                            <a href="/ordemDeServico/showEquipamento/<?= $equipamento['id_equipamento'] ?>" class="btn btn-primary style-action"><i class="fas fa-folder-open"></i></a>
                                            <a href="/ordemDeServico/editEquipamento/<?= $equipamento['id_equipamento'] ?>" class="btn btn-warning style-action"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Equipamento?', '/ordemDeServico/deleteEquipamento/<?= $equipamento['id_equipamento'] ?>')"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">Nenhum registro!</td>
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
                        <div class="col-lg-8">
                            <h6 class="m-0 text-dark">Produtos/Peças</h6>
                        </div>
                        <div class="col-lg-4" style="text-align: right">
                            <a href="#" class="btn btn-info style-action" data-toggle="modal" data-target="#seleciona-produto-peca"><i class="fa fa-plus-circle"></i> Adicionar</a>
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
                                <th class="no-print" style="width: 130px">Ações</th>
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
                                        <td>
                                            <a href="/ordemDeServico/showPeca/<?= $produto['id_produto'] ?>" class="btn btn-primary style-action"><i class="fas fa-folder-open"></i></a>
                                            <a href="/ordemDeServico/editPeca/<?= $produto['id_produto'] ?>" class="btn btn-warning style-action"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Produto/Peça?', '/ordemDeServico/deletePeca/<?= $produto['id_produto'] ?>')"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
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
                                <th class="no-print" style="width: 130px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($servicos_mao_de_obra_provisorio)): ?>
                                <?php foreach($servicos_mao_de_obra_provisorio as $servico): ?>
                                    <tr>
                                        <td><?= $servico['nome'] ?></td>
                                        <td><?= $servico['detalhes'] ?></td>
                                        <td><?= $servico['quantidade'] ?></td>
                                        <td><?= number_format($servico['valor'], 2, ',', '.') ?></td>
                                        <td><?= number_format($servico['desconto'], 2, ',', '.') ?></td>
                                        <td><?= number_format((($servico['quantidade'] * $servico['valor']) - $servico['desconto']), 2, ',', '.') ?></td>
                                        <td>
                                            <a href="/ordemDeServico/showServico/<?= $servico['id_servico'] ?>" class="btn btn-primary style-action"><i class="fas fa-folder-open"></i></a>
                                            <a href="/ordemDeServico/editServico/<?= $servico['id_servico'] ?>" class="btn btn-warning style-action"><i class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Serviço?', '/ordemDeServico/deleteServico/<?= $servico['id_servico'] ?>')"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
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
                <form action="/ordemDeServico/finalizar" method="post">
                    <div class="card-body">                    
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Mão de Obra</label>
                                    <input type="text" class="form-control" id="mao_de_obra" value="<?= number_format($somatorio_servicos_mao_de_obra, 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Peças</label>
                                    <input type="text" class="form-control" id="pecas" value="<?= number_format($somatorio_produtos_pecas, 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Frete</label>
                                    <input type="text" class="form-control money" id="frete" name="frete" value="0" onkeyup="calculaValorFinal()" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Outros</label>
                                    <input type="text" class="form-control money" id="outros" name="outros" value="0" onkeyup="calculaValorFinal()" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Desconto</label>
                                    <input type="text" class="form-control money" id="desconto" name="desconto" value="0" onkeyup="calculaValorFinal()" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Total</label>
                                    <input type="text" class="form-control" id="valor_total" value="<?= number_format(($somatorio_servicos_mao_de_obra + $somatorio_produtos_pecas), 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Situação</label>
                                    <select class="form-control select2" name="situacao">
                                        <option value="Em aberto" selected>Em aberto</option>
                                        <option value="Em andamento">Em andamento</option>
                                        <option value="Finalizada">Finalizada</option>
                                        <option value="Cancelada">Cancelada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Data de Entrada</label>
                                    <input type="date" class="form-control" name="data_de_entrada" value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Hora de Entrada</label>
                                    <input type="time" class="form-control" name="hora_de_entrada" value="<?= date('H:i')?>" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Data de Saída</label>
                                    <input type="date" class="form-control" name="data_de_saida">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Hora de Saída</label>
                                    <input type="time" class="form-control" name="hora_de_saida">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <select class="form-control select2" name="id_cliente" required>
                                        <?php foreach($clientes as $cliente): ?>
                                            <option value="<?= $cliente['id_cliente'] ?>"><?= $cliente['nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Vendedor</label>
                                    <select class="form-control select2" name="id_vendedor" required>
                                        <?php foreach($vendedores as $vendedor): ?>
                                            <option value="<?= $vendedor['id_vendedor'] ?>"><?= $vendedor['nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Tecnico</label>
                                    <select class="form-control select2" name="id_tecnico" required>
                                        <?php foreach($tecnicos as $tecnico): ?>
                                            <option value="<?= $tecnico['id_tecnico'] ?>"><?= $tecnico['nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Canal de Venda</label>
                                    <select class="form-control select2" name="canal_de_venda">
                                        <option value="Internet">Internet</option>
                                        <option value="Presencial" selected>Presencial</option>
                                        <option value="Telemarketing">Telemarketing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Forma de Pagamento</label>
                                    <select class="form-control select2" name="forma_de_pagamento" required>
                                        <?php foreach($formas_de_pagamento as $forma): ?>
                                            <option value="<?= $forma['nome'] ?>"><?= $forma['nome'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Endereço de Entrega</label>
                                    <input type="text" class="form-control" name="endereco_de_entrega">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Observações</label>
                                    <textarea class="form-control" name="observacoes" rows="5"></textarea>
                                    <p style="font-size: 12px">Esta observação será impressa no pedido.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Observações Internas</label>
                                    <textarea class="form-control" name="observacoes_internas" rows="5"></textarea>
                                    <p style="font-size: 12px">Esta observação é de uso interno, portanto não será impressa no pedido.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Caixa</label>
                                    <select class="form-control select2" id="id_caixa" name="id_caixa" style="width: 100%" required>
                                        <?php foreach($caixas as $caixa): ?>
                                            <option value="<?= $caixa['id_caixa'] ?>">Cod.: <?= $caixa['id_caixa'] ?> - Data Abert.: <?= $caixa['data_de_abertura'] ?> - Hora Abert.: <?= $caixa['hora_de_abertura'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="inserir_valor_no_caixa" onclick="desabilitaSelectCaixa()">
                                        <label class="custom-control-label" for="customSwitch1">Não inserir valor da O.S. no caixa</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 25px">
                                <p><b>Obs:</b> Para inserir o valor da O.S. no caixa é necessário que a situação seja Finalizada.</p>
                            </div>
                        </div>

                        <input type="hidden" name="total" value="<?= $somatorio_servicos_mao_de_obra + $somatorio_produtos_pecas ?>">

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: right">
                                <button type="submit" class="btn btn-primary">Gerar Ordem de Serviço</button>
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
    function calculaValorFinal()
    {
        var mao_de_obra, pecas, frete, outros, desconto, valor_total;

        mao_de_obra = converteMoneyUSD(document.getElementById('mao_de_obra').value);
        pecas       = converteMoneyUSD(document.getElementById('pecas').value);
        frete       = converteMoneyUSD(document.getElementById('frete').value);
        outros      = converteMoneyUSD(document.getElementById('outros').value);
        desconto    = converteMoneyUSD(document.getElementById('desconto').value);
        
        valor_total = (parseFloat(mao_de_obra) + parseFloat(pecas) + parseFloat(frete) + parseFloat(outros)) - parseFloat(desconto);        

        document.getElementById('valor_total').value = converteMoneyBRL(valor_total);
    }

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