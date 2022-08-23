
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/productliststyles.css">
	<link rel="stylesheet" href="styles/headerstyles.css">
	<link rel="stylesheet" href="styles/footerstyles.css">	
	<title>Home Page</title>
</head>

<body>

	<?php 
	// updating heading
	include('header.php'); 
	include('includes/functions.inc.php');
	$defaultHeading = 'All shoes';
	function updateHeading($text){
		echo "<h2>".$text."</h2>";
	}
	$conn = get_connection();
	function searchDb($conn, $term){
		
		$names = get_products_by_name($conn, $term);
		$brands = get_product_by_brand($conn, $term);
		$result = arrayMerge($names, $brands);

		$cats = get_products_by_category($conn, $term);
		$result = arrayMerge($result, $cats);

		$colours = get_products_by_colour($conn, $term);
		$result = arrayMerge($result, $colours);

		$gender = get_products_by_sex($conn, $term);
		$result = arrayMerge($result, $gender);
		return $result;
	}
	function arrayMerge($result, $addition){
		if($result){
			if($addition){
				return array_merge($result, $addition);
			}else{
				return $result;
			}
		}else{
			if($addition){
				return $addition;
			}
		}
	}

	// This is for the search function - if the request method is post it means that a search has been performed
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$products = null;
		if(isset($_POST['search'])){
			$products = searchDb($conn,$_POST['search']);

			updateHeading('search:'.$_POST['search']);
		}
		if(isset($_POST['category'])){
			$products = get_products_by_category($conn, $_POST['category']);
			updateHeading($_POST['category']);
		}
		if(isset($_POST['brand'])){
			$products = get_product_by_brand($conn, $_POST['brand']);
			updateHeading($_POST['brand']);
		}
		
		echo '<div class = "product_list">';
		if($products){
			display_products($products);
		}else{
			echo '</div>';
			updateHeading("no search results!");
		}
	}
	else {
		// displays all products if navigated straight to the page
		$products = get_all_products($conn);
		updateHeading($defaultHeading);

		echo '<div class = "product_list">';
		display_products($products);
	}

	echo '</div>';

	include('footer.php');
?>
</body>
</html>

