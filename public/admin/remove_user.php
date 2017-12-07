<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if ( !$session_admin->is_logged_in() ){
		$message_admin = "You are not logged in. Just do it.";
		redirect_to("login.php");
	} else if( $session_user->is_logged_in() ){
		$message_user = "You are logged in as User. Can not go to Admin panel.";
		redirect_to("../user/index.php");
	} else if ($session_restaurant->is_logged_in() ){
		$message_restaurant = "You are logged in as Restaurant. Can not go to admin panel.";
		redirect_to("../restaurant/index.php");
	}

	if( isset($_GET['user_id']) && $session_admin->is_logged_in() ){
		$user = User::find_by_id($_GET['user_id']);
		if( $user->delete($_GET['user_id']) ){
			$_message_admin = "User {$user->username} is removed successfully.";
			redirect_to("users_list.php");
		} else {
			$_message_admin = "Could not remove user {$user->username}. ";
		} 
	} else {
		redirect_to("index.php");
	}

?>