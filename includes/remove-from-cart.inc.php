<?php
    if (isset($_POST['submit-remove'])){
        session_start();

        $id = $_POST['id'];
        // var_dump($_POST);

        foreach ($_SESSION['cart'] as $key => $val){
            if ($val['id'] == $id ){
                unset($_SESSION['cart'][$key]);
            }
        }
        var_dump($_SESSION['cart']);
    
    }

    header("Location: ../shopping-cart.php");

?>