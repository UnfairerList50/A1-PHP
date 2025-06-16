<header>
    <ul class="navbar">
        <li>
            <a class="navlogo" href="dashboard.php" title="Ir para o início">Gerenciador de filmes</a>
        </li>
        <li>
            <a class="btn" href="filmes.php">Ver filmes</a>
        </li>
        <li>
            <a class="btn" href="novo_filme.php">Salvar filme</a>
        </li>
        <li class="navlogout">
            <h4 class="label">Bem-vindo(a), <?= $_SESSION['usuario'] ?></h4>
        </li>
        <li><a class="btn btnprimary" href="logout.php">Logout</a></li>
    </ul>
</header>