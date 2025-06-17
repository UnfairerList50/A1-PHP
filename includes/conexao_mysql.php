<?php
function conectar_banco() {
    return mysqli_connect('localhost', 'root', '', 'cinema');
}
?>