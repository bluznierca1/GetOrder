<?php 
require_once("../../includes/initialize.php");
	
	if( $session_restaurant->is_logged_in() ){
		$restaurant = Restaurant::find_by_id($_SESSION['restaurant_id']);
	} else {
		redirect_to("login.php");
	}	
?>

<?php include("../layouts/header/restaurant_header_menu.php"); ?>

	<div class="row">
		<div class="col s12 center-align">
			<h2 class="teal-text darken-2">Hello, <?php echo $restaurant->name; ?>!</h2>
			<h3 class="teal-text darken-2">Here is you panel.</h3>
		</div>
	</div>

<?php include("../layouts/footer/restaurant_footer.php"); ?>