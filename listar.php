<?php
require_once 'autenticacao_usuario.php';
require_once 'funcoes.php';

if (!isset($_GET['code']) || $_GET['code'] == 0) {
    try {
        $conn = mysqli_connect('localhost', 'root', '', 'cinema');

        $query = "SELECT * FROM filmes WHERE usuarioId = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
        mysqli_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) <= 0) {
            header('Location: listar.php?code=6');
            exit;
        }

        while ($linha = mysqli_fetch_assoc($resultado)) {
            $filmes[] = $linha;
        }
    } catch (mysqli_sql_exception $e) {
        header('Location: listar.php?code=4');
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
    <title>Ver filmes salvos</title>
</head>

<body>
    <?php include 'header.php';
    include 'toast.php'; ?>
    <section class="container">
        <h1>Filmes salvos</h1>
        <?php if (!isset($filmes)) {
            exit;
        } ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Lançamento</th>
                    <th>Sinopse</th>
                    <th>Duração</th>
                    <th>Avaliação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filmes as $filme) { ?>
                    <tr>
                        <td><?= $filme['id'] ?></td>
                        <td><?= $filme['titulo'] ?></td>
                        <td><?= date_format(new DateTime($filme['lancamento']), "d/m/Y") ?></td>
                        <td><?= $filme['sinopse'] ?></td>
                        <td><?= date_format(new DateTime($filme['duracao']), "H:i") ?></td>
                        <td><?= $filme['avaliacao'] ?></td>
                        <td>
                            <a href="editar.php?id=<?= $filme['id'] ?>" class="btn btnprimary">Editar</a>
                            <a href="excluir.php?id=<?= $filme['id'] ?>" class="btn">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</body>

</html>