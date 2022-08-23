<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles/footerstyles.css">
    <link rel="stylesheet" href="styles/account-home.css">
    <link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/headerstyles.css">
    <title>Account Home</title>
</head>
<body>

    <?php include('header.php'); ?>

<!-- This page may not get finished but provides a place for someone who has signed up to be navigated to (indicating that it has been successful) : ideally this will have a number of sidebar options (e.g., change / view contact details) -->

    <div id="account-home-container">
        <h2>Account Home</h2>
        <div id="account-info-container">
            <div id="customer-name">
                <h4>Name:</h4>
                <h4>
                    <?php 
                    if (isset($_SESSION['first_name'])){
                        echo " " . $_SESSION['first_name'] . " " . $_SESSION['last_name'];
                    } 
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>

    <?php
    include('footer.php');
    ?>
</body>
</html>