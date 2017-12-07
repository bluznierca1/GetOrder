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
		$username = $user->username;
		$first_name = $database->escape_value(trim($_POST['first_name']));
		$last_name = $database->escape_value(trim($_POST['last_name']));
		$email = $database->escape_value(trim($_POST['email']));

		if( $user->edit($username, $first_name, $last_name, $email, $user->user_id) ){
			$message_user = "You account has been edited.";
			redirect_to("index.php");
		} else {
			$message_user = "Something went wrong.";
			$redirect_to("index.php");
		}


	} else {

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
		<form class="s12 edit-form" method="post" action="edit_account.php">
			<div class="col s12 m6">
				<input type="text" name="first_name" class="validate" value="<?php echo htmlentities($user->first_name);?>" >
				<label for="first_name">First Name</label>
			</div>
			<div class="col s12 m6">
				<input type="text" name="last_name" class="validate" value="<?php echo htmlentities($user->last_name); ?> " >
				<label for="last_name">Last Name</label>
			</div>
			<div class="col s12 m6">
				<input type="email" name="email" class="validate" value="<?php echo htmlentities($user->email); ?>" >
				<label for="email">Email</label>
			</div>
			<div class="col s12 right-align">
				<input type="submit" name="submit" class="waves-effect waves-light btn" value="Submit">
			</div>
		</form>
	</div>

<?php include("../layouts/footer/user_footer.php"); ?>