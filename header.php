<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<!-- This is main navigation - used on every page -->

<header class="header">
<script defer src="https://kit.fontawesome.com/f1e877ccee.js" crossorigin="anonymous"></script>
	<div id="nav-row-1">
		<div class="nav-container">
			<div class = "logoarea combine">
				<use xlink:href=" " "><a id="logoLink" href="index.php">ShoeMe</a></use>
			</div>

			<div>
				<ul class="rightlist">
					<li class="dropdown">
						<a class="dropbtn" href="login.php">Account</a>
						<div class="dropdown-content">
							<?php 
							// Only displays login option if the user is not logged in
								if (!isset($_SESSION['username'])){
									echo "<a href='login.php'>Sign In</a>";
									echo "<a href='signup.php'>Create Account</a>";
								} else {
									// echo "<a href='signup.php'>Create Account</a>";
									echo "<a href='includes/signout.inc.php'>Sign Out</a>";
								}
							?>
						</div>
					</li>

					<li>
						
						<?php 
						// this adds a caption if the user hovers with the number of items in cart
						if (isset($_SESSION['cart'])){
							$itemLength = count($_SESSION['cart']);
							echo "<a class='a' title='" . $itemLength . " items' href='shopping-cart.php'><i class='fas fa-shopping-cart'></i></a>";
						} else {
							echo "<a class='a' title='0 items' href='shopping-cart.php'><i class='fas fa-shopping-cart'></i></a>";

						}
						?> 

					</li>
				</ul>
			</div>
		</div>
	</div>

	<div id="nav-row-2">
		<div class="nav-container">

			<div class = "menuarea combine">
				<div class ="headermenu">
					<ul>
						<li>
							<a href="index.php" class="a border">Home</a>
						</li>
						
						<li class="dropdown">
							<a href="allWomens.php" class="a border dropbtn">Women's</a>
							<div class="dropdown-content">
								<a href="runnersWomen.php">Runners</a>
								<a href="hikingWomen.php">Hiking</a>
								<a href="sportWomen.php">Sport</a>
								<a href="sneakersWomen.php">Sneakers</a>
							</div>	
						</li>
						
						<li class="dropdown">
							<a href="allMens.php" class="a border dropbtn">Men's</a>
							<div class="dropdown-content">
									<a href="runnersMen.php">Runners</a>
									<a href="hikingMen.php">Hiking</a>
									<a href="sportMen.php">Sport</a>
									<a href="sneakersMen.php">Sneakers</a>
							</div>	
						</li>

						<li>
							<a href="sale.php" class="a border">Sale</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="rightarea combine">
				<form class="search" action="index.php" method="POST">
					<input type="text" name="search" placeholder="Search...">
					<input type="submit" class="searchbtn" name='submit' value="GO">
				</form>
			</div>

		</div>
	</div>
</header>

