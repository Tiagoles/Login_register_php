<?php include('./connect/conexao.php');
$vLogin = 'NULL';
$vSenha = 'NULL';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="./style/style.css">
    <script src="./jquery-3.6.4.js"></script>
</head>
<?php
if (isset($_POST['btnCadastro'])) {
    if (!empty($_POST['loginCadastro']) && !empty($_POST['senhaCadastro'])) {
        $vLogin = $_POST['loginCadastro'];
        $vSenha = $_POST['senhaCadastro'];
        $vNome = $_POST['nomeCadastro'];
        $vIdade = $_POST['idadeCadastro'];
        $vfseC = $con->prepare("SELECT USER_LOGIN, USER_SENHA FROM USER WHERE USER_LOGIN =:UCADASTRO");
        $vfseC->execute(array(':UCADASTRO' => $vLogin));
        $verificaC = $vfseC->fetchAll();
        if (!empty($verificaC)) { ?>
            <script>
                alert("Usuário já existe.")
            </script><?php
                    } else {
                        $caduser = $con->prepare("INSERT INTO USER (USER_LOGIN, USER_SENHA) VALUES (:RLOGIN, :RSENHA)");
                        $caduser->execute(array(':RLOGIN' => $vLogin, ':RSENHA' => $vSenha));
                        $query = "SELECT MAX(CD_ALUNO) AS CD_ALUNO FROM alunos";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($row) {
                            $id = $row["CD_ALUNO"];
                            $query = "UPDATE alunos SET NM_ALUNO=:campo1, IDADE_ALUNO=:campo2 WHERE CD_ALUNO=:id";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(":campo1", $vNome);
                            $stmt->bindParam(":campo2", $vIdade);
                            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                            if ($stmt->execute()) {
                        ?>
<?php
                                header('Location: index.php');
                            } else {
                                echo "Falha ao atualizar os dados do último registro.";
                            }
                        } else {
                            echo "A tabela está vazia ou ocorreu uma falha na consulta.";
                        }
                    }
                }
            }
?>
<body>
    <div class="container">
        <h1 id="titulo_principal">Cadastro</h1>
        <form method="POST" action="cadastro.php">
            <label for="login" id="labelLogin" class="label-form">Usuário</label>
            <input type="text" id="login" name="loginCadastro" class="input" autofocus required>
            <label for="password" id="labelPassword" class="label-form">Senha</label>
            <input type="password" id="password" name="senhaCadastro" class="input" required>
            <label for="confirmPassword" id="labelConfirmPassword" class="label-form">Confirmar Senha</label>
            <input type="password" id="confirmPassword" name="senhaCadastro2x" class="input" required>
            <label for="nome" id="labelNome" class="label-form">Seu Nome</label>
            <input type="text" id="nome" name="nomeCadastro" class="input" required>
            <label for="idade" id="labelIdade" class="label-form">Sua Idade</label>
            <input type="number" id="idade" name="idadeCadastro" class="input" required>
            <div class="button-container">
                <button type="submit" name="btnCadastro" id="button">Cadastrar</button>
            </div>
        </form>
        <a href="index.php" type="button" class="link-cadastro-login">Já cadastrado? faça um Login</a>
    </div>
    <script>
        const input = $("input");
        function LimpaSugestoesInput(element) {
            $(element).on('focus', () => {
                $(element).attr("autocomplete", 'off')
            })
        };
        LimpaSugestoesInput(input)
    </script>
</body>
</html>