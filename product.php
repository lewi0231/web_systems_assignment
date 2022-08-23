<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product</title>
    <link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/headerstyles.css">
    <link rel="stylesheet" href="styles/footerstyles.css">
    <link rel="stylesheet" href="styles/product.css">
    <script src="scripts/simple-scripts.js" defer></script>
</head>


<body>
<?php 
    include('header.php'); 
    include('includes/functions.inc.php');
    $altImgName = "alt";

    if (isset($_GET["name"])){
        $conn = get_connection();
        $products = get_products_by_name($conn, $_GET["name"]);
        $productDetails = get_product_details_by_id($conn, $products[0]['id']);
    }
?>
<div class="container">
    <div class="content-container">
        <div class="breadcrumb-trail">
            <a href="index.php">Home </a>
            &nbsp;> <!-- inserts a space -->
            <form action='index.php' method='post'>
            <input type='submit' name='brand' value='<?php echo $products[0]["brand"]  ?>'></form>
            >
            <form action='index.php' method='post'>
            <input type='submit' name='category' value='<?php echo $products[0]["category"] ?>'></form>
            >
            <?php echo $products[0]["name"]?>
        </div>
        <div class="left-content">
            <img class="main-product-img" id="mainImg" style="opacity: 100;" src="images/products/<?php echo $products[0]["filename"]?>">
            <img class="alt-product-img"  src="images/products/<?php echo $altImgName.$products[0]["filename"]?>">

            <div class="img-overlay">
                <input type="button" onclick="toggle('mainImg')" id="arrow" name="arrow" value=">">
                <img src="images/products/<?php echo $products[0]["filename"]?>">
                <img src="images/products/<?php echo $altImgName.$products[0]["filename"]?>">
            </div>
        </div>
        <div class="right-content">
          <form action='includes/add-to-cart.inc.php' method='post'>
                <ul class="product-details-list-style">
                    <li>
                        <div id= "productBrand"> <?php echo $products[0]["brand"]?></div>
                    </li>
                    <li>
                        <div id= "productName"> <?php echo $products[0]["name"]?></div>
                    </li>
                    <li>
                        <div id= "productDesc"><?php echo $products[0]["description"]?></div>
                    </li>
                    <li>
                        <div id= "productPrice">$<?php echo $products[0]["price"]?></div>
                    </li>
                    <li>
                        <select name="size" id="productSize">
                            <?php foreach($productDetails as $option){
                                    echo "<option value='" . $option['size'] . "' name='size'>" . $option['size'] . "</option>"; 
                                }
                            ?>
                        </select>
                        <label for="sizes">Choose an available size</label>
                    </li>
                    <li>
                        <label for="quantity"></label>
                        <select name="quantity" id="productQuantity">
                            <option selected="selected" value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        <input type='hidden' name='name' value='<?php echo $products[0]["name"] ?>'>
                        <input type='hidden' name='brand' value='<?php echo $products[0]["brand"]  ?>'>
                        <input type='hidden' name='price' value='<?php echo $products[0]['price']  ?>'>
                        <input type='hidden' name='id' value='<?php echo $products[0]['id']  ?>'>
                        <input type='hidden' name='colour' value='<?php echo $productDetails[0]['colour']  ?>'>
                        <input type="submit" id="productAddCart" name="addToCart" value="Add To Cart">
                    </li>
                </ul>
            </form>
        </div>
        <div class="bottom-content">
            <div class="left-content">
                <ul class="product-details-list-style">
                    <li>
                        <h2> Details</h2>
                    </li>
                    <li>
                        Model: <?php echo $products[0]["name"]?>
                    </li>
                    <li>
                        Brand: <?php echo $products[0]["brand"]?>
                    </li>
                    <li>
                        Category: <?php echo $products[0]["category"]?>
                    </li>
                </ul>
            </div>
            <div class="left-content">
            <ul class="product-details-list-style">
                <li>
                    <h2>&nbsp;</h2>
                </li>
                <li>
                    Colour: <?php echo $productDetails[0]["colour"]?>
                </li>
                <li>
                    Size: <?php echo $productDetails[0]["size"]?>
                </li>
                <li>
                    Gender: <?php echo $products[0]["sex"]?>
                </li>
            </ul>
        </div>
        </div>
    </div>
</div>
<?php
    include('footer.php');
?>
</body>
</html>