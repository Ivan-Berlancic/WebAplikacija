<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

if( isset($_GET["id"])){
    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "productdb";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM producttb WHERE id=$id";
    $connection->query($sql);
}
header("location: admin_page.php");
exit;
?>