<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if( !isset($_GET['reservation_id']) || $_GET['reservation_id'] == "" ){
		redirect_to("index.php");
	}

	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to user panel.";
		redirect_to("../admin/index.php");
	} else if( !$session_user->is_logged_in() ){
		redirect_to("login.php");
	} else if ($session_restaurant->is_logged_in() ){
		$message_restaurant = "You are logged in as Restaurant. Can not go to user panel.";
		redirect_to("../restaurant/index.php");
	}

	$reservation = Reservation::find_by_id($_GET['reservation_id']);
	$restaurant = Restaurant::find_by_id($reservation->restaurant_id);

	if( $reservation->reservation_is_done($reservation->reservation_id, $restaurant->restaurant_id) ){
		$message_user = "Your reservation is removed.";
		redirect_to("index.php");
	}
?>