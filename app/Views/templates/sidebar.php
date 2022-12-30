<!-- Main Sidebar Container -->
<?php if ($session->get('tema') == 1) : ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php elseif ($session->get('tema') == 2) : ?>
        <aside class="main-sidebar elevation-4 sidebar-light-info">
        <?php elseif ($session->get('tema') == 3) : ?>
            <aside class="main-sidebar elevation-4 sidebar-dark-danger">
            <?php elseif ($session->get('tema') == 4) : ?>
                <aside class="main-sidebar elevation-4 sidebar-light-info">
                <?php endif; ?>
                <!-- Brand Logo -->
                <?php if ($session->get('tema') == 1) : ?>
                    <a href="#" class="brand-link" style="text-align: center; font-weight: bold; padding: 4px;">
                    <?php elseif ($session->get('tema') == 2) : ?>
                        <a href="#" class="brand-link" style="text-align: center; font-weight: bold; padding: 4px">
                        <?php elseif ($session->get('tema') == 3) : ?>
                            <a href="#" class="brand-link navbar-danger" style="text-align: center; font-weight: bold; padding: 4px">
                            <?php elseif ($session->get('tema') == 4) : ?>
                                <a href="#" class="brand-link navbar-info" style="text-align: center; font-weight: bold; padding: 4px">
                                <?php endif; ?>
                                <span style="font-size: 26px; <?= ($session->get('tema') == 4) ? "color: white" : "" ?>"><?= $session->get('xApp') ?></span>
                                </a>

                                <!-- Sidebar -->
                                <div class="sidebar">
                                    <!-- Sidebar user panel (optional) -->
                                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                        <img src="<?= base_url('assets/img/logomarcas') ?>/<?= ($session->get('logomarca') != "") ? $session->get('logomarca') : "logo-marca.png" ?>" style="width: 50%; margin: auto; border-radius: 15%" alt="Logo Marca da Empresa">
                                    </div>

                                    <!-- Sidebar Menu -->
                                    <nav class="mt-2" style="margin-bottom: 140px;">
                                        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                                            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

                                            <!-- <li class="nav-header"></li> -->

                                            <?php if ($session->get('tipo') == 1) : ?>

                                                <li class="nav-item">
                                                    <a id="1" href="/admin/inicio" class="nav-link">
                                                        <i class="nav-icon fas fa-home"></i>
                                                        <p>Inicio</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a id="2" href="/empresas" class="nav-link">
                                                        <i class="nav-icon fas fa-user"></i>
                                                        <p>Empresas</p>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a id="3" href="/boletos" class="nav-link">
                                                        <i class="nav-icon fas fa-barcode"></i>
                                                        <p>Boletos</p>
                                                    </a>
                                                </li>

                                                <li id="4.x" class="nav-item has-treeview">
                                                    <a id="4.0" href="#" class="nav-link">
                                                        <i class="nav-icon fas fa-file-pdf"></i>
                                                        <p>
                                                            Relatórios
                                                            <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <li class="nav-item">
                                                            <a id="4.1" href="/admin/relatorioRelacaoDeEmpresas" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Relação de Empresas</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="4.2" href="/admin/relatorioEmpresasAtivas" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Empresas Ativas</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="4.3" href="/admin/relatorioEmpresasDesativadas" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Empresas Desativadas</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="4.4" href="/admin/relatorioFaturamentoPorPeriodoDetalhado" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Futuramento Detalhado</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="4.5" href="/admin/relatorioVencimentoDeContrato" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Vencimento de Contrato</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

                                                <li class="nav-item">
                                                    <a id="6" href="/planos" class="nav-link">
                                                        <i class="nav-icon fas fa-list"></i>
                                                        <p>Planos</p>
                                                    </a>
                                                </li>

                                                <li id="5.x" class="nav-item has-treeview">
                                                    <a id="5.0" href="#" class="nav-link">
                                                        <i class="nav-icon fas fa-cog"></i>
                                                        <p>
                                                            Configurações
                                                            <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <li class="nav-item">
                                                            <a id="5.1" href="/configuracoes/edit" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Empresa</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="5.2" href="/configuracoes/editLogin" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Login</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="5.3" href="/boletos/configuracoesAPI" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>API - Boletos</p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a id="5.4" href="/formasDePagamento" class="nav-link">
                                                                <i class="far fa-circle nav-icon"></i>
                                                                <p>Formas de Pagamentos</p>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

                                            <?php else : ?>

                                                <li class="nav-item">
                                                    <a id="1" href="/inicio" class="nav-link">
                                                        <i class="nav-icon fas fa-home"></i>
                                                        <p>Inicio</p>
                                                    </a>
                                                </li>

                                                <?php if (
                                                    $controle_de_acesso['clientes'] != 0 ||
                                                    $controle_de_acesso['fornecedores'] != 0 ||
                                                    $controle_de_acesso['funcionarios'] != 0 ||
                                                    $controle_de_acesso['vendedores'] != 0 ||
                                                    $controle_de_acesso['entregadores'] != 0 ||
                                                    $controle_de_acesso['tecnicos'] != 0 ||
                                                    $controle_de_acesso['servico_mao_de_obra'] != 0 ||
                                                    $controle_de_acesso['transportadoras'] != 0 ||

                                                    $controle_de_acesso['produtos'] != 0
                                                ) :
                                                ?>
                                                    <li id="5.x" class="nav-item has-treeview">
                                                        <a id="5.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-plus-circle"></i>
                                                            <p>
                                                                Cadastros
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">

                                                            <?php if (
                                                                // Verifica se a parte de cadastro de clientes estão todos habilitados
                                                                // para mostrar o divisor Pessoas
                                                                $controle_de_acesso['clientes'] != 0 ||
                                                                $controle_de_acesso['fornecedores'] != 0 ||
                                                                $controle_de_acesso['funcionarios'] != 0 ||
                                                                $controle_de_acesso['vendedores'] != 0 ||
                                                                $controle_de_acesso['entregadores'] != 0 ||
                                                                $controle_de_acesso['tecnicos'] != 0 ||
                                                                $controle_de_acesso['servico_mao_de_obra'] != 0 ||
                                                                $controle_de_acesso['transportadoras'] != 0
                                                            ) : ?>

                                                                <li class="nav-item">
                                                                    <a id="#" href="#" class="nav-link">
                                                                        <p><b>Pessoas</b></p>
                                                                    </a>
                                                                </li>

                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['clientes'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.1" href="/clientes" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Clientes</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['fornecedores'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.2" href="/fornecedores" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Fornecedores</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['funcionarios'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.3" href="/funcionarios" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Funcionários</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['vendedores'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.4" href="/vendedores" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Vendedores</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['entregadores'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.5" href="/entregadores" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Entregadores</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['tecnicos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.6" href="/tecnicos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Técnicos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['servico_mao_de_obra'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.7" href="/servicosMaoDeObra" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Serviço/Mão de Obra</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['transportadoras'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="5.8" href="/transportadoras" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Transportadoras</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if (
                                                                // Verifica se a parte de cadastro de produtos estão todos habilitados
                                                                // para mostrar o divisor Estoque
                                                                $controle_de_acesso['produtos'] != 0
                                                            ) : ?>

                                                                <li class="nav-item">
                                                                    <a id="#" href="#" class="nav-link">
                                                                        <p><b>Estoque</b></p>
                                                                    </a>
                                                                </li>

                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['produtos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="6.1" href="/produtos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Produtos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (
                                                    $controle_de_acesso['venda_rapida'] != 0 ||
                                                    $controle_de_acesso['pesquisa_produto'] != 0 ||
                                                    $controle_de_acesso['historico_de_vendas'] != 0 ||
                                                    $controle_de_acesso['orcamentos'] != 0 ||
                                                    $controle_de_acesso['pedidos'] != 0
                                                ) :
                                                ?>
                                                    <li id="2.x" class="nav-item has-treeview">
                                                        <a id="2.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-shopping-cart"></i>
                                                            <p>
                                                                Vendas
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">
                                                            <?php if ($controle_de_acesso['venda_rapida'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="2.1" href="/vendaRapida" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Venda Rápida</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <li class="nav-item">
                                                                <a id="2.6" href="/pdv" class="nav-link">
                                                                    <i class="far fa-circle nav-icon"></i>
                                                                    <p>PDV - Ponto de Vendas</p>
                                                                </a>
                                                            </li>

                                                            <?php if ($controle_de_acesso['pesquisa_produto'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="2.2" href="/produtos/pesquisar" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Pesq. Produto</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['historico_de_vendas'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="2.3" href="/vendas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Hist. de Vendas</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['orcamentos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="2.4" href="/orcamentos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Orçamentos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['pedidos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="2.5" href="/pedidos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Pedidos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if ($controle_de_acesso['ordem_de_servico'] == 1) : ?>
                                                    <li class="nav-item">
                                                        <a id="3" href="/ordemDeServico" class="nav-link">
                                                            <i class="nav-icon fas fa-clipboard"></i>
                                                            <p>Ordem de Serviço</p>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if ($controle_de_acesso['laboratorio'] == 1) : ?>
                                                    <li class="nav-item">
                                                        <a id="13" href="/laboratorio" class="nav-link">
                                                            <i class="nav-icon fas fa-hotel"></i>
                                                            <p>Laboratório</p>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (
                                                    $controle_de_acesso['novo_pedido'] != 0 ||
                                                    $controle_de_acesso['mesas'] != 0 ||
                                                    $controle_de_acesso['entregas'] != 0 ||
                                                    $controle_de_acesso['abrir_painel'] != 0 ||
                                                    $controle_de_acesso['transmitir_no_painel'] != 0 ||
                                                    $controle_de_acesso['configs'] != 0
                                                ) :
                                                ?>
                                                    <li id="4.x" class="nav-item has-treeview">
                                                        <a id="4.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-pizza-slice"></i>
                                                            <p>
                                                                Food
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">
                                                            <?php if ($controle_de_acesso['novo_pedido'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="4.1" href="/food/selecionarMesa" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Novo Pedido</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['mesas'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="4.2" href="/food/mesas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Mesas</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['entregas'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="4.3" href="/food/entregas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Entregas</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['abrir_painel'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a href="/painel" target="_blank" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Abrir Painel</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['transmitir_no_painel'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="4.6" href="/painel/transmitir" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Transmitir no Painel</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['configs'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="4.4" href="/food/configs" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Configs</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (
                                                    $controle_de_acesso['reposicoes'] != 0 ||
                                                    $controle_de_acesso['saida_de_mercadorias'] != 0 ||
                                                    $controle_de_acesso['inventario_do_estoque'] != 0 ||
                                                    $controle_de_acesso['categoria_dos_produtos'] != 0
                                                ) :
                                                ?>
                                                    <li id="6.x" class="nav-item has-treeview">
                                                        <a id="6.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-box-open"></i>
                                                            <p>
                                                                Estoque
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">

                                                            <?php if ($controle_de_acesso['reposicoes'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="6.2" href="/reposicoes" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Reposições</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['saida_de_mercadorias'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="6.3" href="/saidaDeMercadorias" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Saída de Mercadorias</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['inventario_do_estoque'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="6.4" href="/inventarioDoEstoque" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Inventário do Estoque</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['categoria_dos_produtos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="6.5" href="/categoriasDosProdutos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Categoria dos Produtos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (
                                                    $controle_de_acesso['caixas'] != 0 ||
                                                    $controle_de_acesso['lancamentos'] != 0 ||
                                                    $controle_de_acesso['retiradas_do_caixa'] != 0 ||
                                                    $controle_de_acesso['despesas'] != 0 ||
                                                    $controle_de_acesso['contas_a_pagar'] != 0 ||
                                                    $controle_de_acesso['contas_a_receber'] != 0 ||
                                                    $controle_de_acesso['relatorio_dre'] != 0
                                                ) :
                                                ?>
                                                    <li id="7.x" class="nav-item has-treeview">
                                                        <a id="7.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                                                            <p>
                                                                Financeiro
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">
                                                            <?php if ($controle_de_acesso['caixas'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="7.1" href="/caixas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Caixas</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['lancamentos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="7.2" href="/lancamentos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Lançamentos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['retiradas_do_caixa'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="7.3" href="/retiradas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Retiradas do Caixa</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['despesas'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="7.4" href="/despesas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Despesas</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['contas_a_pagar'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="7.5" href="/contasPagar" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Contas a Pagar</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['contas_a_receber'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="7.6" href="/contasReceber" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Contas a Receber</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['relatorio_dre'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="7.7" href="/relatorioDRE" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Relatório DRE</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (
                                                    $controle_de_acesso['nfe'] != 0 ||
                                                    $controle_de_acesso['nfce'] != 0
                                                ) :
                                                ?>
                                                    <li id="9.x" class="nav-item has-treeview">
                                                        <a id="9.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-code"></i>
                                                            <p>
                                                                Controle Fiscal
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">
                                                            <li class="nav-item">
                                                                <a id="9.1" href="/NFeAvulsa/entrada" class="nav-link">
                                                                    <i class="far fa-circle nav-icon"></i>
                                                                    <p>NFe Entrada Avulsa</p>
                                                                </a>
                                                            </li>

                                                            <li class="nav-item">
                                                                <a id="9.2" href="/NFeAvulsa/saida" class="nav-link">
                                                                    <i class="far fa-circle nav-icon"></i>
                                                                    <p>NFe Saída Avulsa</p>
                                                                </a>
                                                            </li>

                                                            <li class="nav-item">
                                                                <a id="9.3" href="/NFeAvulsa/devolucao" class="nav-link">
                                                                    <i class="far fa-circle nav-icon"></i>
                                                                    <p>NFe Devolução Avulsa</p>
                                                                </a>
                                                            </li>
                                                            <?php if ($controle_de_acesso['nfe'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="9.4" href="/controleFiscal/nfe" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Gerenciar NFe</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['nfce'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="9.5" href="/controleFiscal/nfce" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Gerenciar NFCe</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <li class="nav-item">
                                                                <a id="9.6" href="/controleFiscal/relatorioMonofasico" class="nav-link">
                                                                    <i class="far fa-circle nav-icon"></i>
                                                                    <p>Relatório Monofásico</p>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if (
                                                    $controle_de_acesso['vendas_historico_completo'] != 0 ||
                                                    $controle_de_acesso['vendas_por_cliente'] != 0 ||
                                                    $controle_de_acesso['vendas_por_vendedor'] != 0 ||
                                                    $controle_de_acesso['vendas_lucro_total'] != 0 ||
                                                    $controle_de_acesso['estoque_produtos'] != 0 ||
                                                    $controle_de_acesso['estoque_minimo'] != 0 ||
                                                    $controle_de_acesso['estoque_inventario'] != 0 ||
                                                    $controle_de_acesso['estoque_validade_do_produto'] != 0 ||
                                                    $controle_de_acesso['financeiro_movimentacao_de_entradas_e_saidas'] != 0 ||
                                                    $controle_de_acesso['financeiro_faturamento_diario'] != 0 ||
                                                    $controle_de_acesso['financeiro_faturamento_detalhado'] != 0 ||
                                                    $controle_de_acesso['financeiro_lancamentos'] != 0 ||
                                                    $controle_de_acesso['financeiro_retiradas_do_caixa'] != 0 ||
                                                    $controle_de_acesso['financeiro_despesas'] != 0 ||
                                                    $controle_de_acesso['financeiro_contas_a_pagar'] != 0 ||
                                                    $controle_de_acesso['financeiro_contas_a_receber'] != 0 ||
                                                    $controle_de_acesso['financeiro_dre'] != 0 ||
                                                    $controle_de_acesso['geral_clientes'] != 0 ||
                                                    $controle_de_acesso['geral_fornecedores'] != 0 ||
                                                    $controle_de_acesso['geral_funcionarios'] != 0 ||
                                                    $controle_de_acesso['geral_vendedores'] != 0
                                                ) :
                                                ?>
                                                    <li id="10.x" class="nav-item has-treeview">
                                                        <a id="10.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-file-pdf"></i>
                                                            <p>
                                                                Relatórios
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">
                                                            <?php if ($controle_de_acesso['vendas_historico_completo'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1" href="/relatorios/historicoCompleto" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Vendas: Hist. Completo</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['vendas_por_cliente'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.2" href="/relatorios/porCliente" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Vendas: Por Cliente</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['vendas_por_vendedor'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.3" href="/relatorios/porVendedor" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Vendas: Por Vendedor</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['vendas_lucro_total'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="11.1" href="/relatorios/lucroDasVendas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Vendas: Lucro Total</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['estoque_produtos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.4" href="/relatorios/produtos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Estoque: Produtos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['estoque_minimo'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.5" href="/relatorios/estoqueMinimo" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Estoque: Estoque Mínimo</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['estoque_inventario'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a href="/inventarioDoEstoque" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Estoque: Inventário</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['estoque_validade_do_produto'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.7" href="/relatorios/validadeDosProdutos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Estoque: Validade de Produtos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_movimentacao_de_entradas_e_saidas'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.8" href="/relatorios/entradasSaidasGeral" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Mov. Entradas e Saídas</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_faturamento_diario'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.9" href="/relatorios/faturamentoDiario" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Faturamento Diário</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_faturamento_detalhado'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.0" href="/relatorios/faturamentoDetalhado" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Faturamento Detalhado</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_lancamentos'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.1" href="/relatorios/lancamentos" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Lançamentos</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_retiradas_do_caixa'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.2" href="/relatorios/retiradasDoCaixa" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Retiradas do Caixa</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_despesas'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.3" href="/relatorios/despesas" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Despesas</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_contas_a_pagar'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.4" href="/relatorios/contasPagar" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Contas a Pagar</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_contas_a_receber'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.5" href="/relatorios/contasReceber" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: Contas a Receber</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['financeiro_dre'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.6" href="/relatorioDRE" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Financeiro: DRE</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['geral_clientes'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.7" href="/relatorios/clientes" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Geral: Clientes</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['geral_fornecedores'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.8" href="/relatorios/fornecedores" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Geral: Fornecedores</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['geral_funcionarios'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.1.9" href="/relatorios/funcionarios" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Geral: Funcionários</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['geral_vendedores'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="10.2.0" href="/relatorios/vendedores" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Geral: Vendedores</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if ($controle_de_acesso['agenda'] == 1) : ?>
                                                    <li class="nav-item">
                                                        <a id="11" href="/agenda" class="nav-link">
                                                            <i class="nav-icon fas fa-calendar-alt"></i>
                                                            <p>Agenda</p>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php foreach ($links_adicionais as $link) : ?>
                                                    <li class="nav-item">
                                                        <a href="<?= $link['link'] ?>" <?= ($link['tipo'] == 2) ? 'target="_blank"' : "" ?> class="nav-link">
                                                            <i class="nav-icon fas <?= $link['icone'] ?>"></i>
                                                            <p><?= $link['descricao'] ?></p>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>

                                                <?php if (
                                                    $controle_de_acesso['usuarios'] != 0 ||
                                                    $controle_de_acesso['config_da_conta'] != 0 ||
                                                    $controle_de_acesso['config_da_empresa'] != 0 ||
                                                    $controle_de_acesso['config_nfe_e_nfce'] != 0
                                                ) :
                                                ?>
                                                    <li id="12.x" class="nav-item has-treeview">
                                                        <a id="12.0" href="#" class="nav-link">
                                                            <i class="nav-icon fas fa-cog"></i>
                                                            <p>
                                                                Configurações
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">
                                                            <?php if ($controle_de_acesso['usuarios'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="12.1" href="/login/usuarios" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Usuários</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['config_da_conta'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="12.2" href="/configDaConta/edit" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Config. da Conta</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['config_da_empresa'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="12.3" href="/configDaEmpresa/edit" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Config. da Empresa</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                            <?php if ($controle_de_acesso['config_nfe_e_nfce'] == 1) : ?>
                                                                <li class="nav-item">
                                                                    <a id="12.4" href="/configNFeNFCe/edit" class="nav-link">
                                                                        <i class="far fa-circle nav-icon"></i>
                                                                        <p>Config. NFe/NFCe</p>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>

                                                        </ul>
                                                    </li>
                                                <?php endif; ?>

                                            <?php endif; ?>

                                        </ul>
                                    </nav>
                                    <!-- /.sidebar-menu -->
                                </div>
                                <!-- /.sidebar -->
                </aside>