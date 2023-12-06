<?php

session_start();

// Check if the user is logged in and has the appropriate role
if (!(isset($_SESSION['user_name']) || isset($_SESSION['admin_name']))) {
    // Redirect to the login page if not logged in
    echo "<script>alert('Morate se prijaviti da biste pristupili košarici.')</script>";
    echo "<script>window.location = 'login_form.php'</script>";
    exit; // Stop further execution
}

// Check if the logged-in user is an admin
if (isset($_SESSION['admin_name'])) {
    // Admin has access to the cart.php file
} else {
    // If the user is not an admin, check if they have a user role
    if (!isset($_SESSION['user_name'])) {
        // Redirect to the login page if the user role is not set
        echo "<script>alert('Morate se prijaviti da biste pristupili košarici.')</script>";
        echo "<script>window.location = 'login_form.php'</script>";
        exit; // Stop further execution
    }
}

require_once ("php/CreateDb.php");
require_once ("php/component.php");

$db = new CreateDb("Productdb", "Producttb");

if (isset($_POST['remove']) && $_GET['action'] == 'remove') {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value["product_id"] == $_GET['id']) {
            unset($_SESSION['cart'][$key]);
            echo "<script>alert('Proizvod je uklonjen iz košarice...!')</script>";
            echo "<script>window.location = 'cart.php'</script>";
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

    <!-- Bootstrap CDN -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />

    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-md bg-dark navbar-dark py-3 fixed-top">
      <div class="container">
        <a href="#" class="navbar-brand">OPG Berlančić</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navmenu"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="naslovnica.php" class="nav-link">Naslovnica</a>
            </li>
            <li class="nav-item">
              <a href="o_nama.php" class="nav-link">Info</a>
            </li>
            <li class="nav-item">
              <a href="index.php" class="nav-link">Proizvodi</a>
            </li>
            <li class="nav-item">
              <a href="fotogalerija.php" class="nav-link">Fotogalerija</a>
            </li>
            <li class="nav-item">
              <a href="naslovnica.php#kontakt" class="nav-link">Kontakt</a>
            </li>
            <li class="nav-item">
               <a href="reviews.php" class="nav-link">Recenzije</a>
            </li>
            <?php if (isset($_SESSION['admin_name'])) { ?>
                    <li class="nav-item">
                        <a href="admin_page.php" class="nav-link">Admin</a>
                    </li>
            <?php } ?>
            <?php if (isset($_SESSION['user_name']) || isset($_SESSION['admin_name'])) { ?>
                <!-- If the user or admin is logged in, display Logout -->
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Logout</a>
                </li>
            <?php } else { ?>
                <!-- If the user or admin is not logged in, display Login -->
                <li class="nav-item">
                    <a href="login_form.php" class="nav-link">Login</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                    <a href="cart.php" class="nav-link active">
                        <div class="cart">
                            <i class="bi bi-cart4"></i>
                            <?php
                              if (isset($_SESSION['cart'])){
                                  $count = count($_SESSION['cart']);
                                  echo "<span id='cart_count' class='text-dark bg-light rounded-pill'>$count</span>";
                              }else{
                                  echo "<span id='cart_count' class='text-dark bg-light rounded-pill'>0</span>";
                              }
                              ?>
                        </div>
                    </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart" style="margin-top: 80px;">
                <h6>MOJA KOŠARICA</h6>
                <hr>

                <?php

                $total = 0;
                if (isset($_SESSION['cart'])) {
                    $product_id = array_column($_SESSION['cart'], 'product_id');
                
                    $result = $db->getData();
                    $index = 0; // Add this line to initialize the $index variable
                    while ($row = mysqli_fetch_assoc($result)) {
                        foreach ($product_id as $id) {
                            if ($row['id'] == $id) {
                                cartElement($row['product_image'], $row['product_name'], $row['product_price'], $row['product_description'], $row['id'], $index);
                                $total = $total + (int)$row['product_price'];
                                $index++; // Increment the index
                            }
                        }
                    }
                } else {
                    echo "<h5>Cart is Empty</h5>";
                }

                ?>

            </div>
        </div>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">

            <div class="pt-4">
                <h6>UKUPAN IZNOS</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                            if (isset($_SESSION['cart'])){
                                $count  = count($_SESSION['cart']);
                                echo "<h6>Cijena</h6>";
                            }else{
                                echo "<h6>CIjena</h6>";
                            }
                        ?>
                        <h6>Dostava</h6>
                        <hr>
                        <h6>Ukupan iznos</h6>
                    </div>
                    <div class="col-md-6">
                        <h6 class="total-price">€<?php echo $total; ?></h6>
                        <h6 class="text-success">BESPLATNO</h6>
                        <hr>
                        <h6 class="total-price">€<?php
                            echo $total;
                            ?></h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>