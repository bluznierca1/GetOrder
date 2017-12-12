<?php require_once("../../includes/initialize.php"); ?>

<?php	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to restaurant panel.";
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$message_user = "You are logged in as User. Can not go to restaurant panel.";
		redirect_to("../user/index.php");
	} else if (!$session_restaurant->is_logged_in() ){
		redirect_to("login.php");
	}

	$reservation = Reservation::find_by_id($_GET['reservation_id']);
	$restaurant = Restaurant::find_by_id($reservation->restaurant_id);

	if( $reservation->reservation_is_done($reservation->reservation_id, $restaurant->restaurant_id) ){
		$message_user = "Your reservation is removed.";
		redirect_to("index.php");
	}
?>