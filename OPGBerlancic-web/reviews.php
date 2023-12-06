<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "productdb";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

function addReview($userName, $content, $connection)
{
    $stmt = $connection->prepare("INSERT INTO reviews (user_name, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $userName, $content);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$user = $_SESSION['user_name'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    $reviewContent = $_POST['reviewContent'];

    // Add the review to the database
    addReview($user, $reviewContent, $connection);

    // Return a JSON response
    echo json_encode(['success' => true]);
    exit;
}

$reviews = [];
$result = $connection->query("SELECT * FROM reviews ORDER BY id = 29 DESC, created_at DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            'user' => $row['user_name'],
            'content' => $row['content'],
            'created_at' => $row['created_at'],
        ];
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding-top: 20px;
        }

        .review-card {
            margin-bottom: 20px;
            padding: 15px;
        }

        form {
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 15px;
        }

        textarea {
            width: 100%;
            height: 100px;
            resize: vertical;
        }
    </style>
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
              <a href="naslovnica.php#kontakt" class="nav-link">Kontakt</a>
            </li>
            <li class="nav-item">
              <a href="reviews.php" class="nav-link active">Recenzije</a>
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
    <div class="container">
        <br>
        <?php if (isset($_SESSION['user_name']) || isset($_SESSION['admin_name'])) : ?>
            <form id="reviewForm">
                <h3>Recenzije</h3>
                <div class="mb-3">
                    <label for="reviewContent" class="form-label">Vaša recenzija:</label>
                    <textarea class="form-control" id="reviewContent" name="reviewContent" required></textarea>
                </div>
                <button type="button" id="submitReview" class="btn btn-primary">Pošalji</button>
            </form>
        <?php endif; ?>
        <div id="reviewsContainer">
            <?php foreach ($reviews as $review) : ?>
                <div class="card review-card">
                    <div class="card-body">
                        <p class="card-text"><strong><?= $review['user'] ?>:</strong> <?= $review['content'] ?></p>
                        <p class="card-text"><small class="text-muted">Published on <?= $review['created_at'] ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
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

    <!-- Bootstrap JS and Popper.js (required for some Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Handle review form submission
            $("#submitReview").click(function () {
                // Get the review content
                var reviewContent = $("#reviewContent").val().trim();

                // Check if the review content is not empty
                if (reviewContent !== "") {
                    $.ajax({
                        type: "POST",
                        url: "submit_review.php",
                        data: $("#reviewForm").serialize(),
                        success: function (response) {
                            var result = JSON.parse(response);

                            if (result.success) {
                                // Reload reviews without refreshing the page
                                loadReviews();
                                // Clear the textarea
                                $("#reviewContent").val("");
                            } else {
                                console.log("Failed to submit review");
                            }
                        },
                    });
                } else {
                    // Alert the user that the review content is empty
                    alert("Recenzija ne smije biti prazna. Unesite vašu recenziju.");
                }
            });

            // Function to load reviews
            function loadReviews() {
                $.ajax({
                    type: "GET",
                    url: window.location.href,
                    success: function (response) {
                        // Update the reviews container
                        $("#reviewsContainer").html($(response).find("#reviewsContainer").html());
                    },
                });
            }
        });
    </script>
</body>

</html>