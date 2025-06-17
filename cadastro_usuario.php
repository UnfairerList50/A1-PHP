<?php
require_once 'includes/funcoes.php';
require_once 'includes/conexao_mysql.php';

$retorno = tratar_retorno();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (form_em_branco()) {
        header('Location:cadastro_usuario.php?code=1');
        exit;
    }
    try {
        $conn = conectar_banco();

        $sql = "INSERT INTO usuarios (usuario, email, senha) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $_POST['usuario'], $_POST['email'], $_POST['senha']);
        mysqli_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            header('location:index.php?code=0');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Codigo indica que usuario ja existe
            header('Location: cadastro_usuario.php?code=7');
            exit;
        } else {
            header('Location: cadastro_usuario.php?code=4');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar nova conta</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="ico/camera-reels-fill.svg" type="image/x-icon">
</head>

<body class="bg">
    <?php include 'includes/toast.php'; ?>
    <section class="container card">
        <h1>Criar nova conta</h1>
        <form action="cadastro_usuario.php" class="form" method="POST">
            <input class="forminput" type="text" id="usuario" name="usuario" placeholder="Nome do usuário" required>
            <input class="forminput" type="email" id="email" name="email" placeholder="E-mail" required>
            <input class="forminput" type="password" id="senha" name="senha" placeholder="Senha" required>
            <input class="btn btnprimary" type="submit" value="Cadastrar">
        </form>
        <a href="index.php" class="link">Voltar ao login</a>
    </section>
</body>

</html>