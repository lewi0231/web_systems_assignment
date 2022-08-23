<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/shopping-cart.css">
    <link rel="stylesheet" href="styles/headerstyles.css">
    <link rel="stylesheet" href="styles/footerstyles.css">
    <script defer src="https://kit.fontawesome.com/f1e877ccee.js" crossorigin="anonymous"></script>

</head>
<body>

    <!-- Header Navigation bars here before main content container -->
    <?php include('header.php'); ?>

    <div class="container">
        <div class="content-container">
            <div class="left-content">
                <h1>Shopping Cart</h1>
                <table id="items-header">
                    <tr>
                        <td>Product</td>
                        <td>Qty</td>
                        <td>Price</td>
                    </tr>
                </table>

                <hr>

                <?php 
                    
                    include('includes/functions.inc.php');

                    if (isset($_SESSION['cart'])){
                        $conn = get_connection();
                        // iterates through each item within the shopping cart and displays them
                        foreach ($_SESSION['cart'] as $item){
                            $products = get_products_by_name($conn, $item['name']); 
                            $imgPath = "images/products/" . $products[0]['filename'];

                            echo "<div class='cart-item'>";
                                echo "<div class='cart-product-info-row'>";
                                    echo "<img class='cart-item-img' src='" . $imgPath . "' alt='" .  $item['brand'] . " " . $item['name'] . "'/>";
                                    echo "<div class='cart-product-info'>";
                                        echo "<form action='includes/remove-from-cart.inc.php' method='post'>";
                                        echo "<h4 class='cart-item-name'><a href='#'>" . $item['brand'] . " " . $item['name'] . "</a></h4>"; 
                                        echo "<input type='hidden' name='name' value='" . $item['name'] . "'>"; 
                                        echo "<input type='hidden' name='id' value='" . $item['id'] . "'>"; 
                                        echo "<span>Colour: <span name='colour'>" . $item['colour'] . "</span></span><br>";
                                        echo "<span>Size: <span name='size'>" . $item['size'] . "</span></span><br><br>";
                                        echo "<input type='submit' name='submit-remove'  class='cart-item-remove' value='Remove'></input>";
                                        echo "</form>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<div class='cart-product-info-row-two'>";
                                echo "<form action='includes/update-quantity.inc.php' method='post'>";
                                    echo "<div class='qty-update-combine'>";

                                        echo "<input type='submit' name='update-quantity' id='decrement-quantity' class='qty-change-button' value='-'>";
                                        echo "<input type='hidden' name='id' value='" . $item['id'] . "'/>";
                                        echo "<input name='current-quantity' value='" . $item['quantity'] . "' type='number' id='number' min='1' max='99'>";
                                        echo "<input type='submit' name='update-quantity' id='increment-quantity' class='qty-change-button' value='+' />";
                                    echo "</div>";
                                    echo "<span class='cart-product-price'>$" . $item['quantity'] * $item['price'] . "</span>";
                                    echo "</form>";
                                echo "</div>";
                            echo "</div>";
                            echo "<hr>";
                        }
                    } else {
                        echo "<p>nothing to show</p>";
                    }
                ?>

            </div>

            <div class="right-content">
                <h2 id="order-title">Order Summary</h2>
                <div class="order-summary">
                    <form action='checkout.php' method='post'>
                        <!-- <label for="promo-code" id="promo-code">Discount Code</label>
                        <div class="flex-row">
                            <input type="text" name="promo-code" id="promo-code" />
                            <button type="button" class="button" id="apply-promo-code">Apply</button>
                        </div>
                    <hr> -->

                    <span>Delivery:</span>
                    <ul>
                        <li class='bolden' id='standard-label'>Standard</li>
                        <li id='express-label'>Express</li>
                        <li  id='clickandcollect-label'>Click and Collect</li>
                    </ul> 
                    <select name="delivery" id="delivery">
                        <option value="standard" selected>Standard ($7.00)</option>
                        <option value="express">Express ($10.00)</option>
                        <option value="collect">Click and Collect (FREE)</option>
                    </select>

                    <hr>
                    <div class="flex-row">
                        <span>Subtotal</span>

                        <?php 
                            $defaultCost = 0;

                            if (isset($_SESSION['cart'])){
                                foreach ($_SESSION['cart'] as $item) {
                                    $defaultCost +=  floatval($item['price'] * $item['quantity']);
                                }
                                echo "<span id='subtotal'>$" . number_format($defaultCost, 2) . "</span>";
                            } else {
                                echo "<span id='subtotal'>$0.00</span>";
                            }
                        ?>                  
                    </div>

                    <div class="flex-row">
                        <span>Delivery</span>
                        <span id='delivery-cost'>$7.00</span>                  
                        <input name="delivery-hidden" id='delivery-hidden' type='hidden' value='7'>
                    </div>

                    <hr>

                    <div class="flex-row total-row">
                        <span>Total</span>

                        <?php 

                            if (isset($_SESSION['cart'])){
                                echo "<span id='total'>$" . number_format($defaultCost + 7.00, 2)  . "</span>";
                            } else {
                                echo "<span id='total'>$0.00</span>";
                            }

                        ?>  
                    
                    </div>

                    <button id='checkout-button' type="submit" name='submit' class="checkout-button button">Checkout</button>
                </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer here after main content container -->
    <script type="text/javascript" src="scripts/shopping-cart.js" defer></script>
    <?php
    include('footer.php');
    ?>
</body>
</html>