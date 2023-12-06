<?php
// Include your config file and other necessary files
@include 'config.php';

session_start();

require_once('php\CreateDb.php');
require_once('php\component.php');

$database = new CreateDb("Productdb", "Producttb");

// Check if the 'add' form is submitted
if(isset($_POST['add'])) {
    // Check if the user is not logged in, display message and redirect to login page
    if (!isset($_SESSION['user_name']) && !isset($_SESSION['admin_name'])) {
        echo "<script>alert('Morate se prijaviti da biste dodali proizvod u košaricu.')</script>";
        echo "<script>window.location = 'login_form.php'</script>";
        exit(); // Stop further execution
    }

    $product_id = $_POST['product_id'];

    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'], "product_id");

        if(in_array($product_id, $item_array_id)){
            echo "<script>alert('Proizvod je već u košarici!')</script>";
            echo "<script>window.location = 'index.php'</script>";
        } else {
            // If the product is not already in the cart, add it
            $item_array = array(
                'product_id' => $product_id
            );

            $_SESSION['cart'][] = $item_array;
        }
    } else {
        // If the cart session variable is not set, create it and add the product
        $item_array = array(
            'product_id' => $product_id
        );
        $_SESSION['cart'] = array($item_array);
    }
}
?>

<!-- Rest of your HTML code -->



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
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css"
    />
    <script type="module" src="./index.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
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
              <a href="index.php" class="nav-link active">Proizvodi</a>
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

   <section>
    <div class="container">
        <div class="row text-center py-5">
            <?php
              $result = $database->getData();
              while ($row = mysqli_fetch_assoc($result)){
                component($row['product_name'], $row['product_price'], $row['product_image'], $row['product_description'], $row['id']);
              }
            ?>
        </div>
    </div>
   </section>

   <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="cartItems">
            <!-- Display cart items here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

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
