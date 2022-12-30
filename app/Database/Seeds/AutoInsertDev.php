<?php

namespace App\Database\Seeds;

class AutoInsertDev extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        // // Para Desenvolvimento
        // Cadastra UFs
        $codigos_uf = ['17'];
        $nomes_ufs = ['Tocantins'];
        $ufs = ['TO'];

        $i = 0;
        foreach($codigos_uf as $codigo) :
            $this->db->table('ufs')->insert([
                'id_uf'     => $codigo,
                'codigo_uf' => $codigo,
                'estado'    => $nomes_ufs[$i],
                'uf'        => $ufs[$i]
            ]);

            $i++;
        endforeach;


        // ------------------------------------------------------------------------------------------------------------------------ //
        // Para Desenvolvimento
        $codigos_municipios = [
            '1721000',
        ];

        $municipios = [
            'Palmas',
        ];

        $ids = [
            '17',
        ];

        $i = 0;
        foreach($ids as $id) :
            $this->db->table('municipios')->insert([
                'codigo'    => $codigos_municipios[$i],
                'municipio' => mb_strtoupper($municipios[$i], 'UTF-8'),
                'id_uf'     => $id
            ]);

            $i++;
        endforeach;

        // --------------------------------------------------------------------- //

        $this->db->table('login')->insert([
            'usuario'              => 'admin',
            'senha'                => '123',
            'tipo'                 => 1,
            'esse_usuario_e_admin' => 0,
            'id_empresa'           => 0,
        ]);

        $formas = [
            [
                'nome' => "Dinheiro",
                'codigo' => "01",
            ],
            [
                'nome' => "Cheque",
                'codigo' => "02",
            ],
            [
                'nome' => "Cartão de Crédito",
                'codigo' => "03",
            ],
            [
                'nome' => "Cartão de Débito",
                'codigo' => "04",
            ],
            [
                'nome' => "Crédito Loja",
                'codigo' => "05",
            ],
            [
                'nome' => "Vale Alimentação",
                'codigo' => "10",
            ],
            [
                'nome' => "Vale Refeição",
                'codigo' => "11",
            ],
            [
                'nome' => "Vale Presente",
                'codigo' => "12",
            ],
            [
                'nome' => "Vale Combustível",
                'codigo' => "13",
            ],
            [
                'nome' => "Depósito Bancário",
                'codigo' => "16",
            ],
            [
                'nome' => "Pagamento Instantâneo (PIX)",
                'codigo' => "17",
            ],
            [
                'nome' => "Transferência bancária",
                'codigo' => "18",
            ],
            [
                'nome' => "Carteira Digital",
                'codigo' => "18",
            ],
            [
                'nome' => "Programa de fidelidade",
                'codigo' => "19",
            ],
            [
                'nome' => "Cashback",
                'codigo' => "19",
            ],
            [
                'nome' => "Crédito Virtual",
                'codigo' => "19",
            ],
            [
                'nome' => "Outros",
                'codigo' => "99",
            ],
        ];

        foreach($formas as $forma):

            $this->db->table('formas_de_pagamento')
                ->insert([
                    'nome' => $forma['nome'],
                    'codigo' => $forma['codigo']
                ]);
                
        endforeach;

        $this->db->table('configuracoes')->insert([
            'nome_do_app' => 'Nome do App',
            'tema'        => '4',
            'xNome'       => 'NxGestão Sistema de Gestão',
            'xFant'       => 'NxGestão',
            'CNPJ'        => '0000000000000',
            'telefone'    => '69999342343',
            'endereco'    => 'Rua das Dores, Quadra 09 Lote 23'
        ]);

        $this->db->table('configuracoes_api_boletos')->insert([
            'id_config'            => 1,
            'clientId'             => "ksfk492wQzySNRQE",
            'clientSecret'         => "S(0lGMiu^D<rw<c|*=AhK)hXBJ6hHh,C",
            'token_privado'        => "79E027C7065F33EE91666B3AE8F6172E60D1A6DC3B5B79F7698D96E7446F8F75",
            'authorization_server' => "https://sandbox.boletobancario.com/authorization-server/oauth/token",
            'api_integration'      => "https://sandbox.boletobancario.com/api-integration/charges"
        ]);


        $this->db->table('planos')->insert([
            'nome' => "Plano Básico",
            'valor' => 119.90,
            'duracao' => 30,
            'observacoes' => "",
        ]);

        $this->db->table('controle_de_acesso')->insert([
            'venda_rapida' => 1,
            'pdv' => 1,
            'pesquisa_produto' => 1,
            'historico_de_vendas' => 1,
            'orcamentos' => 1,
            'pedidos' => 1,
            'ordem_de_servico' => 1,
            'laboratorio' => 1,
            'novo_pedido' => 1,
            'mesas' => 1,
            'entregas' => 1,
            'abrir_painel' => 1,
            'transmitir_no_painel' => 1,
            'configs' => 1,
            'clientes' => 1,
            'fornecedores' => 1,
            'funcionarios' => 1,
            'vendedores' => 1,
            'entregadores' => 1,
            'tecnicos' => 1,
            'servico_mao_de_obra' => 1,
            'transportadoras' => 1,
            'produtos' => 1,
            'reposicoes' => 1,
            'saida_de_mercadorias' => 1,
            'inventario_do_estoque' => 1,
            'categoria_dos_produtos' => 1,
            'caixas' => 1,
            'lancamentos' => 1,
            'retiradas_do_caixa' => 1,
            'despesas' => 1,
            'contas_a_pagar' => 1,
            'contas_a_receber' => 1,
            'relatorio_dre' => 1,
            'nfe' => 1,
            'nfce' => 1,
            'vendas_historico_completo' => 1,
            'vendas_por_cliente' => 1,
            'vendas_por_vendedor' => 1,
            'vendas_lucro_total' => 1,
            'estoque_produtos' => 1,
            'estoque_minimo' => 1,
            'estoque_inventario' => 1,
            'estoque_validade_do_produto' => 1,
            'financeiro_movimentacao_de_entradas_e_saidas' => 1,
            'financeiro_faturamento_diario' => 1,
            'financeiro_faturamento_detalhado' => 1,
            'financeiro_lancamentos' => 1,
            'financeiro_retiradas_do_caixa' => 1,
            'financeiro_despesas' => 1,
            'financeiro_contas_a_pagar' => 1,
            'financeiro_contas_a_receber' => 1,
            'financeiro_dre' => 1,
            'geral_clientes' => 1,
            'geral_fornecedores' => 1,
            'geral_funcionarios' => 1,
            'geral_vendedores' => 1,
            'agenda' => 1,
            'usuarios' => 1,
            'config_da_conta' => 1,
            'config_da_empresa' => 1,
            'config_nfe_e_nfce' => 1,
            'widget_clientes' => 1,
            'widget_produtos' => 1,
            'widget_vendas' => 1,
            'widget_lancamentos' => 1,
            'widget_faturamento' => 1,
            'widget_os' => 1,
            'grafico_faturamento_linha' => 1,
            'grafico_faturamento_barras' => 1,
            'tabela_contas_a_pagar' => 1,
            'tabela_contas_a_receber' => 1,
            'id_plano' => 1,
        ]);

        $this->db->table('empresas')->insert([
            'status' => "Ativo",
            'CNPJ' => "34229323000173",
            'xNome' => "PEDRO ARLINDO DE MOURA JUNIOR 01758528125",
            'xFant' => "NxSistemas",
            'IE' => "",
            'logomarca' => "",
            'CEP' => "77060443",
            'xLgr' => "SALA 1",
            'nro' => "83",
            'xCpl' => "AVENIDA CONTORNO",
            'xBairro' => "SANTA BARBARA",
            'fone' => "63984465398",

            'id_uf' => 17,
            'id_municipio' => 1,
            'id_plano' => 1
        ]);

        $this->db->table('login')->insert([
            'usuario' => "empresa",
            'senha' => "123",
            'tipo' => 2,
            'esse_usuario_e_admin' => 0,
            'id_empresa' => 1,
        ]);

        $this->db->table('controle_de_acesso_do_usuario')->insert([
            'venda_rapida' => 1,
            'pdv' => 1,
            'pesquisa_produto' => 1,
            'historico_de_vendas' => 1,
            'orcamentos' => 1,
            'pedidos' => 1,
            'ordem_de_servico' => 1,
            'laboratorio' => 1,
            'novo_pedido' => 1,
            'mesas' => 1,
            'entregas' => 1,
            'abrir_painel' => 1,
            'transmitir_no_painel' => 1,
            'configs' => 1,
            'clientes' => 1,
            'fornecedores' => 1,
            'funcionarios' => 1,
            'vendedores' => 1,
            'entregadores' => 1,
            'tecnicos' => 1,
            'servico_mao_de_obra' => 1,
            'transportadoras' => 1,
            'produtos' => 1,
            'reposicoes' => 1,
            'saida_de_mercadorias' => 1,
            'inventario_do_estoque' => 1,
            'categoria_dos_produtos' => 1,
            'caixas' => 1,
            'lancamentos' => 1,
            'retiradas_do_caixa' => 1,
            'despesas' => 1,
            'contas_a_pagar' => 1,
            'contas_a_receber' => 1,
            'relatorio_dre' => 1,
            'nfe' => 1,
            'nfce' => 1,
            'vendas_historico_completo' => 1,
            'vendas_por_cliente' => 1,
            'vendas_por_vendedor' => 1,
            'vendas_lucro_total' => 1,
            'estoque_produtos' => 1,
            'estoque_minimo' => 1,
            'estoque_inventario' => 1,
            'estoque_validade_do_produto' => 1,
            'financeiro_movimentacao_de_entradas_e_saidas' => 1,
            'financeiro_faturamento_diario' => 1,
            'financeiro_faturamento_detalhado' => 1,
            'financeiro_lancamentos' => 1,
            'financeiro_retiradas_do_caixa' => 1,
            'financeiro_despesas' => 1,
            'financeiro_contas_a_pagar' => 1,
            'financeiro_contas_a_receber' => 1,
            'financeiro_dre' => 1,
            'geral_clientes' => 1,
            'geral_fornecedores' => 1,
            'geral_funcionarios' => 1,
            'geral_vendedores' => 1,
            'agenda' => 1,
            'usuarios' => 1,
            'config_da_conta' => 1,
            'config_da_empresa' => 1,
            'config_nfe_e_nfce' => 1,
            'widget_clientes' => 1,
            'widget_produtos' => 1,
            'widget_vendas' => 1,
            'widget_lancamentos' => 1,
            'widget_faturamento' => 1,
            'widget_os' => 1,
            'grafico_faturamento_linha' => 1,
            'grafico_faturamento_barras' => 1,
            'tabela_contas_a_pagar' => 1,
            'tabela_contas_a_receber' => 1,
            'id_empresa' => 1,
            'id_login' => 2,
        ]);

        $this->db->table('categorias_dos_produtos')->insert([
            'nome' => "Nenhuma",
            'descricao' => "",
            'id_empresa' => 1,
        ]);

        $this->db->table('fornecedores')->insert([
            'nome_do_representante' => "FORNCEDOR GERAL",
            'nome_da_empresa' => "",
            'cnpj' => "",
            'ie' => "",
            'cep' => "",
            'logradouro' => "",
            'numero' => "",
            'complemento' => "",
            'bairro' => "",
            'comercial' => "",
            'celular_1' => "",
            'celular_2' => "",
            'email' => "",
            'id_uf' => 17,
            'id_municipio' => 1,
            'id_empresa' => 1,
        ]);
    }
}
