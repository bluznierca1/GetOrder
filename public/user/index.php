<?php 
require_once("../../includes/initialize.php");
	
	if( $session_user->is_logged_in() ){
		$user = User::find_by_id($_SESSION['user_id']);
	} else {
		redirect_to("login.php");
	}
	
?>

<?php include("../layouts/header/user_header_menu.php"); ?>



<?php include("../layouts/footer/user_footer.php"); ?>