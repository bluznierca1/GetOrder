<?php 
	require_once("../../includes/initialize.php");
	
	echo $session->message;
	echo $session->user_id;

	// $user = $user::find_by_id($_SESSION['user_id']);
?>