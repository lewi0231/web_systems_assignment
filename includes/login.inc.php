<?php

// need to sort this out - returning logged in user to checkout.
if (isset($_POST['submit-button'])){
    $username = $_POST['useremail'];
    $password = $_POST['password'];
    
    include('functions.inc.php');
    $conn = get_connection();
    


    if (emptyInputLogin($username, $password) !== false){
        header("Location: ../login.php?error=emptyinput");
        exit(); 
    }

    // if ($_POST['message'] === 'checkoutinprocess'){
    //     loginUser($conn, $username, $password, true);
    // } else {
        loginUser($conn, $username, $password);

    // }
}


else {
        header("Location: ../login.php");  
        exit();
}
