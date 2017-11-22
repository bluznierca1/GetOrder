<?php require_once("../../includes/initialize.php"); ?>

<?php 
	if( !$session_admin->is_logged_in() ){
		redirect_to("login.php");
	} else {
		$admin = Admin::find_by_id($_SESSION['admin_id']);
		$session_admin->logout($admin);
		redirect_to("login.php");
	}
?>