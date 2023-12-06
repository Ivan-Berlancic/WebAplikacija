<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "productdb";

$connection = new mysqli($servername, $username, $password, $database);

$product_name = "";
$product_price = "";
$product_image = "";
$product_description = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST["product_name"];
    $product_price = $_POST["product_price"];
    $product_image = $_POST["product_image"];
    $product_description = $_POST["product_description"];

    do {
        if(empty($product_name) || empty($product_price) || empty($product_image) || empty($product_description) ) {
            $errorMessage = "Sva polja su obavezna";
            break;
        }

        $sql = "INSERT INTO producttb (product_name, product_price, product_image, product_description) " .
                "VALUES ('$product_name',  '$product_price', '$product_image', '$product_description')";
        $result = $connection->query($sql); 

        if (!$result) {
            $errorMessage = "Invalid query: " . $conncetion->error;
            break;
        }

        $product_name = "";
        $product_price = "";
        $product_image = "";
        $product_description = "";

        $successMessage = "Proizvod je uspješno dodan";
        header("location: admin_page.php");
        exit;

    } while (false);
}

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
      <link rel="stylesheet" href="style.css" />
      <link rel="stylesheet" href="style_login.css" />
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js""></script>
      <title>OPG Berlančić</title>
   </head>
   <body>
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
               <li class="nav-item">
               <a href="admin_page.php" class="nav-link active">Admin</a>
               </li>
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
              <a href="cart.php" class="nav-link">
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
   
        <div class="container my-5">
            <h2>Novi proizvod</h2>
            <br>

            <?php
                if( !empty($errorMessage)){
                    echo "
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>$errorMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
                }
            ?>

            <form method="post">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Naziv</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Cijena</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="product_price" value="<?php echo $product_price; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Slika</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="product_image" value="<?php echo $product_image; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Opis</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="product_description" value="<?php echo $product_description; ?>">
                    </div>
                </div>

                <?php
                if ( !empty($successMessage) )  {
                    echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label>Close</button>
                        </div>
                    </div>
                    ";
                }
                ?>

                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <br>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="admin_page.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br>
        <footer class="p-3 bg-dark text-white text-center position-relative">
        <div class="container">
            <p class="lead">Copyright &copy; 2023 OPG Berlančić</p>
            <a href="#" class="position-absolute bottom-0 end-0 p-3">
            <i class="bi bi-arrow-up-circle h1"></i>
            </a>
        </div>
        </footer>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"
        ></script>
    </body>
</html>