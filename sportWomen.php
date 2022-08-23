
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/productliststyles.css">
	<link rel="stylesheet" href="styles/footerstyles.css">
	<link rel="stylesheet" href="styles/headerstyles.css">

	<script defer src="https://kit.fontawesome.com/f1e877ccee.js" crossorigin="anonymous"></script>

	<title>Women's Sport</title>
</head>

<body>

	<?php 
	include('header.php'); 
	include('includes/functions.inc.php');
	?>

	<div class = "product_list">

	<?php 
	$conn = get_connection();

    $products = get_women_sport($conn);

    display_products($products);
	mysqli_close($conn);
	?>

	</div>


</body>
<?php
	include('footer.php');
?>
</html>

