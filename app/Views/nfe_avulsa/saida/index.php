<!-- Modal Altera Quantidade -->
<div class="modal fade" id="alterar-qtd-do-produto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar QTD</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/vendaRapida/alteraQuantidade" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Nova QTD</label>
                                <input type="hidden" class="form-control" id="id_produto_da_venda_rapida" name="id_produto_da_venda_rapida">
                                <input type="number" class="form-control" name="quantidade">
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

<!-- Modal Altera Desconto -->
<div class="modal fade" id="alterar-desconto-do-produto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Desconto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/vendaRapida/alteraDesconto" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Desconto</label>
                                <input type="hidden" class="form-control" id="id_produto_da_venda_rapida_desconto" name="id_produto_da_venda_rapida">
                                <input type="text" class="form-control money" name="desconto">
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

<!-- Modal Altera Valor Unitário -->
<div class="modal fade" id="alterar-valor-unitario-do-produto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar Valor Unitário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/vendaRapida/alteraValorUnitario" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Valor Unitário</label>
                                <input type="hidden" class="form-control" id="id_produto_da_venda_rapida_valor_unitario" name="id_produto_da_venda_rapida">
                                <input type="text" class="form-control money" name="valor_unitario">
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
                <div class="card-body">
                    <form action="/NFeAvulsa/addProduto/2" method="post">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Produto</label>
                                    <select class="form-control select2" name="id_produto" style="width: 100%;" required="">
                                        <?php if (!empty($produtos_do_estoque)) : ?>
                                            <?php foreach ($produtos_do_estoque as $produto) : ?>
                                                <option value="<?= $produto['id_produto'] ?>"><?= $produto['nome'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Cód. de Barras</label>
                                    <input type="text" class="form-control" name="codigo_de_barras" autofocus>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Qtd</label>
                                    <input type="text" class="form-control" name="quantidade" value="1" required="">
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-block" style="margin-top: 31px"><i class="fas fa-plus-circle"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cód</th>
                                            <th>Nome</th>
                                            <th>Qtd</th>
                                            <th>Valor Unit.</th>
                                            <th>Subtotal</th>
                                            <th>Desconto</th>
                                            <th>Valor Final</th>
                                            <th style="width: 10px">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total_da_nota = 0; ?>

                                        <?php if (!empty($produtos_da_nfe)) : ?>
                                            <?php foreach ($produtos_da_nfe as $produto) : ?>
                                                <tr>
                                                    <td><?= $produto['id_produto'] ?></td>
                                                    <td><?= $produto['nome'] ?></td>
                                                    <td><?= $produto['quantidade'] ?></td>
                                                    <td><?= $produto['valor_unitario'] ?></td>
                                                    <td><?= $produto['quantidade'] * $produto['valor_unitario'] ?></td>
                                                    <td><?= $produto['desconto'] ?></td>
                                                    <td><?= ($produto['quantidade'] * $produto['valor_unitario']) - $produto['desconto'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger style-action" onclick="confirmaAcaoExcluir('Deseja realmente excluir esse Produto?', '/NFeAvulsa/deleteProduto/<?= $produto['id_produto_nfe_avulsa'] ?>/2')"><i class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>

                                                <?php $total_da_nota += (($produto['quantidade'] * $produto['valor_unitario']) - $produto['desconto']) ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8">Nenhum registro!</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h5><b>Total da Nota:</b> R$ <?= number_format($total_da_nota, 2, ',', '.') ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->

            <form id="form-emitir-nota" action="/NFe/NFeAvulsaSaida" method="post">
                
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="m-0 text-dark"><i class="fas fa-user"></i> DESTINATÁRIO</h6>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select class="form-control select2" id="tipo" name="tipo" style="width: 100%;" onchange="alteraTipo()">
                                        <option value="1" selected="">Pessoa Física</option>
                                        <option value="2">Pessoa Jurídica</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">CPF</label>
                                    <input type="text" class="form-control cpf" id="cpf" name="cpf" value="" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Razão social</label>
                                    <input type="text" class="form-control" id="razao_social" name="razao_social" value="" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">CNPJ</label>
                                    <input type="text" class="form-control cnpj" id="cnpj" name="cnpj" value="" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Isento</label>
                                    <select class="form-control select2" id="isento" name="isento" style="width: 100%" onchange="alteraIsento()">
                                        <option value="1">Sim</option>
                                        <option value="0" selected>Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4" style="">
                                <div class="form-group">
                                    <label for="">I.E.</label>
                                    <input type="text" class="form-control" id="input-ie" name="ie" value="" required >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">CEP</label>
                                    <input type="text" class="form-control cep" id="cep" name="cep" value="" required="">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro" value="" required="">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <label for="">Número</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="numero" name="numero" value="S/N" disabled>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-info btn-flat" onclick="semNumero('numero')">S/N</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="">Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" value="" required="">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" value="" required="">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">UF</label>
                                    <select class="form-control select2" id="id_uf" name="id_uf" onchange="selecionaUF('id_uf')" style="width: 100%" required>
                                        <option value="" selected>Selecione</option>
                                        <?php if(!empty($ufs)): ?>
                                            <?php foreach($ufs as $uf): ?>
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
                                        <!-- MUNICIPIOS AJAX -->
                                        <option value="">Selecione a UF para carregas os municipios</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card -->
                
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="m-0 text-dark"><i class="fas fa-check"></i> DADOS FINAIS</h6>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="">Natureza da Operação</label>
                                    <input type="text" class="form-control" name="natureza_da_operacao" value="VENDA DE MERCADORIAS">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Data</label>
                                    <input type="date" class="form-control" name="data" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Hora</label>
                                    <input type="time" class="form-control" name="hora" value="<?= date('H:i:s') ?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Troco</label>
                                    <input type="text" class="form-control money" name="troco" value="0,00">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Forma de Pagamento</label>
                                    <select class="form-control select2" name="forma_de_pagamento" style="width: 100%">
                                        <option value="0" selected>À Vista</option>
                                        <option value="1">À Prazo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Tipo de Pagamento</label>
                                    <select class="form-control select2" name="tipo_de_pagamento" style="width: 100%">
                                        <option value="01" selected>Dinheiro</option>
                                        <option value="02">Cheque</option>
                                        <option value="03">Cartão de Crédito</option>
                                        <option value="04">Cartão de Débito</option>
                                        <option value="05">Crédito Loja</option>
                                        <option value="10">Vale Alimentação</option>
                                        <option value="11">Vale Refeição</option>
                                        <option value="12">Vale Presente</option>
                                        <option value="13">Vale Combustível</option>
                                        <option value="15">Boleto Bancário</option>
                                        <option value="90">Sem Pagamento</option>
                                        <option value="99">Outros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Inf. Complementares</label>
                                    <input type="text" class="form-control" name="informacoes_complementares">
                                    <p style="font-size: 10px">Não entra na NFCe.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Inf. para o Fisco</label>
                                    <input type="text" class="form-control" name="informacoes_para_fisco">
                                    <p style="font-size: 10px">Não entra na NFCe.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="m-0 text-dark"><i class="fas fa-check"></i> Transportadora</h6>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Transportadora</label>
                                    <select class="form-control select2" id="id_transportadora" name="id_transportadora" style="width: 100%" onchange="alteraTransportadora()">
                                        <option value="0">Sem Transporte</option>
                                        <?php if(!empty($transportadoras)): ?>
                                            <?php foreach($transportadoras as $transportadora): ?>
                                                <option value="<?= $transportadora['id_transportadora'] ?>"><?= $transportadora['xNome'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Qtd. Volume</label>
                                    <input type="text" class="form-control" id="qtdVol" name="qVol" required disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Unidade</label>
                                    <select class="form-control select2" id="id_unidade" name="id_unidade" style="width: 100%" required disabled>
                                        <option value="" selected>Selecione</option>
                                        <?php if(!empty($unidades)): ?>
                                            <?php foreach($unidades as $unidade): ?>
                                                <option value="<?= $unidade['id_unidade'] ?>"><?= $unidade['descricao'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Peso Liq.</label>
                                    <input type="text" class="form-control" id="pesoLiq" name="pesoL" required disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Peso Bruto</label>
                                    <input type="text" class="form-control" id="pesoBruto" name="pesoB" required disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="offset-lg-8 col-lg-4" style="text-align: right">
                                <button class="btn btn-success" type="submit" <?= ($total_da_nota == 0) ? "disabled" : "" ?>><i class="fas fa-plus-circle"></i> Emitir NFe</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

            </form>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    function alteraTipo() {
        tipo = document.getElementById('tipo').value;

        if (tipo == 1) {
            // Reabilita campos PESSOA FÍSICA
            document.getElementById('nome').disabled = false;
            document.getElementById('cpf').disabled  = false;

            // Desabilita e limpa campos PESSOA JURÍDICA
            document.getElementById('razao_social').disabled = true;
            document.getElementById('cnpj').disabled         = true;
            document.getElementById('razao_social').value    = "";
            document.getElementById('cnpj').value            = "";
        } else {
            // Desabilita e limpa campos PESSOA FÍSICA
            document.getElementById('nome').disabled = true;
            document.getElementById('cpf').disabled  = true;
            document.getElementById('nome').value    = "";
            document.getElementById('cpf').value     = "";

            // Reabilita os campos para uso PESSOA JURÍDICA
            document.getElementById('razao_social').disabled = false;
            document.getElementById('cnpj').disabled         = false;
        }
    }

    function alteraIsento()
    {
        isento = document.getElementById('isento').value;

        if(isento == 1) 
        {
            // Desabilita campo
            document.getElementById('input-ie').disabled = true;
            // Limpa campo
            document.getElementById('input-ie').value = "";
        }
        else
        {
            // Desabilita campo
            document.getElementById('input-ie').disabled = false;
        }
    }

    // Chama as funções para trabalhar nos campos
    alteraTipo();
    alteraIsento();

    function alteraTransportadora()
    {
        var opcao = document.getElementById('id_transportadora').value;
        
        if(opcao == 0)
        {
            document.getElementById('qtdVol').disabled     = true;
            document.getElementById('id_unidade').disabled = true;
            document.getElementById('pesoLiq').disabled    = true;
            document.getElementById('pesoBruto').disabled  = true;
        }
        else
        {
            document.getElementById('qtdVol').disabled     = false;
            document.getElementById('id_unidade').disabled = false;
            document.getElementById('pesoLiq').disabled    = false;
            document.getElementById('pesoBruto').disabled  = false;
        }
    }
</script>