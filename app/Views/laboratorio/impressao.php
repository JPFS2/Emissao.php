<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha da Caixa: <?= $ordem['caixa'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
</head>

<body>

    <div class="container-fluid" style="border: 1px solid black">
        <div class="row">
            <div class="col-lg-12">
                <?php if ($empresa['logomarca'] == "") : ?>
                    <img src="<?= base_url("assets/img/logomarcas/logo-marca.png") ?>" style="width: 90px; margin-top: 5px; padding-bottom: 5px">
                <?php else : ?>
                    <img src="<?= base_url("assets/img/logomarcas/{$empresa['logomarca']}") ?>" style="width: 90px; margin-top: 5px; padding-bottom: 5px">
                <?php endif; ?>

                <span><?= $empresa['xFant'] ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-8" style="border: 1px solid black">
                <div style="margin-top: 15px; margin-bottom: 15px">
                    <h6>DADOS DO CLIENTE:</h6>
                    <b>Nome:</b> <?= ($ordem['tipo'] == 1) ? $ordem['nome'] : $ordem['razao_social'] ?> <br>
                    <b>Endereço:</b> <?= $ordem['logradouro'] ?>, <?= $ordem['numero'] ?>, <?= $ordem['complemento'] ?> - <?= $ordem['bairro'] ?>. CEP: <?= $ordem['cep'] ?> <br>
                    <b>Fixo:</b> <?= ($ordem['fixo'] != "") ? $ordem['fixo'] : "S/N" ?> - <b>Cel 1:</b> <?= ($ordem['celular_1'] != "") ? $ordem['celular_1'] : "S/N" ?> - <b>Cel 2:</b> <?= ($ordem['celular_2'] != "") ? $ordem['celular_2'] : "S/N" ?>
                </div>
            </div>
            <div class="col-4" style="border: 1px solid black">
                <div style="margin-top: 15px">
                    <h6>DATAS:</h6>
                    <b>Entrada:</b> <?= date('d/m/Y', strtotime($ordem['data_de_entrada'])) ?> <br>
                    <b>Previsão:</b> <?= date('d/m/Y', strtotime($ordem['data_prevista'])) ?>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 15px">
            <div class="col-7">
                <h6>SERVIÇOS:</h6>
                <table width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($servicos as $servico) : ?>
                            <tr>
                                <td><?= $servico['nome'] ?></td>
                                <td><?= $servico['detalhes'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-5">
                <h6>DENTES:</h6>
                <b>Maxilar:</b> <?= $ordem['dentes_do_maxilar'] ?><br>
                <b>Mandibula:</b> <?= $ordem['dentes_da_mandibula'] ?>
            </div>
        </div>
        <div class="row" style="margin-top: 15px">
            <div class="col-12">
                <h6>OBSERVAÇÕES:</h6>
                <?= $ordem['observacoes'] ?>
            </div>
        </div>
        <div class="row" style="margin-top: 15px">
            <div class="col-12">
                <h6 style="text-align: center">CAIXA: <?= $ordem['caixa'] ?></h6>
            </div>
        </div>
        <div class="row" style="margin-top: 15px; padding-top: 20px; border: 1px dotted black">
            <div class="col-6">
                <h6>Entregador: <?= (isset($entregador)) ? $entregador['nome'] : "Não cadastrado!" ?></h6>
            </div>
            <div class="col-6">
                <h6>Assinatura:</h6>
            </div>
        </div>
    </div>

    <script>
        print();
    </script>

</body>

</html>