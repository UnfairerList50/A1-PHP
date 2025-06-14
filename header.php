<header>
    <ul class="navbar">
        <li>
            <h3 class="navitem txt">Sistema de bilheteria</h3>
        </li>
        <li class="navitem">
            <a class="btn" href="listar.php">Ver filmes</a>
        </li>
        <li class="navitem">
            <a class="btn" href="salvar.php">Salvar filme</a>
        </li>
        <li class="navlogout">
            <h4 class="navitem txt">Bem-vindo, <?= $_SESSION['usuario'] ?></h4>
        </li>
        <li class="navitem"><a class="btn btnprimary" href="logout.php">Logout</a></li>
    </ul>
</header>