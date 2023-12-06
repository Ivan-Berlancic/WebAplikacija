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
              <a href="naslovnica.php" class="nav-link active">Naslovnica</a>
            </li>
            <li class="nav-item">
              <a href="o_nama.php" class="nav-link"><span class="d-inline">Info</span></a>
            </li>
            <li class="nav-item">
              <a
                href="index.php"
                class="nav-link"
                >Proizvodi</a
              >
            </li>
            <li class="nav-item">
              <a href="fotogalerija.php" class="nav-link">Fotogalerija</a>
            </li>
            <li class="nav-item">
              <a href="#kontakt" class="nav-link">Kontakt</a>
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

    <section class="p-5 text-center bg-light text-sm-start">
      <div class="container mx-auto">
        <div class="d-sm-flex align-items-center justify-content-between">
          <div class="text-center">
            <h1 class="display-1 custom-header">OPG Berlančić</h1>
            <p class="lead my-4">
              Malo obiteljsko gospodarstvo, vođeno s puno ljubavi!
            </p>
          </div>
          <div class="ml-auto order-sm-first">
            <img
              class="img-fluid w-75 d-none d-sm-block custom-shadow"
              src="koke.jpg"
              alt=""
            />
          </div>
        </div>
      </div>
    </section>

    <section class="p-5">
      <div class="container">
        <div class="row text-center g-4">
          <div class="col-md">
            <div class="card bg-dark text-light">
              <div class="card-body text-center">
                <div class="h1 mb-3">
                  <i class="bi bi-hammer"></i>
                </div>
                <h3 class="card-title mb-3">Početak</h3>
                <p class="card-text">Od starih paleta, do pravog malog raja.</p>
                <a href="o_nama.php" class="btn btn-info">Saznajte više</a>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card bg-dark text-light">
              <div class="card-body text-center">
                <div class="h1 mb-3">
                  <i class="bi bi-images"></i>
                </div>
                <h3 class="card-title mb-3">Kokoši</h3>
                <p class="card-text">Pogledajte kako izgledaju naše kokoši.</p>
                <a href="fotogalerija.php" class="btn btn-info"
                  >Saznajte više</a
                >
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card bg-dark text-light">
              <div class="card-body text-center">
                <div class="h1 mb-3">
                  <i class="bi bi-basket"></i>
                </div>
                <h3 class="card-title mb-3">Proizvodi</h3>
                <p class="card-text">Pogledajte koje proizvode nudimo.</p>
                <a href="index.php" class="btn btn-info">Saznajte više</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="p-5 bg-light">
      <div class="container">
        <h2 class="text-center mb-4">Često postavljena pitanja</h2>
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne"
                aria-expanded="false"
                aria-controls="flush-collapseOne"
              >
                Gdje mogu kupiti vaše proizvode?
              </button>
            </h2>
            <div
              id="flush-collapseOne"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingOne"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                Proizvode možete kupiti kod nas na adresi u kontaktu ili preko web shopa.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseTwo"
                aria-expanded="false"
                aria-controls="flush-collapseTwo"
              >
                Kakve opcije plaćanja nudite?
              </button>
            </h2>
            <div
              id="flush-collapseTwo"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                Dostupne su opcije plaćanja karticom ili plaćanja gotovinom.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseThree"
                aria-expanded="false"
                aria-controls="flush-collapseThree"
              >
                Postoji li popust na količinu?
              </button>
            </h2>
            <div
              id="flush-collapseThree"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingThree"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                Trenutačno ne nudimo opciju popusta na količinu, cijena jaja je
                ista za bilo koju količinu.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="kontakt" class="p-5">
      <div class="container">
        <div class="row g-4">
          <div class="col-md">
            <h2 class="text-center mb-4">Kontakt</h2>
            <ul class="list-group list-group-flush lead">
              <li class="list-group-item">
                <span class="fw-bold">Adresa:</span> Ulica kneza Domagoja 24,
                34550 Pakrac
              </li>
              <li class="list-group-item">
                <span class="fw-bold">Telefon:</span> +385 99 640 9641
              </li>
              <li class="list-group-item">
                <span class="fw-bold">E-mail:</span> opg.berlancic@gmail.com
              </li>
            </ul>
          </div>
          <div class="col-md" id="map"></div>
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
