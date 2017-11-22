<?php 
	require_once("../../includes/initialize.php");
	
	echo $session_user->message_user;
	echo $session_user->user_id;

	// $user = $user::find_by_id($_SESSION['user_id']);
?>