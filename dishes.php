<?php
include("connection/connect.php");
error_reporting(0);
session_start();

include_once 'product-action.php';

?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="#">
  <title>Dishes</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animsition.min.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <?php require_once 'header.php'; ?>

  <div class="page-wrapper">
    <div class="top-links">
      
    </div>
    <?php
    $ress = mysqli_query($db, "select * from restaurant where rs_id='$_GET[res_id]'");
    $rows = mysqli_fetch_array($ress);
    ?>
    <section class="inner-page-hero bg-image" data-image-src="images/img/dish.jpeg">
      <div class="profile">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-12  col-md-4 col-lg-4 profile-img">
              <div class="image-wrap">
                <figure>
                  <?php echo '<img class="bg-black img-thumbnail" src="admin/Res_img/' . $rows['image'] . '" alt="Logotipo do Restaurante">'; ?>
                </figure>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc">
              <div class="pull-left right-text white-txt">
                <h6><a href="#"><?php echo $rows['title']; ?></a></h6>
                <p><?php echo $rows['address']; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="breadcrumb">
      <div class="container"></div>
    </div>
    <div class="container m-t-30">
      <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
          <div class="widget widget-cart">
            <div class="widget-heading">
              <h3 class="widget-title text-dark">
                Seu Carrinho
              </h3>
              <div class="clearfix"></div>
            </div>
            <div class="order-row bg-white">
              <div class="widget-body">
                <?php
                $item_total = 0;
                foreach ($_SESSION["cart_item"] as $item) :
                ?>
                  <div class="title-row">
                    <?php echo $item["title"]; ?><a
                      href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>">
                      <i class="fa fa-trash pull-right"></i></a>
                  </div>
                  <div class="form-group row no-gutter">
                    <div class="col-xs-8">
                      <input type="text" class="form-control b-r-0"
                        value=<?php echo "R$" . $item["price"]; ?> readonly id="exampleSelect1">
                    </div>
                    <div class="col-xs-4">
                      <input class="form-control" type="text" readonly
                        value='<?php echo $item["quantity"]; ?>' id="example-number-input">
                    </div>
                  </div>
                <?php
                  $item_total += ($item["price"] * $item["quantity"]);
                endforeach;
                ?>
              </div>
            </div>
            <div class="widget-body">
              <div class="price-wrap text-xs-center">
                <p>TOTAL</p>
                <h3 class="value"><strong><?php echo "R$" . $item_total; ?></strong></h3>
                <p>Entrega Grátis!!!</p>

                <?php if ($item_total == 0) : ?>
                  <button class="btn theme-btn btn-lg disabled bg-warning
">Finalizar</button>
                <?php else : ?>
                  <form action="checkout.php" method="post">
                    <?php foreach ($_SESSION["cart_item"] as $item): ?>
                      <input type="hidden" name="items[<?php echo $item["d_id"]; ?>][title]"
                        value="<?php echo $item["title"]; ?>">
                      <input type="hidden" name="items[<?php echo $item["d_id"]; ?>][quantity]"
                        value="<?php echo $item["quantity"]; ?>">
                      <input type="hidden" name="items[<?php echo $item["d_id"]; ?>][price]"
                        value="<?php echo $item["price"]; ?>">
                    <?php endforeach; ?>
                    <button type="submit" class="btn theme-btn btn-lg">Finalizar</button>
                  </form>
                <?php endif; ?>


              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
          <div class="menu-widget" id="2">
            <div class="widget-heading">
              <h3 class="widget-title text-dark">
                MENU <a class="btn btn-link pull-right" data-toggle="collapse" href="#popular2"
                  aria-expanded="true">
                  <i class="fa fa-angle-right pull-right"></i>
                </a>
              </h3>
              <div class="clearfix"></div>
            </div>
            <div class="collapse in" id="popular2">
              <?php
              $stmt = $db->prepare("select * from dishes where rs_id='$_GET[res_id]'");
              $stmt->execute();
              $products = $stmt->get_result();
              if (!empty($products)) :
                foreach ($products as $product) :
              ?>
                  <div class="food-item">
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-lg-8">
                        <form method="post"
                          action='dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=add&id=<?php echo $product['d_id']; ?>'>
                          <div class="rest-logo pull-left">
                            <a class="restaurant-logo pull-left"
                              href="#"><?php echo '<img class="img-responsive img-thumbnail" src="admin/Res_img/dishes/' . $product['img'] . '" alt="Logotipo da Comida">'; ?></a>
                          </div>
                          <div class="rest-descr">
                            <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                            <p> <?php echo $product['slogan']; ?></p>
                          </div>
                      </div>
                      <div class="col-xs-12 col-sm-12 col-lg-4 pull-right item-cart-info">
                        <span class="price pull-left">R$<?php echo $product['price']; ?></span>
                        <input class="b-r-0" type="text" name="quantity" style="margin-left:30px;"
                          value="1" size="2" />
                        <input type="submit" class="btn theme-btn" style="margin-left:40px;"
                          value="Adicionar ao carrinho" />
                      </div>
                      </form>
                    </div>
                  </div>
              <?php
                endforeach;
              endif;
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once 'footer.php'; ?>

  </div>

  </div>

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