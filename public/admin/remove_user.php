<?php require_once("../../includes/initialize.php"); ?>

<?php 
	if( isset($_GET['user_id']) && $session_admin->is_logged_in() ){
		$user = User::find_by_id($_GET['user_id']);
		if( $user->remove($_GET['user_id']) ){
			$_SESSION['message_admin'] = "User {$user->username} is removed successfully.";
			redirect_to("users_list.php");
		} else {
			$_SESSION['message_admin'] = "Could not remove user {$user->username}. ";
		} 
	} else {
		redirect_to("index.php");
	}

?>