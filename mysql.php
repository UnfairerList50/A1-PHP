<?php
function conectar_banco($banco)
{

    $servidor   = 'localhost:3307';
    $usuario    = 'root';
    $senha      = '';

    $conn = mysqli_connect($servidor, $usuario, $senha, $banco);

    return $conn;
}

function fechar_banco($conn)
{
    if ($conn) {
        mysqli_close($conn);
    }
}
