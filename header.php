<header>
    <ul class="navbar">
        <li>
            <a class="navlogo" href="home.php" title="Ir para o início">Sistema de bilheteria</a>
        </li>
        <li>
            <a class="btn" href="listar.php">Ver filmes</a>
        </li>
        <li>
            <a class="btn" href="salvar.php">Salvar filme</a>
        </li>
        <li class="navlogout">
            <h4 class="label">Bem-vindo(a), <?= $_SESSION['usuario'] ?></h4>
        </li>
        <li><a class="btn btnprimary" href="logout.php">Logout</a></li>
    </ul>
</header>