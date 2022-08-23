<?php
include "functions.inc.php";
session_start();

$conn = get_connection();

if (isset($_POST["submit-button"])){
    $username = $_POST["username"];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if (emptySignupInput($username, $first, $last, $email, $password, $confirmPassword) !== false){
        header("Location: ../signup.php?error=emptyinput");
        exit();
    }
    else if (invalidUsername($username, $first, $last, $email, $password, $confirmPassword) !== false){
        header("Location: ../signup.php?error=username&email=" . $email . "&first=" . $first . "&last=" . $last);
        exit();
    }
    else if (invalidEmail($email) !== false){
        header("Location: ../signup.php?error=email&username=" . $username . "&first=" . $first . "&last=" . $last);
        exit();
    }
    else if (passwordMatch($password, $confirmPassword) !== false){
        header("Location: ../signup.php?error=password&username=" . $username . "&first=" . $first . "&last=" . $last . "&email=" . $email);
        exit();
    }
    else if (usernameExists($conn, $username) !== false){
        header("Location: ../signup.php?error=usernametaken&first=" . $first . "&last=" . $last . "&email=" . $email);
        exit();
    }
    // Only checks for existing customer email address
    else if (emailExists($conn, $email) !== false) {
        header("Location: ../signup.php?error=emailexists&username=" . $username . "&first=" . $first . "&last=" . $last);
        exit();
    }

    
    // Signup the new customer
    $cust_id = add_customer($conn, $username, $password, null, null, null);
    if ($cust_id === "StatementError"){
        header("Location: ../signup.php?error=custstatementerror");
        exit();
    } 
    else if ($cust_id !== null){
        
        $outcome = add_contact($conn, $first, $last, $email, null, $cust_id);

        
        if ($outcome === "StatementError"){
            header("Location: ../signup.php?error=contstatementerror");
            exit();
        }
        else if ($outcome !== null){

            $_SESSION['username'] = $username;
            $_SESSION['first_name'] = $first;
            $_SESSION['last_name'] = $last;
            $_SESSION['email'] = $email;

            $_SESSION['pref_pay_method'] = null;
            $_SESSION['def_pay_details'] = null;
            $_SESSION['shipping_id'] = null;
            $_SESSION['phone'] = null;
            
            header("Location: ../signup.php?error=none");
            exit();
        }
    }

} else {

    header("Location: ../signup.php");
    exit();
}