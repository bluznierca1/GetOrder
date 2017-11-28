<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if( $session_user->is_logged_in() ){
		$user = User::find_by_id($_SESSION['user_id']);
		$session_user->logout($user);
		redirect_to("../index.php");
	} else {
		redirect_to("login.php");
	}

	
	echo $user_user->username;
?>