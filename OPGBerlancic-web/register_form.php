<?php

@include 'config.php';

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   // Check if the email already exists
   $checkEmailQuery = "SELECT * FROM user_form WHERE email = '$email'";
   $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

   if(mysqli_num_rows($checkEmailResult) > 0){
      $error[] = 'Email already exists. Please choose a different email.';
   } else {
      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      } else {
         // Insert new user if email is not already registered
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($conn, $insert);
         // Initialize an empty cart for the registered user
         $_SESSION['user'] = ['email' => $email, 'cart' => []];
         header('location:login_form.php');
      }
   }
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
               <a href="register_form.php" class="nav-link active">Register</a>
               </li>
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
      <div class="form-container">

         <form action="" method="post">
            <h3>Register</h3>
            <?php
            if(isset($error)){
               foreach($error as $error){
                  echo '<span class="error-msg">'.$error.'</span>';
               };
            };
            ?>
            <input type="text" name="name" required placeholder="enter your name">
            <input type="email" name="email" required placeholder="enter your email">
            <input type="password" name="password" required placeholder="enter your password">
            <input type="password" name="cpassword" required placeholder="confirm your password">
            <select name="user_type">
               <option value="user" selected>user</option>
            </select>
            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>Već imate račun? <a href="login_form.php">Login</a></p>
         </form>

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