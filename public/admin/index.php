<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if( $session_admin->is_logged_in() ){
		$admin = Admin::find_by_id($_SESSION['admin_id']);
	} else {
		redirect_to("login.php");
		echo "dziki chuj.";
	}
?>

<?php include("../layouts/header/admin_header_menu.php"); ?>

<a href="logout.php">Logoout</a>

<?php include("../layouts/footer/admin_footer.php"); ?>