<?php require_once("../../includes/initialize.php"); ?>


<?php

	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to user panel.";
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$message_user = "You are logged in as User. Can not go to restaurant panel.";
		redirect_to("../user/index.php");
	} else if ($session_restaurant->is_logged_in() ){
		$message_restaurant = "Can not register when you are logged in.";
		redirect_to("index.php");
	}

	if( isset($_POST['submit']) ){
		
		$required_fields = ['username', 'password', 'name', 'phone_number', 
		'city', 'street', 'number', 'zip_code', 'email'];
		fields_are_filled($required_fields);

		$fields_min_length = ['username' => 5, 'password' => 8, 'email' => 8];
		validate_min_length($fields_min_length);

		$password_first_version = trim($_POST['password']);
		$confirmed_password = trim($_POST['confirmed_password']);
		passwords_match($password_first_version, $confirmed_password);

		$restaurant = new Restaurant();
		$restaurant->username = trim($_POST['username']);
		// $user->password = password_encrypt($password_first_version);
		$restaurant->password = $password_first_version;
		$created_time = strftime("%Y-%m-%d %H:%M:%S", time());
		$restaurant->created = date("Y-m-d H:i:s", strtotime($created_time));
		$restaurant->phone_number = trim($_POST['phone_number']);
		$restaurant->number = trim($_POST['number']);
		$restaurant->city = trim($_POST['city']);
		$restaurant->street = trim($_POST['street']);
		$restaurant->zip_code = trim($_POST['zip_code']);
		$restaurant->name = trim($_POST['name']);
		$restaurant->email = trim($_POST['email']);
		$restaurant->marked = "no";

		if( empty($errors) ){
			if( !$restaurant->username_exists($restaurant->username) ) {
				if ( !$restaurant->email_exists($restaurant->email) ){
					$restaurant->save();
					$message_restaurant = "Registered. Time to log in.";
					redirect_to("login.php");
					// $message_restaurant = $restaurant->save();
				} else {
					$message_restaurant = "This email is taken. Use another.";
				}
			} else {
				$message_restaurant = "User with that username exists. Use another.";
			}
		} else {
			$message_restaurant = "";
		}
		
	} else {
		$message_restaurant = "";
		$username = "";
		$password = "";
		$name = "";
		$email = "";
	}

?>
<?php include("../layouts/header/restaurant_header_menu.php"); ?>
<main role="main">
	<header>
		<div class="row">
			<div class="col s12 center-align">
				<h1><span class="teal-text darken-1">Restaurant Registration Panel</span></h1>
			</span>
		</span>
	</header>
	<section role="section" id="section1">
	<?php echo display_errors($errors); ?>
	<?php echo display_message_errors($message_restaurant); ?>
	<div class="row register-restaurant-panel">
    <form class="col s12" action="register.php" method="post" role="form">
      <div class="row">
        <div class="input-field col s12 m6 l6">
          <input  id="username" name="username" type="text" class="validate" <?php echo isset($restaurant->username)  && $restaurant->username != "" ? "value=\"{$restaurant->username}\"" : "placeholder=\"Username:\"" ?>>
          <label for="username">Username</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="password" type="password" name="password" class="validate" placeholder="Password:">
          <label for="password">Password</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="confirm_password" type="password" name="confirmed_password" class="validate" placeholder="Confirm Password:">
          <label for="confirm_password">Confirm password</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="name" type="text" name="name" class="validate" <?php echo isset($restaurant->name) && $restaurant->name != ""  ? "value=\"{$restaurant->name}\"" : "placeholder=\"Name of the restaurant:\"" ?> >
          <label for="name">Restaurant's Name</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="email" type="text" name="email" class="validate" <?php echo isset($restaurant->email) && $restaurant->email != "" ? "value=\"{$restaurant->email}\"" : "placeholder=\"Email:\"" ?> >
          <label for="email">E-mail</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="phone_number" type="tel" name="phone_number" class="validate" <?php echo isset($restaurant->phone_number) && $restaurant->phone_number != "" ? "value=\"{$restaurant->phone_number}\"" : "placeholder=\"Phone Number\"" ?> >
          <label for="phone_number">Phone number</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="city" type="text" name="city" class="validate" <?php echo isset($restaurant->city) && $restaurant->city != "" ? "value=\"{$restaurant->city}\"" : "placeholder=\"City\"" ?> >
          <label for="city">City</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="street" type="text" name="street" class="validate" <?php echo isset($restaurant->street) && $restaurant->street != "" ? "value=\"{$restaurant->street}\"" : "placeholder=\"Name of the Street\"" ?> >
          <label for="street">Street</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="number" type="number" name="number" class="validate" <?php echo isset($restaurant->number) && $restaurant->number != "" ? "value=\"{$restaurant->number}\"" : "placeholder=\"Building's number\"" ?> >
          <label for="number">Building's number</label>
        </div>

        <div class="input-field col s12 m6 l6">
          <input id="zip_code" type="text" name="zip_code" class="validate" <?php echo isset($restaurant->zip_code) && $restaurant->zip_code != "" ? "value=\"{$restaurant->zip_code}\"" : "placeholder=\"Zip Code\"" ?> >
          <label for="zip_code">Zip Code</label>
        </div>

        <div class="input-field col s12 right-align">
			<input type="submit" class="waves-effect waves-light btn" name="submit" value="Register" >
        </div>

      </div>
    </form>
  </div>

	</section>
</main>

<?php include("../layouts/footer/restaurant_footer.php"); ?>
