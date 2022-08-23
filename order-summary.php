<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<h2 id="order-title">Order Summary</h2>
<div class="order-summary">
    <ul>
        <?php 
        $subtotal = 0.00;

        if (!isset($_SESSION)){
        }

        // Retrieves current cart information and inserts it into order summary.  Still need to somehow obtain quantity from shopping-cart.php
        if (isset($_SESSION['cart'])){
            
            foreach ($_SESSION['cart'] as $item){
                echo "<li><div class='flex-row'><div><span class='final-item'>" . $item['brand'] . " " . $item['name'] . "</span><br>";
                echo "<span>" . $item['quantity'] . " - " . "Size: " . $item['size'] . ", " . "colour: " . $item['colour'] . "</span></div>";
                echo "<span class='item-price'>$" . number_format($item['quantity'] * floatval($item['price']), 2) . "</span></div></li>";

                $subtotal += $item['quantity'] * floatval($item['price']);
            }
        } 
        else {
            echo "You have not selected any items";
        }
        ?>


    <hr>
    <div class="flex-row"><span>Subtotal</span>

        <?php 
        // displays the subtotal (dynamically)
            echo "<span>$" . number_format($subtotal, 2) . "</span>";

        ?>

    </div>

    <div class="flex-row">
        <span>Delivery</span>

        <?php 
        $delivery = 0;
        // dynamically updates delivery amount as selected
        if (isset($_SESSION['delivery'])){
            $delivery = $_SESSION['delivery'];

            echo "<span>$" . number_format($delivery, 2) . "</span>";
        } else {
            $delivery = 7.00;
            echo "<span>$" . number_format($delivery, 2) . "</span>";

        }

        ?>
    </div>

    <hr>

    <div class="flex-row total-row">
        <span>Total</span>

        <?php 
        // displays total - dynamically - subtotal + delivery
            echo "<span>$" . number_format($subtotal + $delivery, 2) ."</span>";
        ?>   

    </div>
</div>