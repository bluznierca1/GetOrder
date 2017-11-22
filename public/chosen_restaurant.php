<?php require_once("../includes/initialize.php"); ?>

<?php 

	$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);

	echo $restaurant->name;

?>