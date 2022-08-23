<?php
function get_connection() {
    // comment out the following line when using in production
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpassword = "";
    $db = "ecommerce_db";  
    
    $conn = @mysqli_connect($dbhost, $dbuser, $dbpassword, $db);
    
    if (!$conn) {
        echo "Database connection failed!";
        error_log(mysqli_connect_error());
    }
    else {
        mysqli_set_charset($conn, "utf8mb4");
    }
    return $conn;  
}

// PRODUCT FUNCTIONS
function get_all_products($conn){
    $result = mysqli_query($conn, "SELECT * from product");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}


function get_product_details_by_id($conn, $id){
    $result = mysqli_query($conn, "SELECT * from product_details where product_id=$id");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_products_by_name($conn, $name){
    $amendedName = "%" . $name . "%";
    $query = "SELECT * FROM product WHERE name LIKE ?";

    $stmt = mysqli_stmt_init($conn);  
    $products = null;
    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "Statement error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $amendedName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $products;
}

function get_products_by_size($conn, $size){
    $query = "SELECT * from product where id in (select product_id from product_details where size = ?);";

    $stmt = mysqli_stmt_init($conn);  
    $products = null;
    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $size);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $products;
}

function get_products_by_colour($conn, $colour){
    $query = "SELECT * from product where id in (select product_id from product_details where colour = ?)";

    $stmt = mysqli_stmt_init($conn);  
    $products = null;

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $colour);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $products;
}

function get_product_by_brand($conn, $brand){
    $amendedBrand = "%" . $brand . "%";
    $query = "SELECT * from product where brand LIKE ?";

    $stmt = mysqli_stmt_init($conn);  
    $products = null;

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $amendedBrand);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $products;
}
function term_flexibility($term){
    $term = strtolower($term); //convert string to lowercase
    $mTerm = 'm';
    $fTerm = 'f';
    $uTerm = 'u';
    $male = array('male','man','men','boy','he');
    $female = array('female','woman','women','girl','she');
    $uniSex = array('uni', 'unisex', 'cross', 'genderless','sexless');
    for ($i=0; $i < count($male); $i++) { 
        if($term == $male[$i] || $term == $male[$i].'s'){
            return $mTerm;
        }
    }
    for ($i=0; $i < count($female); $i++) { 
        if($term == $female[$i] || $term == $female[$i].'s'){
            return $fTerm;
        }
    }
    for ($i=0; $i < count($uniSex); $i++) { 
        if($term == $uniSex[$i]){
            return $uTerm;
        }
    }
    return $term;
}
function get_products_by_sex($conn, $sex){
    $sex = term_flexibility($sex);
    $query = "SELECT * from product where id in (select product_id from product_details where sex = ?)";

    $stmt = mysqli_stmt_init($conn);  
    $products = null;

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $sex);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $products;
}

// Returns products that are less than or equal to 'price'
function get_product_by_price($conn, $price){
    $query = "SELECT * from product where id in (select product_id from product_details where price <= ?)";

    $stmt = mysqli_stmt_init($conn);  
    $products = null;

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $price);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $products;
}

function get_products_by_discount($conn){
    $result = mysqli_query($conn, "SELECT * from product where id in (select product_id from product_details where discount > 0)");
    $ret = array();
    while ($row = mysqli_fetch_assoc($result)){
        $ret[] = $row;
    }

    return $ret;
}

// Returns an array of products by the passed category
function get_products_by_category($conn, $category){
    $query = "SELECT * from product where category = ?";

    $stmt = mysqli_stmt_init($conn);  
    $products = null;

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $category);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
    }

    mysqli_stmt_close($stmt);
    return $products;
}

// ADDRESS FUNCTIONS

function check_address($conn, $street_address, $suburb, $postcode){
    $query = "SELECT id from address where street_address = ?  AND suburb = ? AND postcode = ?";

    $stmt = mysqli_stmt_init($conn);    

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $street_address, $suburb, $postcode);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            return $row['id'];
        }
    }
    mysqli_stmt_close($stmt);
    return false;
}

function get_address_by_id($conn, $id){
    $result = mysqli_query($conn, "SELECT * from address where id = " . $id);

    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }

}

function add_address($conn, $street_address, $street_address_2, $suburb, $postcode){
    $query = "INSERT INTO `address` (street_address, street_address_2, suburb, postcode)".
    "values (?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn);

    $last_id = null;
    
    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "Statement error";
    } else {
        mysqli_stmt_bind_param($stmt, "ssss", 
            $street_address, $street_address_2, $suburb, $postcode);

        $result = mysqli_stmt_execute($stmt);
        if ($result){
            $last_id = mysqli_insert_id($conn);
        }
    }
    mysqli_stmt_close($stmt);
    return $last_id;
}

// CUSTOMER FUNCTIONS

function add_customer($conn, $username, $password, $pref_pay_method, $def_pay_details, $shipping_id){
    $query = "INSERT INTO customer (username, password, pref_pay_method, def_pay_details, shipping_id)" .
    "values (?, ?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn); 
    $last_id = null;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    if (!mysqli_stmt_prepare($stmt, $query)) {
        return "StatementError";
    } else {
        mysqli_stmt_bind_param($stmt, "ssssi", 
            $username, $hashed_password, $pref_pay_method, $def_pay_details, $shipping_id );

        if (mysqli_stmt_execute($stmt)){
            $last_id = mysqli_insert_id($conn);
        }
    }
    mysqli_stmt_close($stmt);
    return $last_id;  
}

function check_customer($conn, $username){
    $query = "SELECT id from customer where username = ?";

    $stmt = mysqli_stmt_init($conn);  

    if (!mysqli_stmt_prepare($stmt, $query)){
        return "StatementError";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result)['id'];
    }

    mysqli_stmt_close($stmt);
    return null;
}

function get_customer_by_username($conn, $username, $password){
    $query = "SELECT * from customer where username = ? AND password = ?";

    $stmt = mysqli_stmt_init($conn);  

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "Statement error";
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    mysqli_stmt_close($stmt);
    return null;
}

// Internal query - thus the 'mysqli_query'
function get_customer_by_id($conn, $id){
    $result = mysqli_query($conn, "SELECT * from customer where id = " . $id);

    if ($result){
        if ($row = mysqli_fetch_assoc($result)){
            return $row;
        }
    } else {
        return false;
    }
}

// CONTACT FUNCTIONS

function check_contact($conn, $first, $last, $email, $phone){
    $query = "SELECT id from contact where first_name = ?  AND last_name = ? AND email = ? OR phone = ?;";

    $stmt = mysqli_stmt_init($conn);    

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL statement failed";
    } else {
        mysqli_stmt_bind_param($stmt, "ssss", $first, $last, $email, $phone);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result)['id'];
    }
    mysqli_stmt_close($stmt);
    return false;
}

function add_contact($conn, $first, $last, $email, $phone, $customer_id){
    $query = "INSERT INTO contact (first_name, last_name, email, phone, customer_id)".
    "values (?, ?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn); 
    $last_id = null;
    
    if (!mysqli_stmt_prepare($stmt, $query)) {
        return "StatementError";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ssssi", 
            $first, $last, $email, $phone, $customer_id);

        if (mysqli_stmt_execute($stmt)){
            $last_id = mysqli_insert_id($conn);
        }

    }
    mysqli_stmt_close($stmt);
    return $last_id;
}

function get_contact($conn, $customer_id){
    $query = "SELECT * from contact where customer_id = ?";

    $stmt = mysqli_stmt_init($conn);  

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    mysqli_stmt_close($stmt);
    return null;
}

// ORDER FUNCTIONS

function add_order_summary($conn, $total, $delivery_cost, $credit_card_num, $expiry, $cvv, $shipping_id, $billing_id, $customer_id, $contact_id) {
    $query = "INSERT INTO `order`(total, delivery_cost, credit_card_num, expiry, cvv, shipping_id, billing_id, customer_id, contact_id)".
    "values (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $hashed_credit_card_num = password_hash($credit_card_num, PASSWORD_DEFAULT);
    // $hashed_cvv = password_hash($cvv, PASSWORD_DEFAULT);
    
    $stmt = mysqli_stmt_init($conn); 
    $last_id = null;
    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "ddssiiiii", 
            $total, $delivery_cost, $hashed_credit_card_num, $expiry, $cvv, $shipping_id, $billing_id, $customer_id, $contact_id);

        if (mysqli_stmt_execute($stmt)){
            $last_id = mysqli_insert_id($conn);
        }

        mysqli_stmt_close($stmt);
        return $last_id;
    }
}

function get_order_summary($conn, $customer_id){
    $query = "SELECT * from `order` where customer_id = ?";

    $stmt = mysqli_stmt_init($conn);  
    $orders = array();

    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $orders[] = $row;
        }
    }

    mysqli_stmt_close($stmt);
    return $orders;
}

// ORDER_DETAILS FUNCTIONS

// Returns an array of the cost and quantity of products associated with a particular order
function get_order_details($conn, $order_id){
    $query = "SELECT * from `order_details` where order_id = ?";

    $stmt = mysqli_stmt_init($conn);  
    $order_details = array();
    if (!mysqli_stmt_prepare($stmt, $query)){
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)){
            $order_details[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $order_details;
}

function add_order_details($conn, $cost, $quantity, $product_id, $order_id){
    $query = "INSERT INTO order_details (cost, quantity, product_id, order_id)" .
    "values (?, ?, ?, ?);";
    
    $stmt = mysqli_stmt_init($conn); 

    if (!mysqli_stmt_prepare($stmt, $query)) {
        echo "SQL Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, "diii", 
            $cost, $quantity, $product_id, $order_id);

        return mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }
}

// SIGNUP FORM HANDLING FUNCTIONS

function emptySignupInput($username, $first, $last, $email, $password, $confirmPassword){
    $result = null;
    if (empty($username) || empty($first) || empty($last) || empty($email) || empty($password) || empty($confirmPassword)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username){
    $result = null;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result = null;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $confirmPassword){
    $result = null;
    if ($password !== $confirmPassword){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function usernameExists($conn, $username){
    $query = "SELECT * from customer where username = ?";

    $stmt = mysqli_stmt_init($conn);  

    if (!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../signup.php?error=statmenterror");
        exit();
    } 
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)){
        return $row;
        exit();
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);

}

function emailExists($conn, $email){
    $query = "SELECT * FROM customer WHERE id = (SELECT customer_id FROM contact WHERE email = ?);";

    $stmt = mysqli_stmt_init($conn);  

    if (!mysqli_stmt_prepare($stmt, $query)){
        header("Location: ../signup.php?error=statmenterror");
        exit();
    } 
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)){
        return $row;
        exit();
    } else {
        return false;
        exit();
    }

    mysqli_stmt_close($stmt);
}

// LOGIN FUNCTIONS

function emptyInputLogin($username, $password){
    return (empty($username) || empty($password));
}

function loginUser($conn, $username, $password, $checkout=false){
    $usernameExists = usernameExists($conn, $username);
    session_start();
    
    if ($usernameExists === false){
        $emailExists = emailExists($conn, $username);
        if ($emailExists === false){
            header("Location: ../login.php?error=wronglogin");
            exit();
        } else {
            $customerInfo = get_customer_by_id($conn, $emailExists['id']);
            $hashedPassword = $customerInfo['password'];
            $checkPassword = password_verify($password, $hashedPassword);

            if ($checkPassword === false){
                header("Location: ../login.php?error=wrongpassword");
                exit();
            } else {
                $_SESSION['username'] = $customerInfo['username'];
                $_SESSION['id'] = $customerInfo['id'];
                $_SESSION['pref_pay_method'] = $customerInfo['pref_pay_method'];
                $_SESSION['def_pay_details'] = $customerInfo['def_pay_details'];
                $_SESSION['shipping_id'] = $customerInfo['shipping_id'];
                
                $contact_details = get_contact($conn, $usernameExists['id']);
                $_SESSION['first_name'] = $emailExists['first_name'];
                $_SESSION['last_name'] = $emailExists['last_name'];
                $_SESSION['email'] = $emailExists['email'];
                $_SESSION['phone'] = $emailExists['phone'];

                // if ($checkout){
                //     echo "this is working";
                //     // header("Location: ../checkout.php");
                //     exit();
                // } else {
                header("Location: ../login.php?error=none");
                exit();

                // }
            }
        }
    } else {
        $hashedPassword = $usernameExists['password'];
        $checkPassword = password_verify($password, $hashedPassword);
        
        if ($checkPassword === false){
            header("Location: ../login.php?error=wrongpassword");
            exit();
        } else {
            $_SESSION['username'] = $usernameExists['username'];
            $_SESSION['id'] = $usernameExists['id'];
            $_SESSION['pref_pay_method'] = $usernameExists['pref_pay_method'];
            $_SESSION['def_pay_details'] = $usernameExists['def_pay_details'];
            $_SESSION['shipping_id'] = $usernameExists['shipping_id'];
            
            $contact_details = get_contact($conn, $usernameExists['id']);
            $_SESSION['first_name'] = $contact_details['first_name'];
            $_SESSION['last_name'] = $contact_details['last_name'];
            $_SESSION['email'] = $contact_details['email'];
            $_SESSION['phone'] = $contact_details['phone'];

            // if ($checkout){
            //     // echo "this is working";
            //     header("Location: ../checkout.php");
            //     exit();
            // } else {
                header("Location: ../login.php?error=none");
                exit();

            // }

        }
    }
}

// GET WOMEN RUNNERS
function get_womens($conn){
    $result = mysqli_query($conn, "SELECT * from product where id in (select product_id from product_details where sex = 'F' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_women_runners($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Running' and id in (select product_id from product_details where sex = 'F' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_women_sneakers($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Sneakers' and id in (select product_id from product_details where sex = 'F' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_women_sport($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Sport' and id in (select product_id from product_details where sex = 'F' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_women_hiking($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Hiking' and id in (select product_id from product_details where sex = 'F' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}
function get_mens($conn){
    $result = mysqli_query($conn, "SELECT * from product where id in (select product_id from product_details where sex = 'M' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}
function get_men_runners($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Running' and id in (select product_id from product_details where sex = 'M' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_men_hiking($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Hiking' and id in (select product_id from product_details where sex = 'M' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_men_sneakers($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Sneakers' and id in (select product_id from product_details where sex = 'M' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

function get_men_sport($conn){
    $result = mysqli_query($conn, "SELECT * from product where category = 'Sport' and id in (select product_id from product_details where sex = 'M' or sex = 'U')");

    $query_results = mysqli_num_rows($result);
    $ret = array();

    if ($query_results) {
        while($row = mysqli_fetch_assoc($result)){
            $ret[] = $row;
        }
    }
    return $ret;
}

// DISPLAY PRODUCTS IN CATALOGUE FUNCTION

function display_products($products){
    foreach($products as $product){
        $conn = get_connection();
        $product_details = get_product_details_by_id($conn, $product['id']);

        echo "<form action='product.php' method='get'>";
        echo "<div class='product'>";
        echo "<input type='image' width='400' height='auto' src='images/products/" . $product['filename'] . "'>";
        echo "<input type='hidden' name='name' value=" . "'" . $product['name'] . "'"  . ">";
        echo "</form>";
        
        // echo "<a class='p'>";
        echo "<div class='product_name'><a href='product.php?name=" . $product['name'] . "'><b>" . $product['brand'] . "</b> " . $product['name'] . "</a></div>";
        echo "<form action='includes/add-to-cart.inc.php' method='post'>";
        echo "<input type='hidden' name='name' value=" . "'" . $product['name'] . "'"  . ">";
        echo "<input type='hidden' name='brand' value=" . $product['brand']  . ">";
        echo "<div class='product_size'>Size: " . $product_details[0]['size'] . "</div>";
        // echo "</a>";
        echo "<input type='hidden' name='size' value=" . $product_details[0]['size']  . ">";
        echo "<div class=colour-price-container>";
        echo "<div class='product_colour'>Colour: " . $product_details[0]['colour'] . "</div>";
        echo "<input type='hidden' name='colour' value=" . $product_details[0]['colour']  . ">";
        echo "<div class='product_price'>$" . $product['price'] . "</div>";
        echo "</div>";
        echo "<input type='hidden' name='price' value=" . $product['price']  . ">";
        echo "<input type='hidden' name='id' value=" . $product['id']  . ">";
        echo "<input type='hidden' name='quantity' value=1>";
        echo "<input type='submit' name='addToCart' class='add2cart' value='Add to Cart'>";
        echo "</div>";
        echo "</form>";
    }
}

// Probably won't have time to implement below - looking at giving size options from the cataglogue.

// function test_display_products($products){
//     foreach($products as $product){
//         $conn = get_connection();
//         $product_details = get_product_details_by_id($conn, $product['id']);

//         echo "<form action='product.php' method='get'>";
//         echo "<div class='product'>";
//         echo "<input type='image' width='400' height='auto' src='images/products/" . $product['filename'] . "'>";
//         echo "<input type='hidden' name='name' value=" . "'" . $product['name'] . "'"  . ">";
//         echo "</form>";
        
//         // echo "<a class='p'>";
//         echo "<div class='product_name'><a href='product.php?name=" . $product['name'] . "'><b>" . $product['brand'] . "</b> " . $product['name'] . "</a></div>";
//         echo "<form action='includes/add-to-cart.inc.php' method='post'>";
//         echo "<input type='hidden' name='name' value=" . "'" . $product['name'] . "'"  . ">";
//         echo "<input type='hidden' name='brand' value=" . $product['brand']  . ">";
//         echo "<div class='product_size'>Size: ";
//         echo "<select name='size' id='productSize'>";

//              foreach($product_details as $option){
//                 echo "<option value='" . $option['size'] . "' name='size'>" . $option['size'] . "</option>"; 
//             }
                            
//         echo "</select></div>";
//         // echo "</a>";
//         echo "<input type='hidden' name='size' value=" . $product_details[0]['size']  . ">";
//         echo "<div class=colour-price-container>";
//         echo "<div class='product_colour'>Colour: " . $product_details[0]['colour'] . "</div>";
//         echo "<input type='hidden' name='colour' value=" . $product_details[0]['colour']  . ">";
//         echo "<div class='product_price'>$" . $product['price'] . "</div>";
//         echo "</div>";
//         echo "<input type='hidden' name='price' value=" . $product['price']  . ">";
//         echo "<input type='hidden' name='id' value=" . $product['id']  . ">";
//         echo "<input type='hidden' name='quantity' value=1>";
//         echo "<input type='submit' name='addToCart' class='add2cart' value='Add to Cart'>";
//         echo "</div>";
//         echo "</form>";
//     }
// }