<?php
 
	if ( $session_admin->is_logged_in() ){
		$session_admin->message("You are logged in as Admin. Can not go to user panel.");
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$session_user->message("You are logged in as User. Can not go to restaurant panel.");
		redirect_to("../user/index.php");
	} else if (!$session_restaurant->is_logged_in() ){
		redirect_to("login.php");
	}
?>
