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
                    <h6>Gerar Parcelas</h6>
                </div>
                <div class="card-body">
                    <form action="/vendaRapida/geraParcelasDoCrediario/<?= $venda['id_venda'] ?>" method="post">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Quantidade</label>
                                    <input type="text" class="form-control" name="quantidade" value="1" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">1º Vencimento</label>
                                    <input type="date" class="form-control" name="primeiro_vencimento" required="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Valor da Venda</label>
                                    <input type="text" class="form-control" value="<?= number_format($venda['valor_a_pagar'], 2, ',', '.') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-block" style="margin-top: 31px"><i class="fas fa-plus-circle"></i> Gerar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header">
                    <h6>Parcelas</h6>
                </div>
                <div class="card-body">
                    <?php $i = 1; ?>
                    <?php foreach ($parcelas as $parcela) : ?>
                        <form action="/vendaRapida/alteraDadosDaParcelaIndividual/<?= $venda['id_venda'] ?>" method="post">
                            <div class="row">
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <label for="">Parcela</label>
                                        <input type="text" class="form-control" name="valor" value="<?= $i ?>" disabled="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Descrição</label>
                                        <input type="text" class="form-control" name="nome" value="<?= $parcela['nome'] ?>" required="">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Vencimento</label>
                                        <input type="date" class="form-control" name="data_de_vencimento" value="<?= $parcela['data_de_vencimento'] ?>" required="">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="">Valor</label>
                                        <input type="text" class="form-control money" name="valor" value="<?= number_format($parcela['valor'], 2, ',', '.') ?>" required="">
                                    </div>
                                </div>

                                <input type="hidden" name="id_parcela" value="<?= $parcela['id_parcela'] ?>">

                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 30px"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php $i += 1; ?>
                    <?php endforeach; ?>
                </div>
                <div class="card-footer" style="text-align: right">
                    <a href="/vendaRapida/finalizarVendaNoCrediario" class="btn btn-success <?= (empty($parcelas)) ? "disabled" : "" ?>">Finalizar Venda</a>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->