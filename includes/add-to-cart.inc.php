<?php
session_start();

// Checks if the there is an existing cart
if (!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

// adds new item to the cart
if (isset($_POST['addToCart'])){

    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $colour = $_POST['colour'];
    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    $item = array('id' => $id, 'name' => $name,'brand' => $brand,'price' => $price,'size' => $size,'colour' => $colour, 'quantity' => $quantity);
    

    $_SESSION['cart'][] = $item;

}

// returns to index.php page
header('Location: ../index.php');
