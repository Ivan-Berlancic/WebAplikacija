<?php

@include 'config.php';

session_start();

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
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
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
              <a href="o_nama.php" class="nav-link active">Info</a>
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

    <section class="p-5 bg-light">
      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-md">
            <img src="7.jpg" class="img-fluid custom-shadow" alt="" />
          </div>
          <div class="col-md p-5">
            <h2>Naš početak</h2>
            <p class="lead">
              Sve je počelo 2022. godine, kada smo odlučili iskoristiti stare
              palete kako bi napravili prvi kokošinjac. Izrada je trajala
              nekoliko mjeseci, iskoristili smo još neke materijale koje smo
              imali te smo dosta improvizirali.
            </p>
            <p class="lead">
              Za izradu vanjskog dijela koristili smo staru ogradu i stare
              limove za krov te smo uz pomoć vrhunskog limara sve složili.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="p-5 bg-dark text-light">
      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-md p-5">
            <h2>Kokoši nesilice</h2>
            <p class="lead">
              Naš OPG s ponosom uzgaja domaće kokoši nesilice koje imaju
              dovoljno prostora za život te im je osigurana sigurnost.
            </p>
            <p class="lead">
              Kokoši hranimo isključivo visokokvalitetnim kukuruzom, kojeg
              nabavljamo od lokalnog OPG-a.
            </p>
          </div>
          <div class="col-md">
            <img src="koke.jpg" class="img-fluid custom-shadow" alt="" />
          </div>
        </div>
      </div>
    </section>

    <section class="p-5 bg-light">
      <div class="container">
        <div class="row align-items-center justify-content-between">
          <div class="col-md">
            <img
              src="1688160655727.jpg"
              class="img-fluid custom-shadow"
              alt=""
            />
          </div>
          <div class="col-md p-5">
            <h2>Planovi za budućnost</h2>
            <p class="lead">
              Pošto trenutačno imamo vrlo ograničene količine proizvoda, u
              skoroj budućnosti planiramo proširiti našu proizvodnju, kupovinom
              više zemljišta. Na taj način ćemo moći povećati broj nesilica i
              poboljšati naše gospodarstvo.
            </p>
          </div>
        </div>
      </div>
    </section>

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
