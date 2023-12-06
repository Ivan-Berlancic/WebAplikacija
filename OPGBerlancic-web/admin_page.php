<?php

@include 'login_system\config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
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
   
   <div class="container">

      <div class="content">
         <br>
         <h1>Dobrodošli, <span><?php echo $_SESSION['admin_name'] ?></span></h1>
      
      </div>

   </div>
   <div class="container my-5">
      <h2>Popis proizvoda</h2>
      <a class="btn btn-primary" href="create.php" role="button">Novi proizvod</a>
      <br>
      <table class="table">
         <thead>
            <tr>
               <th>ID</th>
               <th>Product name</th>
               <th>Product price</th>
               <th>Product image</th>
               <th>Product description</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "productdb";

            $connection = new mysqli($servername, $username, $password, $database);

            if($connection->connect_error){
               die("Connection failed: " . $connection->connect_error);
            }

            $sql = "SELECT * FROM producttb";
            $result = $connection->query($sql);

            if(!$result){
               die("Invalid query: " . $connection->error);
            }

            while($row = $result->fetch_assoc()) {
               echo "
               <tr>
                  <td>$row[id]</td>
                  <td>$row[product_name]</td>
                  <td>$row[product_price]</td>
                  <td>$row[product_image]</td>
                  <td>$row[product_description]</td>
                  <td>
                     <a class='btn btn-primary btn-sm' href='edit.php?id=$row[id]'>Edit</a>
                     <a class='btn btn-danger btn-sm' href='delete.php?id=$row[id]'>Delete</a>
                  </td>
               </tr>
               ";
            }
            ?>
            
         </tbody>
      </table>
   </div>
   <div class="container my-5">
      <h2>Popis recenzija</h2>
      <br>
      <table class="table">
         <thead>
            <tr>
               <th>ID</th>
               <th>Username</th>
               <th>Sadržaj</th>
               <th>Datum</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "productdb";

            $connection = new mysqli($servername, $username, $password, $database);

            if($connection->connect_error){
               die("Connection failed: " . $connection->connect_error);
            }

            $sql = "SELECT * FROM reviews";
            $result = $connection->query($sql);

            if(!$result){
               die("Invalid query: " . $connection->error);
            }

            while($row = $result->fetch_assoc()) {
               echo "
               <tr>
                  <td>$row[id]</td>
                  <td>$row[user_name]</td>
                  <td>$row[content]</td>
                  <td>$row[created_at]</td>
                  <td>
                     <a class='btn btn-danger btn-sm' href='delete_review.php?id=$row[id]'>Delete</a>
                  </td>
               </tr>
               ";
            }
            ?>
            
         </tbody>
      </table>
   </div>
   <div class="container my-5">
      <h2>Popis korisnika</h2>
      <br>
      <table class="table">
         <thead>
            <tr>
               <th>ID</th>
               <th>Username</th>
               <th>Email</th>
               <th>Lozinka</th>
               <th>User</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "productdb";

            $connection = new mysqli($servername, $username, $password, $database);

            if($connection->connect_error){
               die("Connection failed: " . $connection->connect_error);
            }

            $sql = "SELECT * FROM user_form";
            $result = $connection->query($sql);

            if(!$result){
               die("Invalid query: " . $connection->error);
            }

            while($row = $result->fetch_assoc()) {
               echo "
               <tr>
                  <td>$row[id]</td>
                  <td>$row[name]</td>
                  <td>$row[email]</td>
                  <td>$row[password]</td>
                  <td>$row[user_type]</td>
                  <td>
                     <a class='btn btn-danger btn-sm' href='delete_user.php?id=$row[id]'>Delete</a>
                  </td>
               </tr>
               ";
            }
            ?>
            
         </tbody>
      </table>
   </div>
   <br>
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