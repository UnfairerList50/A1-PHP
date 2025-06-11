<?php

function post_nao_enviado()
{
    return $_SERVER['REQUEST_METHOD'] !== 'POST';
}

function form_em_branco()
{
    return empty($_POST['usuario']) || empty($_POST['senha']);
}

function tratar_erros()
{

    if (!isset($_GET['error'])) {
        return;
    }

    $error = (int)$_GET['error'];

    switch ($error) {

        case 0:
            $erro = '<h3>Você não tem permissão para acessar a página de destino.</h3>';
            break;

        case 1:
            $erro = '<h3>Usuário ou senha inválidos. Tente novamente.</h3>';
            break;

        case 2:
            $erro = '<h2>Preencha todos os campos do formulário para continuar.</h2>';
            break;

        case 3:
            $erro = '<h3>Erro ao consultar o banco de dados. Tente novamente mais tarde, ou contate o administrador do sistema.</h3>';
            break;

        default:
            $erro = "";
            break;
    }

    echo $erro;
}
