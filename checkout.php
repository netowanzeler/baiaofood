<?php
require_once 'connection/connect.php';
require_once 'product-action.php';
require_once 'globals.php';


if (!IS_USER_LOGGED_IN) {
  header('location:login.php');
  exit();
}

foreach ($_SESSION["cart_item"] as $item) {
  $item_total += ($item["price"] * $item["quantity"]);
  if ($_POST['submit']) {
    $SQL = "insert into users_orders(u_id,title,quantity,price) values('" . $_SESSION["user_id"] . "','" . $item["title"] . "','" . $item["quantity"] . "','" . $item["price"] . "')";

    mysqli_query($db, $SQL);

    unset($_SESSION["cart_item"]);
    unset($item["title"]);
    unset($item["quantity"]);
    unset($item["price"]);
    $success = "Thankyou! Your Order Placed successfully!";

    echo "<script>alert('Obrigado! Seu pedido foi realizado com sucesso!');</script>";
    echo "<script>window.location.replace('your_orders.php');</script>";
  }
}
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
  <title>Checkout</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animsition.min.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>

  <div class="site-wrapper">

    <?php require_once 'header.php'; ?>

    <div class="page-wrapper">
      <div class="top-links">
        <div class="container">
          <ul class="row links">

            <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Choose Restaurant</a></li>
            <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your favorite food</a></li>
            <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and Pay</a></li>
          </ul>
        </div>
      </div>

      <div class="container">

        <span style="color:green;">
          <?php echo $success; ?>
        </span>

      </div>

      <div class="container m-t-30">
        <form action="" method="post">
          <div class="widget clearfix">

            <div class="widget-body">
              <form method="post" action="#">
                <div class="row">

                  <div class="col-sm-12">
                    <div class="cart-totals margin-b-20">
                      <div class="cart-totals-title">
                        <h4>Cart Summary</h4>
                      </div>
                      <div class="cart-totals-fields">

                        <table class="table">
                          <tbody>



                            <tr>
                              <td>Cart Subtotal</td>
                              <td> <?php echo "₹" . $item_total; ?></td>
                            </tr>
                            <tr>
                              <td>Delivery Charges</td>
                              <td>Free</td>
                            </tr>
                            <tr>
                              <td class="text-color"><strong>Total</strong></td>
                              <td class="text-color"><strong> <?php echo "₹" . $item_total; ?></strong></td>
                            </tr>
                          </tbody>




                        </table>
                      </div>
                    </div>
                    <div class="payment-option">
                      <ul class=" list-unstyled">
                        <li>
                          <label class="custom-control custom-radio  m-b-20">
                            <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Cash on Delivery</span>
                          </label>
                        </li>
                        <li>
                          <label class="custom-control custom-radio  m-b-10">
                            <input name="mod" type="radio" value="paypal" disabled class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Paypal <img src="images/paypal.jpg" alt="" width="90"></span> </label>
                        </li>
                      </ul>
                      <p class="text-xs-center"> <input type="submit" onclick="return confirm('Do you want to confirm the order?');" name="submit" class="btn btn-outline-success btn-block" value="Order now"> </p>
                    </div>
              </form>
            </div>
          </div>

      </div>
    </div>
    </form>
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
