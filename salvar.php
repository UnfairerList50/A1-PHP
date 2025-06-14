<?php
require_once 'funcoes.php';
require_once 'autenticacao_usuario.php';

$retorno = tratar_retorno();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (form_em_branco()) {
        header('Location: salvar.php?code=4');
        exit;
    }

    try {
        $conn = mysqli_connect('localhost', 'root', '', 'cinema');

        $sql = "INSERT INTO filmes (lancamento, titulo, sinopse, duracao, avaliacao, usuarioId)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssdi', $_POST['lancamento'], $_POST['titulo'], $_POST['sinopse'], $_POST['duracao'], $_POST['avaliacao'], $_SESSION['id']);
        mysqli_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            mysqli_close($conn);
            header('location:salvar.php?code=0');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        !isset($conn) ?: mysqli_close($conn);
        header('Location: salvar.php?code=2');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="ico/camera-reels-fill.svg" type="image/x-icon">
    <title>Início</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <section class="container">
        <h1>Salvar novo filme</h1>
        <?php
        if (isset($retorno)) {
            echo '<p class=' . ($retorno['sucesso'] ? 'txt' : 'erro') . '>' . $retorno["mensagem"] . '</p>';
            echo '<a class="btn btnprimary" href="home.php">Ir ao início</a>';
            exit;
        }
        ?>
        <form action="salvar.php" method="POST" class="form">
            <div class="formgroup">
                <label for="titulo">Título</label>
                <input class="forminput" type="text" id="titulo" name="titulo" required>
            </div>
            <div class="formgroup">
                <label for="lancamento">Lançamento</label>
                <input class="forminput" type="date" id="lancamento" name="lancamento" required>
            </div>
            <div class="formgroup">
                <label for="sinopse">Sinopse</label>
                <textarea class="forminput" id="sinopse" name="sinopse" rows="4" required></textarea>
            </div>
            <div class="formgroup">
                <label for="duracao">Duração</label>
                <input class="forminput" type="time" id="duracao" name="duracao" required>
                <label for="avaliacao">Avaliação</label>
                <input class="forminput" type="number" min=0 max=10 step=0.1 id="avaliacao" name="avaliacao" required>
            </div>
            <div class="formgroup">
                <input class="btn btnprimary" type="submit" value="Salvar">
                <input class="btn" type="reset" value="Limpar">
            </div>
        </form>
    </section>
</body>

</html>