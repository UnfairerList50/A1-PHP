<?php
require_once 'funcoes.php';
require_once 'autenticacao_usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $conn = mysqli_connect('localhost', 'root', '', 'cinema');

        $sql = "DELETE FROM filmes
                WHERE id = ? AND usuarioId = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $_GET['id'], $_SESSION['id']);
        mysqli_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            mysqli_close($conn);
            header('location:listar.php?code=0');
            exit;
        } else {
            header('location:listar.php?code=3');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        !isset($conn) ?: mysqli_close($conn);
        header('Location: listar.php?code=2');
        exit;
    } finally {
        !isset($conn) ?: mysqli_close($conn);
    }
}
