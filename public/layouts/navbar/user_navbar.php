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
			<div class="user-view center-align">	
				<h4 class="user-navbar-title teal-text darken-1"><?php echo $user->username; ?></h4>
			</div>
		</li>
		<li><a href="index.php"><i class="material-icons">group</i>My account</a></li>
		<li><div class="divider"></div></li>
		<li><a href="edit_account.php"><i class="material-icons">mode_edit</i>Edit account</a></li>
		<li><div class="divider"></div></li>
		<li><a href="change_password.php"><i class="material-icons">mode_edit</i>Change Password</a></li>
		<li><div class="divider"></div></li>
		<li><a href="#"><i class="material-icons">format_list_numbered</i>Orders List</a></li>
	  	<li><div class="divider"></div></li>
		<li><a href="#"><i class="material-icons">info</i>Opinions</a></li>
		<li><div class="divider"></div></li>
		<li><a href="map.php"><i class="material-icons">map</i>Map</a></li>
		<li><div class="divider"></div></li>
		<li><a href="remove_account.php?user_id=<?php echo $user->user_id; ?>"><i class="material-icons">remove</i>Remove account</a></li>
		<li><div class="divider"></div></li>
		<li><a href="logout.php"><i class="material-icons">close</i>Logout</a></li>
</div>