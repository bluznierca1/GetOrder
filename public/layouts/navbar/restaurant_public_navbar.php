<div class="col offset-s6 s3 right-align" id="menu">

	<!-- slide out menu -->

	<!-- hard data option -->
	<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons menu-icon" id="menu-button">menu</i></a>

	<ul id="slide-out" class="side-nav side-menu center-align">
		<li>
			<div class="buton-collapse-close-container">
				<span class="buton-collapse-close"> <a href="#" class="buton-collapse-close-a">Close</a> </span>
			</div>
		</li>
		<li>
			<div class="restaurant-view center-align">	
				<h4 class="restaurant-navbar-title teal-text darken-1"><?php echo $restaurant->name; ?></h4>
			</div>
		</li>
		<li><a href="restaurant/index.php"><i class="material-icons">person</i>My account</a></li>
		<li><div class="divider"></div></li>
		<li><a href="restaurant/edit_account.php"><i class="material-icons">mode_edit</i>Account</a></li>
		<li><div class="divider"></div></li>
		<li><a href="change_password.php"><i class="material-icons">mode_edit</i>Password</a></li>
		<li><div class="divider"></div></li>
		<li><a href="#"><i class="material-icons">format_list_numbered</i>Orders List</a></li>
		<li><div class="divider"></div></li>
		<li><a href="#"><i class="material-icons">help_outline</i>Need help?</a></li>
		<li><div class="divider"></div></li>
		<li><a href="remove_account.php?restaurant_id=<?php echo $restaurant->restaurant_id; ?>"><i class="material-icons">remove</i>Remove account</a></li>
		<li><div class="divider"></div></li>
		<li><a href="restaurant/logout.php"><i class="material-icons">close</i>Logout</a></li>
</div>