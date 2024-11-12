<?php
require_once 'globals.php';
require_once("connection/connect.php");

if (!IS_USER_LOGGED_IN) {
  header('location:login.php');
  exit();
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
  <title>Pedidos | BaiaoFood</title>
   <!-- icon da aba -->
   <link rel="icon" href="./icons/request.png" type="image/png">
   
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animsition.min.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style type="text/css" rel="stylesheet">
    .indent-small {
      margin-left: 5px;
    }

    .form-group.internal {
      margin-bottom: 0;
    }

    .dialog-panel {
      margin: 10px;
    }

    .datepicker-dropdown {
      z-index: 200 !important;
    }

    .panel-body {
      background: #e5e5e5;
      /* Old browsers */
      background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
      /* FF3.6+ */
      background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
      /* Chrome,Safari4+ */
      background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
      /* Chrome10+,Safari5.1+ */
      background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
      /* Opera 12+ */
      background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
      /* IE10+ */
      background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
      /* W3C */
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
      font: 600 15px "Open Sans", Arial, sans-serif;
    }

    label.control-label {
      font-weight: 600;
      color: #777;
    }


    table {
      width: 750px;
      border-collapse: collapse;
      margin: auto;

    }

    /* Zebra striping */
    tr:nth-of-type(odd) {
      background: #eee;
    }

    th {
      background: #ff3300;
      color: white;
      font-weight: bold;

    }

    td,
    th {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
      font-size: 14px;

    }


    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {

      table {
        width: 100%;
      }


      table,
      thead,
      tbody,
      th,
      td,
      tr {
        display: block;
      }


      thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
      }

      tr {
        border: 1px solid #ccc;
      }

      td {

        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
      }

      td:before {

        position: absolute;

        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;

        content: attr(data-column);

        color: #000;
        font-weight: bold;
      }

    }
  </style>

</head>

<body>
  <?php require_once 'header.php'; ?>
  <div class="page-wrapper">
    <div class="inner-page-hero bg-image" data-image-src="images/img/res.jpeg">
      <div class="container"> </div>
    </div>
    <div class="result-show">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </div>

    <section class="restaurants-page">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
          </div>
          <div class="col-xs-12 col-sm-7 col-md-7 ">
            <div class="bg-gray restaurant-entry">
              <div class="row">
                <table>
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Quantidade</th>
                      <th>Preço</th>
                      <th>Status</th>
                      <th>Data</th>
                      <th>Ação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query_res = mysqli_query($db, "select * from users_orders where u_id='" . $_SESSION['user_id'] . "'");
                    if (!mysqli_num_rows($query_res) > 0) :
                      echo '<td colspan="6"><center>Você ainda não fez nenhum pedido.</center></td>';
                    else :
                      while ($row = mysqli_fetch_array($query_res)) :
                    ?>
                        <tr>
                          <td data-column="Item"> <?php echo $row['title']; ?></td>
                          <td data-column="Quantidade"> <?php echo $row['quantity']; ?></td>
                          <td data-column="Preço">R$<?php echo $row['price']; ?></td>
                          <td data-column="Status">
                            <?php
                            $status = $row['status'];
                            if ($status == "" or $status == "NULL") :
                            ?>
                              <button type="button" class="btn btn-info" style="font-weight:bold;"><span class="fa fa-bars" aria-hidden="true"> Envio</button>
                            <?php
                            endif;
                            if ($status == "in process") : ?>
                              <button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> A Caminho!</button>
                            <?php
                            endif;
                            if ($status == "closed") :
                            ?>
                              <button type="button" class="btn btn-success"><span class="fa fa-check-circle" aria-hidden="true"> Entregue</button>
                            <?php
                            endif;
                            if ($status == "rejected") :
                            ?>
                              <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i> Cancelado</button>
                            <?php
                            endif;
                            ?>
                          </td>
                          <td data-column="Data"> <?php echo $row['date']; ?></td>
                          <td data-column="Ação"> <a href="delete_orders.php?order_del=<?php echo $row['o_id']; ?>" onclick="return confirm('Tem certeza de que deseja cancelar seu pedido?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a>
                          </td>
                        </tr>
                    <?php
                      endwhile;
                    endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </section>

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
