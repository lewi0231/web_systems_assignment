<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/headerstyles.css">
    <link rel="stylesheet" href="styles/footerstyles.css">
    <script src="scripts/checkout-scripts.js" defer></script>
    <link rel="stylesheet" href="styles/shopping-cart.css">
    <script defer src="https://kit.fontawesome.com/f1e877ccee.js" crossorigin="anonymous"></script>

</head>
<body>
    <!-- Navigation -->
<?php include('header.php'); ?>

<div class="container">
    <div class="content-container">
        <div class="left-content">
            <form action="includes/checkout.inc.php"method='post'>
            <h1>Checkout</h1>
            <h2>Contact Details</h2>
            <div id="form-email" >

            <?php 

            // this checks to see if someone has navigated from the shopping cart, in which case there should be a delivery amount contained within the form - this sets it inside of the session.
            if (isset($_POST['delivery'])){
                $dCostLabel = $_POST['delivery'];
                if ($dCostLabel === 'standard'){
                    $_SESSION['delivery'] = 7.00;
                } else if ($dCostLabel === 'express'){
                    $_SESSION['delivery'] = 10.00;
                } else {
                    $_SESSION['delivery'] = 0.00;
                }
            }

            // Checks if the user is already logged in so as to automatically enter the email address
            if (isset($_SESSION['email'])){
                $email = $_SESSION['email'];

                echo "<input type='email' name='email' id='email' class='long-input' value='" . $email .  "'required/>";
                echo "<hr>";
            } 
            else if (isset($_SESSION['checkout']['contact']['email'])) {
                $email = $_SESSION['checkout']['contact']['email'];

                echo "<input type='email' name='email' id='email' class='long-input' value='" . $email .  "'required/>";
                echo "<hr>";
            } 
            else {
                echo "<input type='email' name='email' id='email' class='long-input' placeholder='Email *' 'required/>";

                // If the url information flag the customer as needing to return to finish checkout
                echo "<p>Already have an account? <a href='login.php?message=checkoutinprocess'>Log in</a></p><hr>";
            }
            ?>
            </div>

            <div id="form-shipping" >
            <h2>Shipping</h2>


            <!-- Check if logged in and therefore we know their name-->
        <?php 
            if (isset($_SESSION['first_name'])){
                $firstname = $_SESSION['first_name'];
                $lastname = $_SESSION['last_name'];

                echo "<input type='text' name='firstname' id='firstname' class='short-input' value='" . $firstname . "'' required minlength='2' data-required-msg='Please enter a value for First Name'/>";
                echo "<input type='text' name='lastname' id='lastname' class='short-input' value='" . $lastname . "'' required minlength='2' data-required-msg='Please enter a value for Last Name'/>";
            }             
            else if (isset($_SESSION['checkout']['contact']['first']) and isset($_SESSION['checkout']['contact']['last'])) {
                $firstname = $_SESSION['checkout']['contact']['first'];
                $lastname = $_SESSION['checkout']['contact']['last'];
                
                echo "<input type='text' name='firstname' id='firstname' class='short-input' value='" . $firstname . "'' required minlength='2' data-required-msg='Please enter a value for First Name'/>";
                echo "<input type='text' name='lastname' id='lastname' class='short-input' value='" . $lastname . "'' required minlength='2' data-required-msg='Please enter a value for Last Name'/>";
            } 
            else {
                echo "<input type='text' name='firstname' id='firstname' class='short-input' placeholder='First Name *'' required minlength='2' data-required-msg='Please enter a value for First Name'/>";
                echo "<input type='text' name='lastname' id='lastname' class='short-input' placeholder='Last Name *'' required minlength='2' data-required-msg='Please enter a value for Last Name'/>";

            }
        ?>        
                <br>
                <?php 
                // checks if the the user is logged in and has a preferred shipping address - this would never be true (currently) as the preferred shipping address is not currently able to be set up.
                    if (isset($_SESSION['shipping_id'])){
                        if ($_SESSION['shipping_id']){
                            $shipping_id = $_SESSION['shipping_id'];
                            $address = get_address_by_id($conn, $shipping_id);
                            $street_address = $address['street_address'];
                            $suburb = $address['suburb'];
                            $state = $address['state'];
                            $postcode = $address['postcode'];
                            
                            echo "<input type='text' name='address-line-one' id='address-line-one' class='long-input' value='" . $street_address . "' required data-required-msg='Please enter a value for Address'/>";
                            echo "<br><input type='text' name='address-line-two' id='address-line-two' class='long-input' placeholder='Address Line 2'/>";
                            echo "<br><input type='text' name='suburb' id='suburb' class='short-input' value='" . $suburb . "' required data-required-msg='Please enter a value for Suburb'/>";
                            echo "<input type='text' inputmode='numeric' pattern='[0-9]{4}' name='postcode' id='postcode' class='short-input no-spinners' value='" . $postcode . "' required minlength='4' data-required-msg='Please enter a value for Postcode'/>";
                            echo "<input type='tel' name='phone' id='phone' class='short-input' value='";
                            
                            if (isset($_SESSION['phone'])){
                                if ($_SESSION['phone']){
                                    echo "value='" . $phone . "' required minlength='6' data-required-msg='Please enter a value for Phone Number'/>";
                                } else {
                                    echo "placeholder='Phone *' required minlength='6' data-required-msg='Please enter a value for Phone Number'/>";
                                    
                                }       
    
                            }
                            
                        }
                    } 
                    // populates the shipping fields if they have been returned to this page from the checkout.inc.php - not currently set up to do this.
                    else if (isset($_SESSION['checkout']['shipping'])){
                        $shipping = $_SESSION['checkout']['shipping'];
                        $street_address = $shipping['street1'];
                        $street_address_line2 = $shipping['street2'];
                        $suburb = $shipping['suburb'];
                        $postcode = $shipping['postcode'];
                        $phone = $_SESSION['checkout']['contact']['phone'];

                        echo "<input type='text' name='address-line-one' id='address-line-one' class='long-input' value='" . $street_address . "' required data-required-msg='Please enter a value for Address'/>";
                        echo "<br><input type='text' name='address-line-two' id='address-line-two' class='long-input' placeholder='Address Line 2'/>";
                        echo "<br><input type='text' name='suburb' id='suburb' class='short-input' value='" . $suburb . "' required data-required-msg='Please enter a value for Suburb'/>";
                        echo "<input type='text' inputmode='numeric' pattern='[0-9]{4}' name='postcode' id='postcode' class='short-input no-spinners' value='" . $postcode . "' required minlength='4' data-required-msg='Please enter a value for Postcode'/>";
                        echo "<input type='tel' name='phone' id='phone' class='short-input' value='" . $phone . "' required minlength='6' data-required-msg='Please enter a value for Phone Number'/>";
                    }
                    
                    else {
                        echo "<input type='text' name='address-line-one' id='address-line-one' class='long-input' placeholder='Address Line 1 *' required data-required-msg='Please enter a value for Address'/>";
                        echo "<br><input type='text' name='address-line-two' id='address-line-two' class='long-input' placeholder='Address Line 2'/>";
                        echo "<br><input type='text' name='suburb' id='suburb' class='short-input' placeholder='Suburb *' required data-required-msg='Please enter a value for Suburb'/>";
                        echo "<input type='text' pattern='[0-9]{4}' name='postcode' id='postcode' class='short-input no-spinners' placeholder='Postcode *' required minlength='4' data-required-msg='Please enter a value for Postcode'/>";
                        echo "<input type='tel' name='phone' id='phone' class='short-input' placeholder='Phone *' required minlength='6' data-required-msg='Please enter a value for Phone Number'/>";
                        
                    }
                    
                ?>
                
                <br>
                <!-- may use below to toggle shipping in future ***-->
                <!-- <button type="submit" id="continue-button" name='continue-submit' onclick="toggleShipping()" class="button">Continue</button>  -->
                <!-- <button type="submit" id="continue-button" name='continue-submit'  class="button">Continue</button>  -->
            </div>
                <hr>
                <h2>Payment</h2>
                <h4>Billing Address</h4>
                    <div id="form-billing-check">
                        <input type="checkbox" id="billing-checkbox" name="billing-checkbox" checked onclick="formBillingHide(this)">
                        <label for="billing-checkbox">Same as shipping address?</label>
                <!-- </form> -->
                <!-- <form action="includes/checkout.inc.php" method="post"> -->
                
                <!-- Checked by default, if unchecked show form and hide first place-order-button -->
                <br>
                <br>
            </div>


            <div id="form-billing" class="hidden"> <!-- class="hidden" -->
            <?php 
            // this confirms if the billing address has been stored (i.e., if they have been returned from checkout.inc.php for any reason)
                if (isset($_SESSION['checkout']['billing'])){
                    $billing = $_SESSION['checkout']['billing'];
                    $first = $billing['first'];
                    $last = $billing['last'];
                    $street_address = $billing['street1'];
                    $street_address_line2 = $billing['street2'];
                    $suburb = $billing['suburb'];
                    $postcode = $billing['postcode'];

                    echo "<input type='text' name='firstname-billing' id='firstname-billing' class='short-input' placeholder='First Name *' minlength='2' value='" . $first . "' data-required-msg='Please enter a value for First Name'/>";
                    echo "<input type='text' name='lastname-billing' id='lastname-billing' value='" . $last . "' class='short-input' placeholder='Last Name *' minlength='2' data-required-msg='Please enter a value for Last Name'/>";
                    echo "<input type='text' name='address-line-one-billing' id='address-line-one-billing' value='" . $street_address . "' class='long-input' placeholder='Address Line 1 *' required data-required-msg='Please enter a value for Address'/><br>";
                    echo "<input type='text' name='address-line-two-billing' id='address-line-two-billing'  class='long-input' placeholder='Address Line 2 *' /><br>";
                    echo "<input type='text' name='suburb-billing' value='" . $suburb . "' id='suburb-billing' class='short-input' placeholder='Suburb *' required data-required-msg='Please enter a value for Suburb'/>";
                    echo "<input type='text' name='postcode-billing' pattern='[0-9]{4}' id='postcode-billing' value='" . $postcode . "' class='short-input' placeholder='Postcode *' data-required-msg='Please enter a value for Postcode' required/>";
                } 
                else {
                    echo "<input type='text' name='firstname-billing' id='firstname-billing' class='short-input' placeholder='First Name *' minlength='2' data-required-msg='Please enter a value for First Name'/>";
                    echo "<input type='text' name='lastname-billing' id='lastname-billing' class='short-input' placeholder='Last Name *' minlength='2' data-required-msg='Please enter a value for Last Name'/><br>";
                    echo "<input type='text' name='address-line-one-billing' id='address-line-one-billing'  class='long-input' placeholder='Address Line 1 *' required data-required-msg='Please enter a value for Address'/><br>";
                    echo "<input type='text' name='address-line-two-billing' id='address-line-two-billing'  class='long-input' placeholder='Address Line 2 *' /><br>";
                    echo "<input type='text' name='suburb-billing' id='suburb-billing' class='short-input' placeholder='Suburb *' required data-required-msg='Please enter a value for Suburb'/>";
                    echo "<input type='text' name='postcode-billing' pattern='[0-9]{4}' id='postcode-billing' class='short-input' placeholder='Postcode *' data-required-msg='Please enter a value for Postcode' required/>";

                }
            
            
            ?>

            </div>
            <hr>
            <div id="form-card-details"  > 
                <!-- <h2>Payment</h2> -->
                <h4>Card Details</h4>
                <input type="text" inputmode="numeric" pattern="[0-9]{10, 16}" name="card-number" id="card-number" class="long-input" placeholder="Card Number *" maxlength="19" data-required-msg="Please enter a value for Card Number"/>
                <br>
                <input type="text" inputmode="numeric" pattern="(0?[1-9]|1[0-2])/(2[1-9])" name="exp-date" id="exp-date" class="short-input" placeholder="Expiry Date (MM/YY) *" required data-required-msg="Please enter a value for Expiry Date"/>
                <input type="text" inputmode="numeric" pattern="[0-9]{3}" name="cvv" id="cvv" class="short-input" placeholder="CVV/CVC *" minlength="3" required data-required-msg="Please enter a value for CVV"/>
                <br>
                <input type="submit" name='final-submit' id="place-order-button" class="button long-input" value="Place Your Order"/>
            </div>

            <p>By placing your order, you agree to our Privacy Policy and Terms & Conditions.</p>
        </form>

        </div>

        <div class="right-content">
            <?php 

            include("order-summary.php"); 
            
            ?>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include('footer.php'); ?>
    
</body>
</html>