<?php 
require_once("../../includes/initialize.php");
	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to restaurant panel.";
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$message_user = "You are logged in as User. Can not go to restaurant panel.";
		redirect_to("../user/index.php");
	} else if (!$session_restaurant->is_logged_in() ){
		redirect_to("login.php");
	}

	$restaurant = Restaurant::find_by_id($_SESSION['restaurant_id']);
	
?>
<?php include("../layouts/header/restaurant_header_menu.php"); ?>

	<div class="row">
		<div class="col s12 center-align">
			<h3 class="restaurant-panel-message"><?php echo display_message_errors($session_restaurant->message_restaurant); ?></h3>
			<h1 class="teal-text darken-2 restaurant-title">Hello, <?php echo $restaurant->name; ?>!</h1>
			<h2 class="restaurant-subtitle">Here is your panel.</h2>
		</div>
	</div>

<?php include("../layouts/footer/restaurant_footer.php"); ?>