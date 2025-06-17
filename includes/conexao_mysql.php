<?php
function conectar_banco()
{
    // Para lançar exceções em caso de erro no banco de dados
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    return mysqli_connect('localhost', 'root', '', 'cinema');
}
