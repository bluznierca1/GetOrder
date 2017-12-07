<?php include("admin_header.php"); ?>
<!-- header section -->
	<header role="banner" id="header">
		<div class="row">

			<!-- paralax main photo -->
				<div class="parallax-container main-photo" style="height: 60vh;">

					<div class="row">
					<!-- dividing header into two sections: logo and menu -->
						<div class="col s2 center-align">
							<span><a href="../index.php"><img src="../images/logo/logo.png" class="logo"></a></span>
						</div>
						
						<?php if( $session_admin->is_logged_in() ){
							include("../layouts/navbar/admin_navbar.php");
						} else {
							include("../layouts/navbar/random_navbar.php");
						}
					?>

					<div class="parallax">
						<img src="../images/home/home_photo.jpg">
					</div>
						}
				</div>
		</div>
	</header>