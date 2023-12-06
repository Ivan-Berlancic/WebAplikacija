<?php

// Include the CreateDb class
include 'php\CreateDb.php'; // Adjust the path accordingly

// Instantiate the CreateDb class
$database = new CreateDb("Productdb", "Producttb");

// Call the getProductsData function
$productsData = $database->getProductsData();

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($productsData);

?>