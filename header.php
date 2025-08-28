<!-- <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css"> -->



<script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<header class="site-header">
  <div class="max-w-7xl mx-auto px-4 py-4">
    <div class="flex items-center justify-between gap-4">

      <!-- Marca -->
      <a href="index.php" class="brand no-underline flex items-center gap-2">
        <span class="logo-mark">B</span>
        <span class="text-xl font-bold">BaiãoFood</span>
      </a>

      <!-- Navegação -->
      <nav aria-label="Principal">
        <ul class="menu flex items-center gap-2">
          <li><a href="index.php" class="btn-outline">Início</a></li>
          <li><a href="restaurants.php" class="btn-outline">Restaurantes</a></li>

          <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="pedidos.php" class="btn-outline">Seus Pedidos</a></li>
            <li><a href="logout.php" class="btn-outline">Sair</a></li>
          <?php else: ?>
            <li class="hidden sm:inline-flex"><a href="registration.php" class="btn-primary">Cadastrar</a></li>
            <li><a href="login.php" class="btn-outline">Entrar</a></li>
          <?php endif; ?>
        </ul>
      </nav>

    </div>
  </div>
</header>
