<?php 
require_once("../../includes/initialize.php");
	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to user panel.";
		redirect_to("../admin/index.php");
	} else if( !$session_user->is_logged_in() ){
		redirect_to("login.php");
	} else if ($session_restaurant->is_logged_in() ){
		$message_restaurant = "You are logged in as Restaurant. Can not go to user panel.";
		redirect_to("../restaurant/index.php");
	}
	
	$user = User::find_by_id($_SESSION['user_id']);
	
	
?>

<?php include("../layouts/header/user_header_menu.php"); ?>

	<div class="row">
		<div class="col s12 center-align">
			<h4 class="user-panel-message"><?php echo display_message_errors($message_user); ?></h4>
			<h2 class="teal-text darken-2 user-title">Hello, <?php echo $user->first_name; ?>!</h2>
			<h3 class="user-subtitle">Here is you panel.</h3>
		</div>
	</div>

<?php include("../layouts/footer/user_footer.php"); ?>