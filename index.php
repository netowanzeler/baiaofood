<?php
require_once 'globals.php';
require_once 'connection/connect.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Início | BaiaoFood</title>
  <link rel="icon" href="./icons/home.png" type="image/png">
  <!-- CSS base do projeto -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animsition.min.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!-- Tema inspirado no IFOOD_INICIO_no_tailwind (sem Tailwind)
  <link href="css/ifood_theme.css" rel="stylesheet"> -->
 
</head>
<body class="min-h-screen bg-background text-foreground selection:bg-food-warm/30 selection:text-foreground">
  <?php require_once 'header.php'; ?>

  <!-- Hero -->
  <section class="relative min-h-[70vh] sm:min-h-[80vh] overflow-hidden">
    <img src="images//hero-food.jpg" alt="Delicious food" class="absolute inset-0 w-full h-full object-cover opacity-40">
    <div class="absolute inset-0 bg-hero-gradient"></div>
    <div class="relative max-w-7xl mx-auto px-4">
      <div class="py-20 sm:py-28 md:py-36">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight mb-6">
          Fresco, rápido e delicioso.<br class="hidden sm:block"/> Entregue na sua porta.
        </h1>
        <!-- descrição branca -->
        <p class="text-lg sm:text-xl hero-desc max-w-2xl">
          Descubra restaurantes perto de você e peça seus pratos favoritos com poucos cliques.
        </p>
        <div class="mt-8">
          <!-- botão do herói enxuto -->
          <a href="restaurants.php" class="btn-hero">
            Explorar Restaurantes
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Dishes -->
  <section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-10">
        <h2 class="text-3xl sm:text-4xl font-bold mb-2">Pratos Populares</h2>
        <p class="text-muted">Escolhidos a dedo pelos clientes nesta semana</p>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        $query_res = $db->query("SELECT * FROM dishes LIMIT 6");
        while ($r = $query_res->fetch_assoc()) { ?>
          <article class="group rounded-xl overflow-hidden bg-card border border-border hover:border-food-warm/50 transition-colors shadow-elegant">
            <div class="relative">
              <img src="<?php echo 'admin/Res_img/dishes/' . $r['img']; ?>" alt="<?php echo htmlspecialchars($r['title']); ?>" class="w-full h-48 object-cover">
            </div>
            <div class="p-6">
              <h3 class="text-lg font-semibold mb-2"><?php echo htmlspecialchars($r['title']); ?></h3>
              <p class="text-muted mb-4"><?php echo htmlspecialchars($r['slogan']); ?></p>
              <div class="flex items-center justify-between">
                <div class="flex items-baseline gap-2">
                  <span class="text-2xl font-bold text-food-warm">R$ <?php echo number_format($r['price'], 2, ',', '.'); ?></span>
                </div>
                <a class="px-3 py-2 rounded-lg bg-secondary border border-border hover:bg-secondary/80" href="dishes.php?res_id=<?php echo $r['rs_id']; ?>">Pedir</a>
              </div>
            </div>
          </article>
        <?php } ?>
      </div>
      <div class="text-center mt-10">
        <a href="dishes.php" class="px-8 py-3 rounded-lg bg-food-warm text-black font-medium hover:bg-food-warm/90 shadow-warm">Ver todos os pratos</a>
      </div>
    </div>
  </section>

  <!-- Restaurants -->
  <section class="py-16 border-t border-border bg-card/30 restaurants-section">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-10">
        <h2 class="text-3xl sm:text-4xl font-bold mb-2">Restaurantes em Destaque</h2>
        <p class="text-muted">Ótimas avaliações, entrega rápida e ingredientes frescos</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
        $ress = mysqli_query($db, "SELECT * FROM restaurant");
        while ($rows = mysqli_fetch_array($ress)) {
          $query = mysqli_query($db, "SELECT * FROM res_category WHERE c_id='" . $rows['c_id'] . "' ");
          $rowss = mysqli_fetch_array($query);
          ?>
          <article class="restaurant-card rounded-xl overflow-hidden bg-card border border-border shadow-elegant">
            <div class="md:flex">
              <img src="<?php echo 'admin/Res_img/' . $rows['image']; ?>" alt="Logotipo de <?php echo htmlspecialchars($rows['title']); ?>" class="w-full md:w-48 h-40 object-cover">
              <div class="p-6 flex-1">
                <div class="flex items-center gap-3 mb-2">
                  <h3 class="text-xl font-semibold flex-1">
                    <a href="dishes.php?res_id=<?php echo $rows['rs_id']; ?>" class="hover:underline">
                      <?php echo htmlspecialchars($rows['title']); ?>
                    </a>
                  </h3>
                  <span class="px-2 py-1 rounded-md text-xs bg-secondary border border-border"><?php echo htmlspecialchars($rowss['c_name']); ?></span>
                </div>
                <p class="text-muted mb-3"><?php echo htmlspecialchars($rows['address']); ?></p>
                <div class="text-sm text-muted"><?php echo htmlspecialchars($rows['ohrs']); ?></div>
              </div>
            </div>
          </article>
        <?php } ?>
      </div>
      <div class="text-center mt-10">
        <a href="restaurants.php" class="px-8 py-3 rounded-lg bg-secondary border border-border hover:bg-secondary/80">Ver todos os restaurantes</a>
      </div>
    </div>
  </section>

  <?php require_once 'footer.php'; ?>

</body>
</html>
