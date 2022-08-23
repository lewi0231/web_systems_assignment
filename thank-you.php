<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Order Confirmation</title>

    <link rel="stylesheet" href="styles/style.css">
	  <link rel="stylesheet" href="styles/headerstyles.css">
    <link rel="stylesheet" href="styles/shopping-cart.css">
    <script defer src="https://kit.fontawesome.com/f1e877ccee.js" crossorigin="anonymous"></script>

</head>
<body>

<?php include('header.php'); ?>

<div class="container">
    <div class="content-container">
        <div class="left-content">
            <h1>Thank you <span id="customer-name">
                
            <?php echo $_GET['name']; ?>
        
        </span>!</h1>
            <h4>Your order number is <span id="order-number">
                
            <?php 
                echo $_GET['order'];
            ?>
        
        </span></h4>

            <p>An email will be sent containing information about your purchase.</p>
                
            <p>Create an account for a faster checkout in the future.</p>

        </div>

        <div class="right-content">
            <?php 
            require_once "order-summary.php"; 
            session_destroy();
            ?>
        </div>
    </div>
    </div>

</body>