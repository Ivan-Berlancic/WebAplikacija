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

// Function to add a review to the database
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

// Check if the user is logged in
$user = $_SESSION['user_name'] ?? null;
$admin = $_SESSION['admin_name'] ?? null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($user || $admin)) {
    $reviewContent = $_POST['reviewContent'];

    // Add the review to the database
    addReview(($admin ? $admin : $user), $reviewContent, $connection);

    // Return a JSON response
    echo json_encode(['success' => true]);
    exit;
}

$connection->close();
?>
