<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <title>Login - Ativo Media</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,700&amp;display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') ?>">

    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('theme/plugins/toastr/toastr.min.css') ?>">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

        * {
            box-sizing: border-box;
        }

        body {
            background: #fff url(<?= base_url('assets/img/bg-login.png') ?>) no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            height: 100vh;
            margin: -20px 0 50px;
        }

        h1 {
            font-weight: bold;
            margin: 0;
        }

        h2 {
            text-align: center;
        }

        p {
            font-size: 15px;
            font-weight: 600;
            line-height: 20px;
            letter-spacing: 0px;
            margin: 30px 0 20px;
        }

        span {
            font-size: 12px;
        }

        a {
            color: #333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
        }

        button {
            border-radius: 20px;
            border: 1px solid #000814;
            background-color: #000814;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
        }

        button:active {
            transform: scale(0.95);
        }

        button:focus {
            outline: none;
        }

        button.ghost {
            background-color: transparent;
            border-color: #FFFFFF;
        }

        form {
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        input {
            /* background-color: #ededed; */
            border: 1px solid lightgray;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
            border-radius: 3px;
            font-size: 15px;
            color: grey;
            height: 50px
        }

        input:focus {
            outline: none;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
                0 10px 10px rgba(0, 0, 0, 0.22);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {

            0%,
            49.99% {
                opacity: 0;
                z-index: 1;
            }

            50%,
            100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .overlay {
            background: #000814;
            background: -webkit-linear-gradient(to right, #000814, #000814);
            background: linear-gradient(to right, #000814, #000814);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 0 0;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-20%);
        }

        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }

        .social-container {
            margin: 20px 0;
        }

        .social-container a {
            border: 1px solid #DDDDDD;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
        }

        footer {
            background-color: #222;
            color: #fff;
            font-size: 14px;
            bottom: 0;
            position: fixed;
            left: 0;
            right: 0;
            text-align: center;
            z-index: 999;
        }

        footer p {
            margin: 10px 0;
        }

        footer i {
            color: red;
        }

        footer a {
            color: #3c97bf;
            text-decoration: none;
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2) {

            /** Formatar o menu para telas de iPhone 4 e 4s **/
            body {
                background: #fff;
            }

            .container.right-panel-active .overlay-container {
                transform: translateX(-100%);
                display: none;
            }

            .container.right-panel-active .sign-in-container {
                transform: none;
            }

            .container {
                background-color: #fff;
                border-radius: 10px;
                box-shadow: none;
                position: relative;
                overflow: hidden;
                width: 768px;
                max-width: 100%;
                min-height: 480px;
                height: 100%;
            }

            form {
                background-color: #FFFFFF;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                padding: 0 50px;
                height: 90%;
                text-align: center;
                margin-top: -250px;
            }

            .sign-in-container {
                left: 0;
                width: 100%;
                z-index: 2;
            }

            input {
                /* background-color: #ededed; */
                border: 1px solid lightgray;
                padding: 12px 15px;
                margin: 8px 0;
                width: 100%;
                border-radius: 3px;
                font-size: 40px;
                color: grey;
                height: 120px
            }

            input:focus {
                outline: none;
            }

            button {
                border-radius: 3px;
                border: 1px solid #17A2B8;
                background: #17A2B8;
                color: #FFFFFF;
                font-size: 40px;
                padding: 25px 45px;
                letter-spacing: 1px;
                text-transform: uppercase;
                transition: transform 80ms ease-in;
                width: 100%;
            }

            .logo {
                width: 250px !important;
                padding-top: 0px;
                margin-bottom: 40px;
            }

            .seguro {
                width: 70px !important;
                margin-top: 40px;
            }

            .seguro1 {
                font-size: 40px !important;
            }

        }
    </style>
</head>

<!-- partial:index.partial.html -->
<div class="container right-panel-active" id="container">
    <div class="form-container sign-in-container">
        <form action="/login/autenticar" method="post">
            <a class="navbar-brand navbar-brand-dynamic-color fade-page" href="#">
                <img class="logo" alt="Eficaz Gestor" src="<?= base_url('assets/img/logo-marca.png') ?>" style="width:130px; border-radius: 50%;">
            </a>
            <input type="text" name="usuario" placeholder="Digite seu Usuário" value="<?= (isset($_GET['user'])) ? $_GET['user'] : "" ?>" autofocus required />
            <input type="password" name="senha" placeholder="Digite sua Senha" required />
            <button type="submit" class="btn btn-success btn-block" style="margin-top: 10px">ACESSAR</button>
            <a class="seguro1" style=" color: #858585; font-size: 14px; margin-bottom: -50px; margin-top: 20px; "><img class="seguro" alt="Eficaz Gestor" src="https://www.eficazgestor.com.br/assets/img/bloqueado.png" style="width:25px;"> <br>Ambiente Seguro</a>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Ativo Media e Tecnologias</h1>
                <p>00.000.000/0000-00</p>
                <!-- <a style="margin-top:-5px;color:#fff;" href="https://wa.me/message/BGIJZIWWKFOIF1">
                    <button class="ghost"><a style="margin-top:-5px;color:#fff;" href="https://wa.me/message/BGIJZIWWKFOIF1">CONVERSE CONOSCO.. CLIQUE AQUI!</a></button></a>
                </a> -->
            </div>
        </div>
    </div>
</div>
<!-- ========= Scripts com prioridade ============= -->
<!-- jQuery -->
<script src="<?= base_url('theme/plugins/jquery/jquery.js') ?>"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('theme/plugins/sweetalert2/sweetalert2.js') ?>"></script>

<script>
    $(function() {
        // -------------- ALERTAS ---------------- //
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        <?php
        $session = session();
        $alert = $session->getFlashdata('alert');

        if (isset($alert)) : ?>



            Toast.fire({
                type: '<?= $alert['type'] ?>',
                title: '<?= $alert['title'] ?>'
            })

        <?php endif;
        ?>
    });
</script>
</body>

</html>