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

                <div class="cart-item">
                    <div class="cart-product-info-row">
                        <img class="cart-item-img" src='https://www.converse.com.au/media/catalog/product/cache/506b4e978a2aaf2437105399caeb33bd/u/n/unisex_converse_chuck_taylor_all_star_70_high_top_black_162050_0.jpg' alt='Converse chuck taylor'/>

                        <div class="cart-product-info">
                            <form action="checkout.php" method="post">
                                <h4 name='name' class="cart-item-name"><a href="#">Converse Chuck 70</a></h4> <!-- link back to product page -->
                                <span>Colour: <span name='colour'>black</span></span><br>
                                <span>Size: <span name='size'>10</span></span><br>
                                <a href="#" class="cart-item-remove">Remove</a>
                            </form>
                        </div>
                    </div>

                    <div class="cart-product-info-row-two">
                        <div class="qty-update-combine">
                            <!-- <form> -->
                                <button type="button" class="qty-change-button">-</button>
                                <input value="1" type="number" id="number" min="1" max="99">
                                <button type="button" class="qty-change-button">+</button>
                            <!-- </form> -->
                        </div>
        
                        <span class="cart-product-price">$140.00</span>
                    </div>
                    
                </div>

                <hr>
            </div>

            <div class="right-content">
                <h2 id="order-title">Order Summary</h2>
                <div class="order-summary">
                        <label for="promo-code" id="promo-code">Discount Code</label>
                        <div class="flex-row">
                            <input type="text" name="promo-code" id="promo-code" />
                            <button type="button" class="button" id="apply-promo-code">Apply</button>
                        </div>
                    <hr>

                    <span>Delivery</span>
                    <ul>
                        <li>Standard</li>
                        <li>Express</li>
                        <li>Click and Collect</li>
                    </ul> -->
                    <select name="delivery" id="delivery">
                        <option value="standard">Standard ($7.00)</option>
                        <option value="express">Express ($10.00)</option>
                        <option value="collect">Click and Collect (FREE)</option>
                    </select>

                    <hr>
                    <div class="flex-row">
                        <span>Subtotal</span>
                        <span>$$</span>                    
                    </div>

                    <div class="flex-row">
                        <span>Delivery</span>
                        <span>$</span>                    
                    </div>

                    <hr>

                    <div class="flex-row">
                        <span>Total</span>
                        <span>$$$</span>                    
                    </div>

                    <button type="submit" id="" class="checkout-button button">Checkout</button>

                </div>

            </div>
        </div>
    </div>

    <!-- Footer here after main content container -->
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>