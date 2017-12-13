<?php 
	require_once("../../includes/initialize.php");
	
	if ( $session_admin->is_logged_in() ){
		$session_admin->message("You are logged in as Admin. Can not go to restaurant panel.");
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$session_user->message("You are logged in as User. Can not go to restaurant panel.");
		redirect_to("../user/index.php");
	} else if (!$session_restaurant->is_logged_in() ){
		redirect_to("login.php");
	}

	$restaurant = Restaurant::find_by_id($_SESSION['restaurant_id']);

	if( isset($_POST['submit']) ){
		$name = $database->escape_value(trim($_POST['name']));
		$email = $database->escape_value(trim($_POST['email']));
		$city = $database->escape_value(trim($_POST['city']));
		$street = $database->escape_value(trim($_POST['street']));
		$number = $database->escape_value(trim($_POST['number']));
		$phone_number = $database->escape_value(trim($_POST['phone_number']));

		if( $restaurant->edit($name, $email, $city, $street, $number, $phone_number, $restaurant->restaurant_id) ){
			$session_restaurant->message("Account has been edited.");
			redirect_to("index.php");
		} else {
			$session_restaurant->message("Something went wrong.");
			$redirect_to("index.php");
		}

	}
	
?>

<?php include("../layouts/header/restaurant_header_menu.php"); ?>

	<div class="row">
		<div class="s12 center-align">
			<h1 class="teal-text darken-2">Edit Account</h1>
		</div>
	</div>
	
	<?php echo isset($session_restaurant->message_restaurant) ? $session_restaurant->message_restaurant : ""; ?>
	<div class="row">
		<form class="s12 edit-form" role="form" action="edit_account.php" method="post">
			<div class="col s12 m6 input-field">
				<input type="text" class="validate" id="name" name="name" value="<?php echo htmlentities($restaurant->name); ?>">
				<label for="name">Name</label>
			</div>
			<div class="input-field col s12 m6">
				<input type="email" id="email" name="email" class="validate" value="<?php echo htmlentities($restaurant->email); ?>">
				<label for="email">Email</label>
			</div>
			<div class="input-field col s12 m6">
				<input type="text" name="city" id="city" class="validate" value="<?php echo htmlentities($restaurant->city); ?>">
				<label for="city">City</label>
			</div>
			<div class="input-field col s12 m6">
				<input type="text" id="street" class="validate" name="street" value="<?php echo htmlentities($restaurant->street); ?>">
				<label for="street">Street</label>
			</div>
			<div class="input-field col s12 m6">
				<input type="number" id="number" class="validate" name="number" value="<?php echo htmlentities($restaurant->number); ?>">
				<label for="number">Building's number</label>
			</div>
			<div class="input-field col s12 m6">
				<input type="text" id="phone_number" class="validate" name="phone_number" value="<?php echo htmlentities($restaurant->phone_number); ?>">
				<label for="phone_number">Phone Nubmber</label>
			</div>
			<div class="input-field col s12 center-align">
				<input type="submit" name="submit" value="Confirm" class="waves-effect waves-light btn">
			</div>
		</form>  
	</div>
	

<?php include("../layouts/footer/restaurant_footer.php"); ?>