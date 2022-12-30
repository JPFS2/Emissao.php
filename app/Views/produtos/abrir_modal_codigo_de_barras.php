<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Modal Pergunta adicionar mais um código de barras ao produto -->
            <div class="modal fade" id="modal-adicionar-codigo-de-barras">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Código de Barras</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h6>Deseja cadastrar código de barras para esse Produto?</h6>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <a href="/produtos/storeCadastroCodigoDeBarras/<?= $id_produto ?>/0" class="btn btn-warning">Não</a>
                            <a href="/produtos/storeCadastroCodigoDeBarras/<?= $id_produto ?>/1" class="btn btn-success">Sim</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(function() {
        //Abre model caixas abertos
        $('#modal-adicionar-codigo-de-barras').modal('show')
    });
</script>