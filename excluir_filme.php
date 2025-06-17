<?php
require_once 'includes/funcoes.php';
require_once 'includes/autenticacao_usuario.php';
require_once 'includes/conexao_mysql.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $conn = conectar_banco();

        $sql = "DELETE FROM filmes
                WHERE id = ? AND usuarioId = ?";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $_GET['id'], $_SESSION['id']);
        mysqli_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            header('location:filmes.php?code=0');
            exit;
        } else {
            header('location:dashboard.php?code=5');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        header('Location: dashboard.php?code=4');
        exit;
    }
}
