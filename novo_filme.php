<?php
require_once 'includes/funcoes.php';
require_once 'includes/autenticacao_usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (form_em_branco()) {
        header('Location:novo_filme.php?code=1');
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
            header('location:novo_filme.php?code=0');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        header('Location:novo_filme.php?code=4');
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
    <title>Salvar novo filme</title>
</head>

<body>
    <?php include 'includes/header.php';
    include 'includes/toast.php'; ?>
    <section class="container">
        <div class="breadcrumb">
            <a href="dashboard.php" class="link">Início</a>
            <span>></span>
            <h1 class="label">Salvar filme</h1>
        </div>
        <form action="novo_filme.php" method="POST" class="form">
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
                <textarea class="forminput" id="sinopse" name="sinopse" rows="3" maxlength="200" required></textarea>
            </div>
            <div class="formgroup">
                <label for="duracao">Duração</label>
                <input class="forminput" type="time" id="duracao" name="duracao" required>
                <label for="avaliacao">Avaliação</label>
                <input class="forminput" type="number" min=0 max=10 step=0.1 id="avaliacao" name="avaliacao" required>
            </div>
            <div class="formgroup">
                <input class="btn btnprimary" type="submit" value="Salvar">
                <input class="btn btnsecondary" type="reset" value="Limpar">
            </div>
        </form>
    </section>
</body>

</html>