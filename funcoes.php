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
}

function tratar_retorno()
{
    if (!isset($_GET['code'])) {
        return;
    }

    switch ((int)$_GET['code']) {

        case 0:
            return [
                'sucesso' => true,
                'mensagem' => 'Operação realizada com sucesso.'
            ];
            break;

        case 1:
            return [
                'sucesso' => false,
                'mensagem' => 'Você não tem permissão para acessar a página de destino. Faça login e tente novamente.'
            ];
            break;
    }
}
