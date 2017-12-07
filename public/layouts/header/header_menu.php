<?php require_once("../includes/initialize.php"); ?>
<?php include("header.php"); ?>
<!-- header section -->
	<header role="banner" id="header">
		<div class="row">

			<!-- paralax main photo -->
			<div class="parallax-container">
				<div class="row">
					<!-- dividing header into two sections: logo and menu -->
					<div class="col s2 center-align">
						<span><img src="images/logo/logo.png" class="logo"></span>
					</div>
					<?php 
						if( $session_admin->is_logged_in() ) {
							$admin = Admin::find_by_id($_SESSION['admin_id']);
							include("layouts/navbar/admin_public_navbar.php");
						} else if( $session_restaurant->is_logged_in() ) {
							$restaurant = Restaurant::find_by_id($_SESSION['restaurant_id']);
							include("layouts/navbar/restaurant_public_navbar.php");
						} else if ($session_user->is_logged_in() ) {
							$user = User::find_by_id($_SESSION['user_id']);
							include("layouts/navbar/user_public_navbar.php");
						} else {
							include("layouts/navbar/random_navbar.php"); 
						}
					?>	
					<?php include("layouts/restaurant_choice/general_restaurant_choice.php"); ?>
				</div>
				<div class="parallax">
					<img src="images/home/home_photo.jpg">

				</div>
			</div>
		</div>
	</header>

	