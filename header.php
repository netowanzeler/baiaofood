<?php require_once 'globals.php'; ?>

<header id="header" class="header-scroll top-header headrom">
  <nav class="navbar navbar-dark">
    <div class="container">
      <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
      <a class="navbar-brand" href="index.php"> <img class="img-rounded" height="50px" src="images/food-mania-logo.png" alt="Logotipo"> </a>
      <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
        <ul class="nav navbar-nav">
          <li class="nav-item"> <a class="nav-link active" href="index.php">Início <span class="sr-only">(atual)</span></a> </li>
          <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurantes <span class="sr-only"></span></a> </li>
          <?php
          if (IS_USER_LOGGED_IN) {
            echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">Seus Pedidos</a> </li>
                  <li class="nav-item"><a href="logout.php" class="nav-link active">Sair</a> </li>';
          } else {
            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Entrar</a> </li>
                  <li class="nav-item"><a href="registration.php" class="nav-link active">Cadastrar</a> </li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
