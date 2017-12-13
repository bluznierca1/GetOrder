<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if ( !$session_admin->is_logged_in() ){
		redirect_to("login.php");
	} else if( $session_user->is_logged_in() ){
		$session_user->message("You are logged in as User. Can not go to Admin panel.");
		redirect_to("../user/index.php");
	} else if ($session_restaurant->is_logged_in() ){
		$session_restaurant->message("You are logged in as Restaurant. Can not go to admin panel.");
		redirect_to("../restaurant/index.php");
	}

	if( isset($_GET['user_id']) && $session_admin->is_logged_in() ){
		$user = User::find_by_id($_GET['user_id']);
		if( $user->delete($_GET['user_id']) ){
			$session_admin->message("User {$user->username} is removed successfully.");
			redirect_to("users_list.php");
		} else {
			$session_admin->message("Could not remove user {$user->username}.");
		} 
	} else {
		redirect_to("index.php");
	}

?>