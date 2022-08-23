<?php
    session_start();
    if (isset($_SESSION['username'])){
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        unset($_SESSION['pref_pay_method']);
        unset($_SESSION['def_pay_details']);
        unset($_SESSION['shipping_id']);

        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['email']);
        unset($_SESSION['phone']);
    }

    header("Location: ../index.php" );