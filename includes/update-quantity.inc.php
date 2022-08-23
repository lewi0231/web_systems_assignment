<?php
session_start();

if (isset($_POST['update-quantity'])){
    if ($_POST['update-quantity'] === '+'){
        $id = $_POST['id'];

        foreach ($_SESSION['cart'] as $key => $val) {

            if ($val['id'] == $id) {
                if ($val['quantity'] < 50) {
                    echo "the previous quantity for " . $val['name'] . " was " . $val['quantity'] . "<br>";
                    $_SESSION['cart'][$key]['quantity'] = ++$val['quantity'];
                    echo "the new quantity for " . $val['name'] . " is " . $val['quantity'] . "<br>";
                }
            }

        }

    } else if ($_POST['update-quantity'] === '-'){
        $id = $_POST['id'];

        if (isset($_SESSION['cart'])){
            foreach ($_SESSION['cart'] as $key => $val) {

            if ($val['id'] == $id) {
                if ($val['quantity'] > 1) {
                    echo "the previous quantity for " . $val['name'] . " was " . $val['quantity'] . "<br>";
                    $_SESSION['cart'][$key]['quantity'] = --$val['quantity'];
                    echo "the new quantity for " . $val['name'] . " is " . $val['quantity'] . "<br>";
                }
            }
        }
        }
    }

}


header("location: ../shopping-cart.php");
exit();

