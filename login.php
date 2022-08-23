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
    <title>Login Page</title>
</head>

<body>
   
   <?php
    include('header.php');
    ?>

    <section>
        <div class="login-form-container">
            <div class="heading-container">
                <h1 class="signup-heading">
                    Log in to your account
                </h1>
            </div>
            <div class="form-container"> 

              <?php 
              // This checks whether the user has come from checkout - in which case they should be sent back after logging in
                // if (isset($_GET['message'])){
                //   if ($_GET['message'] === 'checkoutinprocess'){
                //     echo "<form action='includes/login.inc.php?message=checkoutinprocess' method='post' class='login-form'>";
                //   }
                // } else {
                    echo "<form action='includes/login.inc.php' method='post' class='login-form'>"; 
                // }
              ?>
                    <input type="text" id="useremail" name="useremail" placeholder="Username/Email *" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="submit" id="submit-button" name="submit-button" value="Login">
                </form>
            </div>
            <?php
            // This checks for log-in errors - displaying the relevant feedback to the user.
            if (isset($_GET["error"])){
              if ($_GET["error"] == "emptyinput") {
                echo "<p>Please try again!</p>";
              }
              if ($_GET["error"] == "wrongpassword") {
                echo "<p>Please try entering your password again!</p>";
              }
              if ($_GET["error"] == "wronglogin") {
                echo "<p>Please enter a valid username and password!</p>";
              }
              if ($_GET["error"] == "none" & $_GET['message'] === "checkoutinprogress") {
                header('Location: checkout.php');
              } 
              else if ($_GET["error"] == "none") {
                header('Location: account-home.php');

              }
            }
            ?>
        </div>
    </section>


    <?php
    include('footer.php');
    ?>

  </body>
</html>