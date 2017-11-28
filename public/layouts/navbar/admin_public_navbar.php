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
				<h4 class="restaurant-navbar-title teal-text darken-1"><?php echo $admin->username; ?></h4>
			</div>
		</li>
		<li><a href="admin/index.php"><i class="material-icons">group</i>My Account</a></li>
		<li><div class="divider"></div></li>
		<li><a href="admin/users_list.php"><i class="material-icons">group</i>Users</a></li>
		<li><div class="divider"></div></li>
		<li><a href="#"><i class="material-icons">insert_drive_file</i>Users files</a></li>
	  	<li><div class="divider"></div></li>
	  	<li><a href="admin/restaurants_list.php"><i class="material-icons">restaurant</i>Restaurants</a></li>
	    <li><div class="divider"></div></li>
		<li><a href="#"><i class="material-icons">more</i>Rest Files</a></li>
	  	<li><div class="divider"></div></li>
		<li><a href="#"><i class="material-icons">report</i>Problems</a></li>
		<li><div class="divider"></div></li>
		<li><a href="admin/map.php"><i class="material-icons">map</i>Map</a></li>
		<li><div class="divider"></div></li>
		<li><a href="admin/logout.php"><i class="material-icons">close</i>Logout</a></li>
	</ul>
</div>