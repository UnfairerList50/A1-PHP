<?php
require_once 'includes/autenticacao_usuario.php';
require_once 'includes/funcoes.php';
require_once 'includes/conexao_mysql.php';

// fluxo para salvar o filme editado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (form_em_branco()) {
        header('Location: editar_filme.php?code=1&id=' . $_POST['id']);
        exit;
    }

    try {
        $conn = conectar_banco();

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

        header('Location: filmes.php?code=0');
        exit;
    } catch (mysqli_sql_exception $e) {
        header('Location: filmes.php?code=4');
        exit;
    }
}

// fluxo para carregar o filme a ser editado
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $conn = conectar_banco();

        $sql = "SELECT * FROM filmes WHERE id = ? AND usuarioId = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $_GET['id'], $_SESSION['id']);
        mysqli_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $filme = mysqli_fetch_assoc($resultado);

        if (!$filme) {
            header('Location: editar_filme.php?code=5');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        header('Location: editar_filme.php?code=4');
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
    <title>Editar filme</title>
</head>

<body>
    <?php include 'includes/header.php';
    include 'includes/toast.php'; ?>
    <section class="container">
        <div class="breadcrumb">
            <a href="filmes.php" class="link">Ver filmes</a>
            <span>></span>
            <h1 class="label">Editar filme</h1>
        </div>
        <?php if (!isset($filme)) {
            exit;
        } ?>
        <form action="editar_filme.php" method="POST" class="form">
            <input type="number" name="id" id="id" value="<?= $filme['id'] ?>" hidden>
            <div class="formgroup">
                <label for="titulo">Título</label>
                <input class="forminput" type="text" id="titulo" name="titulo" value="<?= $filme['titulo'] ?>" required>
            </div>
            <div class="formgroup">
                <label for="lancamento">Lançamento</label>
                <input class="forminput" type="date" id="lancamento" name="lancamento" value="<?= date('Y-m-d', strtotime($filme['lancamento'])) ?>" required>
            </div>
            <div class="formgroup">
                <label for="sinopse">Sinopse</label>
                <textarea class="forminput" id="sinopse" name="sinopse" rows="3" maxlength="200"><?= $filme['sinopse'] ?></textarea>
            </div>
            <div class="formgroup">
                <label for="duracao">Duração</label>
                <input class="forminput" type="time" id="duracao" name="duracao" value="<?= date('H:i', strtotime($filme['duracao'])) ?>" required>
                <label for="avaliacao">Avaliação</label>
                <input class="forminput" type="number" min="0" max="10" step="0.1" id="avaliacao" name="avaliacao" value="<?= $filme['avaliacao'] ?>" required>
            </div>
            <div class="formgroup">
                <input class="btn btnprimary" type="submit" value="Salvar">
                <input class="btn btnsecondary" type="reset" value="Descartar alterações">
            </div>
        </form>
    </section>
</body>

</html>