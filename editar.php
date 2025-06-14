<?php
require_once 'funcoes.php';
require_once 'autenticacao_usuario.php';

$retorno = tratar_retorno();
$filme = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (form_em_branco()) {
        header('Location: editar.php?code=4&id=' . $_POST['id']);
        exit;
    }

    try {
        $conn = mysqli_connect('localhost', 'root', '', 'cinema');

        $sql = "UPDATE filmes SET lancamento = ?, titulo = ?, sinopse = ?, duracao = ?, avaliacao = ?
                WHERE id = ? AND usuarioId = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'ssssdii',
            $_POST['lancamento'],
            $_POST['titulo'],
            $_POST['sinopse'],
            $_POST['duracao'],
            $_POST['avaliacao'],
            $_POST['id'],
            $_SESSION['id']
        );
        mysqli_execute($stmt);

        mysqli_close($conn);
        header('Location: editar.php?code=0&id=' . $_POST['id']);
        exit;
    } catch (mysqli_sql_exception $e) {
        !isset($conn) ?: mysqli_close($conn);
        header('Location: editar.php?code=2&id=' . $_POST['id']);
        exit;
    }
}

// PROCESSAMENTO DO GET (busca do filme)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $conn = mysqli_connect('localhost', 'root', '', 'cinema');

        $sql = "SELECT * FROM filmes WHERE id = ? AND usuarioId = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $_GET['id'], $_SESSION['id']);
        mysqli_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $filme = mysqli_fetch_assoc($resultado);

        if (!$filme) {
            mysqli_close($conn);
            header('Location: editar.php?code=3');
            exit;
        }

        mysqli_close($conn);
    } catch (mysqli_sql_exception $e) {
        !isset($conn) ?: mysqli_close($conn);
        echo $e->getMessage();
        // header('Location: editar.php?code=2');
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
    <title>Editar Filme</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <section class="container">
        <h1>Editar filme</h1>
        <?php
        if (isset($retorno)) {
            echo '<p class="' . ($retorno['sucesso'] ? 'txt' : 'erro') . '">' . $retorno["mensagem"] . '</p>';
            if (!$retorno['sucesso']) {
                echo '<a class="btn btnprimary" href="home.php">Ir ao início</a>';
                exit;
            }
        }
        ?>
        <?php if ($filme) { ?>
            <form action="editar.php" method="POST" class="form">
                <input type="number" name="id" id="id" value="<?= $filme['id'] ?>" hidden>
                <div class="formgroup">
                    <label for="titulo">Título</label>
                    <input class="forminput" type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($filme['titulo']) ?>" required>
                </div>
                <div class="formgroup">
                    <label for="lancamento">Lançamento</label>
                    <input class="forminput" type="date" id="lancamento" name="lancamento" value="<?= date('Y-m-d', strtotime($filme['lancamento'])) ?>" required>
                </div>
                <div class="formgroup">
                    <label for="sinopse">Sinopse</label>
                    <textarea class="forminput" id="sinopse" name="sinopse" rows="4" required><?= htmlspecialchars($filme['sinopse']) ?></textarea>
                </div>
                <div class="formgroup">
                    <label for="duracao">Duração</label>
                    <input class="forminput" type="time" id="duracao" name="duracao" value="<?= date('H:i', strtotime($filme['duracao'])) ?>" required>
                    <label for="avaliacao">Avaliação</label>
                    <input class="forminput" type="number" min="0" max="10" step="0.1" id="avaliacao" name="avaliacao" value="<?= $filme['avaliacao'] ?>" required>
                </div>
                <div class="formgroup">
                    <input class="btn btnprimary" type="submit" value="Salvar">
                    <input class="btn" type="reset" value="Limpar">
                </div>
            </form>
        <?php } ?>
    </section>
</body>

</html>