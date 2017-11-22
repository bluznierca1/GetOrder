<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if( $session_restaurant->is_logged_in() ){
		$restaurant = User::find_by_id($_SESSION['restaurant_id']);
		$session_restaurant->logout($restaurant);
		redirect_to("login.php");
	} else {
		redirect_to("login.php");
	}

	
?>