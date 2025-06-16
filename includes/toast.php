<?php
$retorno = tratar_retorno();
if (isset($retorno)) {
    echo '<div class="toast">
    <p class="label">' . $retorno . '</p>
    </div>';
}
