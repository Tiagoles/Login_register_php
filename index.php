<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">
<script src="./jquery-3.6.4.js"></script>
<?php
include("./connect/conexao.php")
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style/login_style.css">
</head>

<body>
    <div class="container">
        <h1 id="titulo_principal">Login</h1>
        <form action="index.php" method="post" id="form" autocomplete="off">
            <label for="login" id="labelLogin" class="label-form">Usuário</label>
            <input type="text" id="login" name="user_login" class="input">
            <label for="password" id="labelPassword" class="label-form">Senha</label>
            <input type="password" id="password" name="user_password" class="input">
            <div class="button-container">
                <button type="submit" id="button">Entrar</button>
            </div>
            <?php
            if (isset($_POST['user_login']) && isset($_POST['user_password'])) {
                if (!empty($_POST['user_login']) && !empty($_POST['user_password'])) {
                    $login = $_POST['user_login'];
                    $senha = $_POST['user_password'];
                    $sql = $con->prepare("SELECT cd_user, USER_LOGIN, USER_SENHA FROM USER WHERE USER_LOGIN = :PLOGIN AND USER_SENHA = :PSENHA");
                    $sql->execute(array(
                        ':PLOGIN' => $login,
                        ':PSENHA' => $senha
                    ));
                    $cd = $sql->fetchAll();
                    if ($sql->rowCount() <= 0) {
                        unset($sql);
            ?>
                        <script>
                            alert("Login ou senha inválido");
                            window.location.href = 'http://localhost/index.php';
                        </script>
                    <?php
                    } else {
                        ?>
                            <script>alert("Login realizado com sucesso!")</script>
                        <?php
                    }
                }
            }
            ?>
        </form>
        <div id="container-link">
            <a href="cadastro.php" class="link-cadastro-login" id="link-login">Não tem um login? Cadastre-se</a>
        </div>
    </div>
    <script>
        let login = document.getElementById("login");
        let formulario = document.getElementById("form");
        $(formulario).on("submit", function(e) {
            if (login.value === "" || password.value === "") {
                e.preventDefault();
                alert("Preencha todos os campos");
            }
        });

        function LimpaSugestoesInput(element) {
            $(element).on('focus', () => {
                $(element).attr("autocomplete", 'off');
            })
        };
        LimpaSugestoesInput(input);
    </script>
</body>
</html>