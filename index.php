<?php
require_once 'includes/funcoes.php';
require_once 'includes/conexao_mysql.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (form_em_branco()) {
        header('Location:index.php?code=1');
        exit;
    }

    try {
        $conn = conectar_banco();

        $sql = "SELECT id, usuario, senha FROM usuarios
                WHERE (usuario = ? OR email = ?) AND senha = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $_POST['usuario'], $_POST['usuario'], $_POST['senha']);
        mysqli_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) <= 0) {
            header('Location:index.php?code=2');
            exit;
        }

        mysqli_stmt_bind_result($stmt, $id, $usuario, $senha);
        mysqli_stmt_fetch($stmt);

        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['senha'] = $senha;

        header('location:dashboard.php');
    } catch (mysqli_sql_exception $e) {
        header('Location:index.php?code=4');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="ico/camera-reels-fill.svg" type="image/x-icon">
</head>

<body class="bg">
    <?php include 'includes/toast.php'; ?>
    <section class="container card">
        <img src="ico/person-circle.svg" class="ico">
        <h1 class="label">Fazer login</h1>
        <form action="index.php" class="form" method="POST">
            <input class="forminput" type="text" id="usuario" name="usuario" placeholder="Usuário ou e-mail" required>
            <input class="forminput" type="password" id="senha" name="senha" placeholder="Senha" required>
            <input class="btn btnprimary" type="submit" value="Login">
        </form>
        <a href="cadastro_usuario.php" class="link">Criar conta</a>
    </section>
</body>

</html>