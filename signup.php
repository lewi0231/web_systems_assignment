<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/signup.css">
    <link rel="stylesheet" href="styles/headerstyles.css">
    <link rel="stylesheet" href="styles/footerstyles.css">

    <title>Signup</title>
</head>

<body>

  <?php
  include('header.php');
  ?>

    <section>
        <div class="signup-form-container">
            <div class="heading-container">
                <h1 class="signup-heading">
                    Create an account
                </h1>
            </div>
            <div class="form-container">
                <form action="includes/signup.inc.php" method="post" class="signup-form">

                    <?php 
                    // This checks for form errors and repopulates fields where there has been no error - except for passwords
                    if (isset($_GET['error']) and $_GET['error'] == 'none'){
                      header('Location: account-home.php');
                      exit();
                    } 

                    if (isset($_GET['username'])){
                      echo "<input type='text' id='username' name='username' value='" . $_GET['username'] . "' required>";
                    } else {
                      echo "<input type='text' id='username' name='username' placeholder='Username *' required>";
                      if ($_GET["error"] == "username") {
                        echo "<p>Please choose a proper username!</p>";
                      } 
                      else if ($_GET["error"] == "usernametaken") {
                        echo "<p>That username has been taken!</p>";
                      }
                    }
                    if (isset($_GET['first'])){
                      echo "<input type='text' id='first' name='first' value='" . $_GET['first'] . "' required>";
                    } else {
                      echo "<input type='text' id='first' name='first' placeholder='First Name *' required>";
                    }

                    if (isset($_GET['first'])){
                      echo "<input type='text' id='last' name='last' value='" . $_GET['last'] . "' required>";
                    } else {
                      echo "<input type='text' id='last' name='last' placeholder='Last Name *' required>";
                    }

                    if (isset($_GET['email'])){
                      echo "<input type='email' id='email' name='email' value='" . $_GET['email'] . "' required>";
                    } else {
                      echo "<input type='email' id='email' name='email' placeholder='Email *' required>";
                      if ($_GET["error"] == "email") {
                        echo "<p>Please choose a proper email address!</p>";
                      } 
                      else if ($_GET["error"] == "emailexists") {
                        echo "<p>That email has already been taken!</p>";
                      }
                    }

                    ?>

                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="password" id="password" name="confirm-password" placeholder="Confirm Password *" required>

                    <?php
                      if ($_GET["error"] == "password") {
                        echo "<p>Please make sure that password's match</p>";
                      } 
                      else if ($_GET["error"] == "emptyinput") {
                        echo "<p>Please fill in all fields!</p>";
                      }
                      else if ($_GET["error"] == "custstatementerror") {
                        echo "<p>Something went wrong, please try again!</p>";
                      }
                    ?>
                    <!-- <label for"submit-button"></label> -->
                    <input type="submit" id="submit-button" name="submit-button" value="Create Your Account">
                </form>
            </div>

        </div>
    </section>
</body>

<?php
include('footer.php');
?>

</html>