<?php
require_once 'connection/connect.php';
require_once 'globals.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="#">
  <title>Restaurantes | BaiaoFood</title>

  <!-- icon da aba -->
  <link rel="icon" href="./icons/restaurants.png" type="image/png">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animsition.min.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <?php require_once 'header.php'; ?>

  <div class="page-wrapper">

    <div class="inner-page-hero bg-image d-flex align-items-center justify-content-center text-center"
      data-image-src="images/img/hero-food.jpeg"
      style="height: 300px; background-size: cover; background-position: center;">
      
      <h1 class="position-relative text-white fw-bold">Encontre Restaurantes</h1>
    </div>

    <section class="restaurants-page py-8 mt-5">
      <div class="container">
        <div class="row g-4">
          <?php
          $ress = $db->query("SELECT * FROM restaurant");
          while ($rows = $ress->fetch_assoc()) {
            echo '
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="restaurant-card bg-white rounded-2xl shadow-sm hover:shadow-md transition duration-200 h-100 flex flex-col">
            
            <!-- Imagem -->
            <a href="dishes.php?res_id=' . $rows['rs_id'] . '" class="block overflow-hidden rounded-t-2xl">
              <img src="admin/Res_img/' . $rows['image'] . '" 
                   alt="Logotipo do Restaurante"
                   class="w-100 object-cover" 
                   style="height:180px;">
            </a>

            <!-- Texto -->
            <div class="p-3 flex-1 flex flex-col">
              <h5 class="font-semibold text-lg mb-1 line-clamp-2">
                <a href="dishes.php?res_id=' . $rows['rs_id'] . '" class="no-underline text-foreground hover:text-food-warm">
                  ' . $rows['title'] . '
                </a>
              </h5>
              <p class="text-muted text-sm line-clamp-2 mb-3">' . $rows['address'] . '</p>

              <!-- Botão -->
              <div class="mt-auto">
                <a href="dishes.php?res_id=' . $rows['rs_id'] . '" class="btn-primary w-100 text-center block">
                  Ver Menu
                </a>
              </div>
            </div>

          </div>
        </div>';
          }
          ?>
        </div>
      </div>
    </section>
  </div>
  <?php require_once 'footer.php'; ?>

  <script src="js/jquery.min.js"></script>
  <script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/animsition.min.js"></script>
  <script src="js/bootstrap-slider.min.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/headroom.js"></script>
  <script src="js/foodpicky.min.js"></script>
</body>

</html>