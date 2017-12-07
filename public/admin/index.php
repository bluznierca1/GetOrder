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

	$admin = Admin::find_by_id($_SESSION['admin_id']);
?>

<?php include("../layouts/header/admin_header_menu.php"); ?>
	
	<div class="row">
		<div class="col s12 center-align">
			<h4 class="admin-panel-message"><?php echo display_message_errors($message_admin); ?></h4>
			<h2 class="teal-text darken-2 admin-title">Hello, <?php echo htmlentities($admin->first_name); ?></h2>
			<h3 class="admin-subtitle">Here you can take care of everything. </h3>
		</div>
	</div>
<a href="logout.php">Logoout</a>

<?php include("../layouts/footer/admin_footer.php"); ?>