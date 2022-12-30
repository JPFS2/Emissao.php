<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="/login/store" method="post">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> <?= $titulo['modulo'] ?></h6>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <a href="/login/usuarios" class="btn btn-success button-voltar"><i class="fa fa-arrow-alt-circle-left"></i> Voltar</a>
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
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Usuário</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" onfocusout="verificaNomeDeUsuario()" value="<?= (isset($usuario)) ? $usuario['usuario'] : "" ?>" autofocus required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Senha</label>
                                    <input type="password" class="form-control" id="senha" name="senha" value="<?= (isset($usuario)) ? $usuario['senha'] : "" ?>" required>
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
                            <div class="col-sm-12">
                                <h6 class="m-0 text-dark"><i class="<?= $titulo['icone'] ?>"></i> Permissões no Sistema</h6>
                            </div><!-- /.col -->
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">

                            <?php if (
                                $controle_de_acesso_do_plano['venda_rapida'] != 0 ||
                                $controle_de_acesso_do_plano['pesquisa_produto'] != 0 ||
                                $controle_de_acesso_do_plano['historico_de_vendas'] != 0 ||
                                $controle_de_acesso_do_plano['orcamentos'] != 0 ||
                                $controle_de_acesso_do_plano['pedidos'] != 0
                            ) : ?>
                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">VENDAS</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['venda_rapida'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Venda Rápida</label>
                                                <select class="form-control select2" id="venda_rapida" name="venda_rapida" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>
                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['venda_rapida'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['pesquisa_produto'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Pesq. Produto</label>
                                                <select class="form-control select2" id="pesquisa_produto" name="pesquisa_produto" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['pesquisa_produto'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['historico_de_vendas'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Hist. de Vendas</label>
                                                <select class="form-control select2" id="historico_de_vendas" name="historico_de_vendas" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['historico_de_vendas'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['orcamentos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Orçamentos</label>
                                                <select class="form-control select2" id="orcamentos" name="orcamentos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['orcamentos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['pedidos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Pedidos</label>
                                                <select class="form-control select2" id="pedidos" name="pedidos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['pedidos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['ordem_de_servico'] != 0
                            ) : ?>
                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">ORDEM DE SERVIÇO</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['ordem_de_servico'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Ordem de Serviço</label>
                                                <select class="form-control select2" id="ordem_de_servico" name="ordem_de_servico" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['ordem_de_servico'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['novo_pedido'] != 0 ||
                                $controle_de_acesso_do_plano['mesas'] != 0 ||
                                $controle_de_acesso_do_plano['entregas'] != 0 ||
                                $controle_de_acesso_do_plano['abrir_painel'] != 0 ||
                                $controle_de_acesso_do_plano['transmitir_no_painel'] != 0 ||
                                $controle_de_acesso_do_plano['configs'] != 0
                            ) : ?>
                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">FOOD</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['novo_pedido'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Novo Pedido</label>
                                                <select class="form-control select2" id="novo_pedido" name="novo_pedido" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['novo_pedido'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['mesas'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Mesas</label>
                                                <select class="form-control select2" id="mesas" name="mesas" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['mesas'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['entregas'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Entregas</label>
                                                <select class="form-control select2" id="entregas" name="entregas" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['entregas'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['abrir_painel'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Abrir Painel</label>
                                                <select class="form-control select2" id="abrir_painel" name="abrir_painel" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['abrir_painel'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['transmitir_no_painel'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Transmitir no Painel</label>
                                                <select class="form-control select2" id="transmitir_no_painel" name="transmitir_no_painel" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['transmitir_no_painel'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['configs'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Configs</label>
                                                <select class="form-control select2" id="configs" name="configs" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['configs'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['clientes'] != 0 ||
                                $controle_de_acesso_do_plano['fornecedores'] != 0 ||
                                $controle_de_acesso_do_plano['funcionarios'] != 0 ||
                                $controle_de_acesso_do_plano['vendedores'] != 0 ||
                                $controle_de_acesso_do_plano['entregadores'] != 0 ||
                                $controle_de_acesso_do_plano['tecnicos'] != 0 ||
                                $controle_de_acesso_do_plano['servico_mao_de_obra'] != 0
                            ) : ?>

                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">CONTROLE GERAL</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['clientes'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Clientes</label>
                                                <select class="form-control select2" id="clientes" name="clientes" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['clientes'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['fornecedores'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Fornecedores</label>
                                                <select class="form-control select2" id="fornecedores" name="fornecedores" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['fornecedores'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['funcionarios'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Funcionários</label>
                                                <select class="form-control select2" id="funcionarios" name="funcionarios" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['funcionarios'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['vendedores'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Vendedores</label>
                                                <select class="form-control select2" id="vendedores" name="vendedores" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['vendedores'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['entregadores'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Entregadores</label>
                                                <select class="form-control select2" id="entregadores" name="entregadores" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['entregadores'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['tecnicos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Técnicos</label>
                                                <select class="form-control select2" id="tecnicos" name="tecnicos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['tecnicos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['servico_mao_de_obra'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Serviço/Mão de Obra</label>
                                                <select class="form-control select2" id="servico_mao_de_obra" name="servico_mao_de_obra" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['servico_mao_de_obra'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['transportadoras'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Transportadoras</label>
                                                <select class="form-control select2" id="transportadoras" name="transportadoras" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['transportadoras'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['produtos'] != 0 ||
                                $controle_de_acesso_do_plano['reposicoes'] != 0 ||
                                $controle_de_acesso_do_plano['saida_de_mercadorias'] != 0 ||
                                $controle_de_acesso_do_plano['inventario_do_estoque'] != 0 ||
                                $controle_de_acesso_do_plano['categoria_dos_produtos'] != 0
                            ) : ?>

                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">ESTOQUE</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['produtos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Produtos</label>
                                                <select class="form-control select2" id="produtos" name="produtos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['produtos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['reposicoes'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Reposições</label>
                                                <select class="form-control select2" id="reposicoes" name="reposicoes" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['reposicoes'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['saida_de_mercadorias'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Saída de Mercadorias</label>
                                                <select class="form-control select2" id="saida_de_mercadorias" name="saida_de_mercadorias" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['saida_de_mercadorias'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['inventario_do_estoque'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Inventário do Estoque</label>
                                                <select class="form-control select2" id="inventario_do_estoque" name="inventario_do_estoque" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['inventario_do_estoque'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['categoria_dos_produtos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Categorias do Produto</label>
                                                <select class="form-control select2" id="categoria_dos_produtos" name="categoria_dos_produtos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['categoria_dos_produtos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['caixas'] != 0 ||
                                $controle_de_acesso_do_plano['lancamentos'] != 0 ||
                                $controle_de_acesso_do_plano['retiradas_do_caixa'] != 0 ||
                                $controle_de_acesso_do_plano['despesas'] != 0 ||
                                $controle_de_acesso_do_plano['contas_a_pagar'] != 0 ||
                                $controle_de_acesso_do_plano['contas_a_receber'] != 0 ||
                                $controle_de_acesso_do_plano['relatorio_dre'] != 0
                            ) : ?>

                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">FINANCEIRO</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['caixas'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Caixas</label>
                                                <select class="form-control select2" id="caixas" name="caixas" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['caixas'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['lancamentos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Lançamentos</label>
                                                <select class="form-control select2" id="lancamentos" name="lancamentos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['lancamentos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['retiradas_do_caixa'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Retiradas do Caixa</label>
                                                <select class="form-control select2" id="retiradas_do_caixa" name="retiradas_do_caixa" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['retiradas_do_caixa'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['despesas'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Despesas</label>
                                                <select class="form-control select2" id="despesas" name="despesas" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['despesas'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['contas_a_pagar'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Contas à Pagar</label>
                                                <select class="form-control select2" id="contas_a_pagar" name="contas_a_pagar" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['contas_a_pagar'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['contas_a_receber'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Contas á Receber</label>
                                                <select class="form-control select2" id="contas_a_receber" name="contas_a_receber" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['contas_a_receber'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['relatorio_dre'] == 1) : ?>

                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['nfe'] != 0
                            ) : ?>

                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">CONTROLE FISCAL</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['nfe'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">NFe</label>
                                                <select class="form-control select2" id="nfe" name="nfe" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['nfe'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['nfce'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">NFCe</label>
                                                <select class="form-control select2" id="nfce" name="nfce" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['nfce'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['vendas_historico_completo'] != 0 ||
                                $controle_de_acesso_do_plano['vendas_por_cliente'] != 0 ||
                                $controle_de_acesso_do_plano['vendas_por_vendedor'] != 0 ||
                                $controle_de_acesso_do_plano['estoque_produtos'] != 0 ||
                                $controle_de_acesso_do_plano['estoque_minimo'] != 0 ||
                                $controle_de_acesso_do_plano['estoque_inventario'] != 0 ||
                                $controle_de_acesso_do_plano['estoque_validade_do_produto'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_movimentacao_de_entradas_e_saidas'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_faturamento_diario'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_faturamento_detalhado'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_lancamentos'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_retiradas_do_caixa'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_despesas'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_contas_a_pagar'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_contas_a_receber'] != 0 ||
                                $controle_de_acesso_do_plano['financeiro_dre'] != 0 ||
                                $controle_de_acesso_do_plano['geral_clientes'] != 0 ||
                                $controle_de_acesso_do_plano['geral_fornecedores'] != 0 ||
                                $controle_de_acesso_do_plano['geral_funcionarios'] != 0 ||
                                $controle_de_acesso_do_plano['geral_vendedores'] != 0
                            ) : ?>

                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">RELATÓRIOS</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['vendas_historico_completo'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Histórico Completo</label>
                                                <select class="form-control select2" id="vendas_historico_completo" name="vendas_historico_completo" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['vendas_historico_completo'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['vendas_por_cliente'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Por Cliente</label>
                                                <select class="form-control select2" id="vendas_por_cliente" name="vendas_por_cliente" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['vendas_por_cliente'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['vendas_por_vendedor'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Por Vendedor</label>
                                                <select class="form-control select2" id="vendas_por_vendedor" name="vendas_por_vendedor" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['vendas_por_vendedor'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['vendas_lucro_total'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Lucro Total</label>
                                                <select class="form-control select2" id="vendas_lucro_total" name="vendas_lucro_total" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['vendas_lucro_total'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['estoque_produtos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Produtos</label>
                                                <select class="form-control select2" id="estoque_produtos" name="estoque_produtos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['estoque_produtos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['estoque_minimo'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Estoque Mínimo</label>
                                                <select class="form-control select2" id="estoque_minimo" name="estoque_minimo" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['estoque_minimo'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['estoque_inventario'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Inventário do Estoque</label>
                                                <select class="form-control select2" id="estoque_inventario" name="estoque_inventario" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['estoque_inventario'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['estoque_validade_do_produto'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Validade do Produto</label>
                                                <select class="form-control select2" id="estoque_validade_do_produto" name="estoque_validade_do_produto" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['estoque_validade_do_produto'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_movimentacao_de_entradas_e_saidas'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Mov. Entradas e Saídas</label>
                                                <select class="form-control select2" id="financeiro_movimentacao_de_entradas_e_saidas" name="financeiro_movimentacao_de_entradas_e_saidas" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_movimentacao_de_entradas_e_saidas'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_faturamento_diario'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Faturamento Diário</label>
                                                <select class="form-control select2" id="financeiro_faturamento_diario" name="financeiro_faturamento_diario" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_faturamento_diario'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_faturamento_detalhado'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Faturamento Detalhado</label>
                                                <select class="form-control select2" id="financeiro_faturamento_detalhado" name="financeiro_faturamento_detalhado" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_faturamento_detalhado'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_lancamentos'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Lançamentos</label>
                                                <select class="form-control select2" id="financeiro_lancamentos" name="financeiro_lancamentos" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_lancamentos'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_retiradas_do_caixa'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Retiradas do Caixa</label>
                                                <select class="form-control select2" id="financeiro_retiradas_do_caixa" name="financeiro_retiradas_do_caixa" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_retiradas_do_caixa'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_despesas'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Despesas</label>
                                                <select class="form-control select2" id="financeiro_despesas" name="financeiro_despesas" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_despesas'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_contas_a_pagar'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Contas a Pagar</label>
                                                <select class="form-control select2" id="financeiro_contas_a_pagar" name="financeiro_contas_a_pagar" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_contas_a_pagar'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_contas_a_receber'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Contas a Receber</label>
                                                <select class="form-control select2" id="financeiro_contas_a_receber" name="financeiro_contas_a_receber" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_contas_a_receber'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['financeiro_dre'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">DRE</label>
                                                <select class="form-control select2" id="financeiro_dre" name="financeiro_dre" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['financeiro_dre'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['geral_clientes'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Clientes</label>
                                                <select class="form-control select2" id="geral_clientes" name="geral_clientes" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['geral_clientes'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['geral_fornecedores'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Fornecedores</label>
                                                <select class="form-control select2" id="geral_fornecedores" name="geral_fornecedores" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['geral_fornecedores'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['geral_funcionarios'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Funcionários</label>
                                                <select class="form-control select2" id="geral_funcionarios" name="geral_funcionarios" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['geral_funcionarios'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['geral_vendedores'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Vendedores</label>
                                                <select class="form-control select2" id="geral_vendedores" name="geral_vendedores" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['geral_vendedores'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['agenda'] != 0
                            ) : ?>

                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">AGENDA</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['agenda'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Agenda</label>
                                                <select class="form-control select2" id="agenda" name="agenda" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['agenda'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['usuarios'] != 0 ||
                                $controle_de_acesso_do_plano['config_da_conta'] != 0 ||
                                $controle_de_acesso_do_plano['config_da_empresa'] != 0 ||
                                $controle_de_acesso_do_plano['config_nfe_e_nfce'] != 0
                            ) : ?>

                                <div class="col-lg-3" style="border: 1px solid lightgrey;">
                                    <label style="margin-top: 10px">CONFIGURAÇÕES</label>
                                    
                                    <?php if ($controle_de_acesso_do_plano['usuarios'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Usuários</label>
                                                <select class="form-control select2" id="usuarios" name="usuarios" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['usuarios'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['config_da_conta'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Config. da Conta</label>
                                                <select class="form-control select2" id="config_da_conta" name="config_da_conta" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['config_da_conta'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['config_da_empresa'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Config. da Empresa</label>
                                                <select class="form-control select2" id="config_da_empresa" name="config_da_empresa" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['config_da_empresa'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($controle_de_acesso_do_plano['config_nfe_e_nfce'] == 1) : ?>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="">Config. NFe e NFCe</label>
                                                <select class="form-control select2" id="config_nfe_e_nfce" name="config_nfe_e_nfce" style="width: 100%">
                                                    <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                        <?php if ($controle_de_acesso_do_usuario_selecionado['config_nfe_e_nfce'] == 1) : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php else : ?>
                                                            <option value="1">Sim</option>
                                                            <option value="0" selected>Não</option>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <option value="1" selected>Sim</option>
                                                        <option value="0">Não</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>

                            <?php if (
                                $controle_de_acesso_do_plano['widget_clientes'] != 0 ||
                                $controle_de_acesso_do_plano['widget_produtos'] != 0 ||
                                $controle_de_acesso_do_plano['widget_vendas'] != 0 ||
                                $controle_de_acesso_do_plano['widget_lancamentos'] != 0 ||
                                $controle_de_acesso_do_plano['widget_faturamento'] != 0 ||
                                $controle_de_acesso_do_plano['widget_os'] != 0 ||
                                $controle_de_acesso_do_plano['grafico_faturamento_linha'] != 0 ||
                                $controle_de_acesso_do_plano['grafico_faturamento_barras'] != 0 ||
                                $controle_de_acesso_do_plano['tabela_contas_a_pagar'] != 0 ||
                                $controle_de_acesso_do_plano['tabela_contas_a_receber'] != 0
                            ) : ?>

                                <div class="col-lg-6" style="border: 1px solid lightgrey; background: lightgrey">
                                    <label style="margin-top: 10px">RESUMO DA DASHBOARD/INÍCIO</label>
                                    
                                    <div class="row">

                                        <?php if ($controle_de_acesso_do_plano['widget_clientes'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Widget Clientes</label>
                                                    <select class="form-control select2" id="widget_clientes" name="widget_clientes" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['widget_clientes'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['widget_produtos'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Widget Produtos</label>
                                                    <select class="form-control select2" id="widget_produtos" name="widget_produtos" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['widget_produtos'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['widget_vendas'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Widget Vendas</label>
                                                    <select class="form-control select2" id="widget_vendas" name="widget_vendas" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['widget_vendas'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['widget_lancamentos'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Widget Lançamentos</label>
                                                    <select class="form-control select2" id="widget_lancamentos" name="widget_lancamentos" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['widget_lancamentos'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['widget_faturamento'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Widget Faturamento</label>
                                                    <select class="form-control select2" id="widget_faturamento" name="widget_faturamento" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['widget_faturamento'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['widget_os'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Widget O.S.</label>
                                                    <select class="form-control select2" id="widget_os" name="widget_os" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['widget_os'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['grafico_faturamento_linha'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Gráfico Faturamento Linha</label>
                                                    <select class="form-control select2" id="grafico_faturamento_linha" name="grafico_faturamento_linha" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['grafico_faturamento_linha'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['grafico_faturamento_barras'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Gráfico Faturamento Barra</label>
                                                    <select class="form-control select2" id="grafico_faturamento_barras" name="grafico_faturamento_barras" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['grafico_faturamento_barras'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['tabela_contas_a_pagar'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Tabela Contas a Pagar</label>
                                                    <select class="form-control select2" id="tabela_contas_a_pagar" name="tabela_contas_a_pagar" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['tabela_contas_a_pagar'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($controle_de_acesso_do_plano['tabela_contas_a_receber'] == 1) : ?>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Tabela Contas a Receber</label>
                                                    <select class="form-control select2" id="tabela_contas_a_receber" name="tabela_contas_a_receber" style="width: 100%">
                                                        <?php if (isset($controle_de_acesso_do_usuario_selecionado)) : ?>

                                                            <?php if ($controle_de_acesso_do_usuario_selecionado['tabela_contas_a_receber'] == 1) : ?>
                                                                <option value="1" selected>Sim</option>
                                                                <option value="0">Não</option>
                                                            <?php else : ?>
                                                                <option value="1">Sim</option>
                                                                <option value="0" selected>Não</option>
                                                            <?php endif; ?>

                                                        <?php else : ?>
                                                            <option value="1" selected>Sim</option>
                                                            <option value="0">Não</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                    </div>

                                </div>

                            <?php endif; ?>

                        </div>
                    </div>

                    <?php if (isset($usuario) && isset($controle_de_acesso_do_usuario_selecionado)) : ?>
                        <input type="hidden" name="id_login" value="<?= $usuario['id_login'] ?>">
                        <input type="hidden" name="id_controle_de_acesso" value="<?= $controle_de_acesso_do_usuario_selecionado['id_controle_de_acesso'] ?>">
                    <?php endif; ?>

                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12" style="text-align: right">
                                <button type="submit" class="btn btn-primary"><?= (isset($usuario)) ? "Atualizar" : "Cadastrar" ?></button>
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
    function verificaNomeDeUsuario() {
        var doc, usuario;

        doc = document.getElementById('usuario');
        usuario = doc.value;

        // Regra de validação para form create/edit
        if (usuario != "<?= (isset($usuario)) ? $usuario['usuario'] : '' ?>") {
            $.post(
                "/login/verificaNomeDeUsuario", {
                    usuario: usuario
                },
                function(data, status) {
                    if (status == "success") {
                        if (data == "1") {
                            alert('Esse usuário não pode ser cadastrado. Por favor, escolha outro.');
                            doc.value = "";
                            doc.focus();
                        }
                    }
                }
            );
        }

    }
</script>