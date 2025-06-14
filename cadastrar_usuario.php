<?php
require_once 'funcoes.php';

$erro;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (form_em_branco()) {
            throw new Exception('Preencha todos os campos do formulário.', 1);
        }

        $conn = mysqli_connect('localhost', 'root', '', 'cinema');

        $sql = "INSERT INTO usuarios (usuario, email, senha) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $_POST['usuario'], $_POST['email'], $_POST['senha']);
        mysqli_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            mysqli_close($conn);
            header('location:index.php?code=0');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        $erro = 'Erro ao acessar o banco de dados. Tente novamente mais tarde, ou contate o administrador do sistema.';
    } catch (Exception $e) {
        $erro = $e->getMessage();
    } finally {
        !isset($conn) ?: mysqli_close($conn);
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar conta</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<!DOCTYPE html>
<html lang="pt-br">

<body class="bg">
    <section class="container card">
        <h1>Criar conta</h1>
        <p class="txt"><?= isset($erro) ? $erro : 'Digite suas informações para criar uma conta' ?></p>
        <form action="cadastrar_usuario.php" class="form" method="POST">
            <input class="forminput" type="text" id="usuario" name="usuario" placeholder="Nome do usuário" required>
            <input class="forminput" type="email" id="email" name="email" placeholder="E-mail" required>
            <input class="forminput" type="password" id="senha" name="senha" placeholder="Senha" required>
            <input class="btn btnprimary" type="submit" value="Cadastrar">
        </form>
        <a href="index.php" class="link">Voltar ao login</a>
    </section>
</body>

</html>