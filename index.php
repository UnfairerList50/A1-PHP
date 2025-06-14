<?php
require_once 'funcoes.php';

$retorno = tratar_retorno();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (form_em_branco()) {
            throw new Exception('Preencha todos os campos do formulário.', 1);
        }

        $conn = mysqli_connect('localhost', 'root', '', 'cinema');

        $sql = "SELECT id, usuario, senha FROM usuarios
                WHERE usuario = ? AND senha = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $_POST['usuario'], $_POST['senha']);
        mysqli_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $linhas = mysqli_stmt_num_rows($stmt);

        if ($linhas <= 0) {
            throw new Exception('Usuário ou senha inválidos. Tente novamente.', 1);
        }

        mysqli_stmt_bind_result($stmt, $id, $usuario, $senha);
        mysqli_stmt_fetch($stmt);

        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['senha'] = $senha;

        header('location:home.php');
    } catch (mysqli_sql_exception $e) {
        $retorno = [
            'sucesso' => false,
            'mensagem' => 'Erro ao acessar o banco de dados. Tente novamente mais tarde, ou contate o administrador do sistema.'
        ];
    } catch (Exception $e) {
        $retorno = [
            'sucesso' => false,
            'mensagem' => $e->getMessage()
        ];
    } finally {
        !isset($conn) ?: mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once 'funcoes.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg">
    <section class="container card">
        <img src="ico/person-circle.svg" class="ico">
        <h1 class="txt">Fazer login</h1>
        <?php
        if (isset($retorno)) {
            echo '<p class=' . ($retorno['sucesso'] ? 'txt' : 'erro') . '>' . $retorno["mensagem"] . '</p>';
        }
        ?>
        <form action="index.php" class="form" method="POST">
            <input class="forminput" type="text" id="usuario" name="usuario" placeholder="Usuário" required>
            <input class="forminput" type="password" id="senha" name="senha" placeholder="Senha" required>
            <input class="btn btnprimary" type="submit" value="Login">
        </form>
        <a href="cadastrar_usuario.php" class="link">Criar conta</a>
    </section>
</body>

</html>