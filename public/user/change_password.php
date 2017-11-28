<?php require_once("../../includes/initialize.php"); ?>

<?php 
	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to user panel.";
		redirect_to("../admin/index.php");
	} else if( !$session_user->is_logged_in() ){
		redirect_to("login.php");
	} else if ($session_restaurant->is_logged_in() ){
		$message_restaurant = "You are logged in as Restaurant. Can not go to user panel.";
		redirect_to("../restaurant/index.php");
	}
	
?>

<?php 
	
	$user = User::find_by_id($_SESSION['user_id']);

	if( isset($_POST['submit']) ){

		$new_password = $database->escape_value(trim($_POST['new_password']));
		$confirm_password = $database->escape_value(trim($_POST['confirm_password']));
		$old_password = $database->escape_value(trim($_POST['old_password']));

		if( $old_password == $user->password ){
			if( $new_password == $confirm_password ){
				if( User::edit_password($new_password, $user->user_id) ){
					$message_user = "Your password has got changed.";
					redirect_to("index.php");
				}
			} else {
				$message_user = "Passwords do not match.";
			}
		} else {
			$message_user = "Your old password is wrong.";
		}
	}

?>

<?php include("../layouts/header/user_header_menu.php"); ?>

	<div class="row">
		<div class="s12 center-align">
			<h1 class="teal-text darken-2">Edit Account </h1>
		</div>
	</div>

	<div class="row">
		<?php echo isset($message_user) ? display_message_errors($message_user) : ""; ?>
		<form class="s12 edit-form" method="post" action="change_password.php">
			<div class="input-field col s12 m6">
				<input type="password" id="new_password" name="new_password" class="validate" value="" placeholder="New password">
				<label for="new_password">New password</label>
			</div>
			<div class="input-field col s12 m6">
				<input type="password" name="confirm_password" class="validate" id="confirm_password" value="" placeholder="Confirm new password">
				<label for="confirm_password">Confirm Password</label>
			</div>
			<div class="input-field col s12 m6">
				<input type="password" name="old_password" class="validate" value="" placeholder="Your old password">
				<label for="old_password">Confirm Password</label>
			</div>
			<div class="input-field col s12 right-align">
				<input type="submit" id="old_password" name="submit" class="waves-effect waves-light btn" value="Submit">
			</div>
		</form>
	</div>


	<?php include("../layouts/footer/user_footer.php"); ?>