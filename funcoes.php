<?php

function form_em_branco()
{
    foreach ($_POST as $campo => $valor) {
        if ($campo === 'id') {
            continue;
        }
        if (empty(($valor))) {
            return true;
        }
    }
    return false;
}

function tratar_retorno()
{
    if (!isset($_GET['code'])) {
        return;
    }

    switch ((int)$_GET['code']) {

        case 0:
            return 'Operação realizada com sucesso.';
            break;

        case 1:
            return 'Preencha todos os campos do formulário.';
            break;

        case 2:
            return 'Usuário ou senha inválidos.';
            break;

        case 3:
            return 'Você não tem permissão para acessar a página de destino. Faça login e tente novamente.';
            break;

        case 4:
            return 'Erro ao acessar o banco de dados. Tente novamente mais tarde, ou contate o administrador do sistema.';
            break;

        case 5:
            return 'Filme não encontrado. Verifique o ID e tente novamente.';
            break;

        case 6:
            return 'Não há filmes salvos.';
            break;

        case 7:
            return 'Usuário já cadastrado.';
            break;
    }
}
