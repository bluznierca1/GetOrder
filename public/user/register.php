<?php require_once("../../includes/initialize.php"); ?>
<?php

	if( isset($_POST['submit']) ){
		
		$required_fields = ['username', 'password', 'first_name', 'last_name', 'email'];
		fields_are_filled($required_fields);

		$fields_min_length = ['username' => 5, 'password' => 8, 'first_name' => 3, 'last_name' => 2, 'email' => 8];
		validate_min_length($fields_min_length);

		$password_first_version = trim($_POST['password']);
		$confirmed_password = trim($_POST['confirmed_password']);
		passwords_match($password_first_version, $confirmed_password);

		$user = new User();
		$user->username = trim($_POST['username']);
		// $user->password = password_encrypt($password_first_version);
		$user->password = $password_first_version;
		$created_time = strftime("%Y-%m-%d %H:%M:%S", time());
		$user->created = date("Y-m-d H:i:s", strtotime($created_time));
		$user->first_name = trim($_POST['first_name']);
		$user->last_name = trim($_POST['last_name']);
		$user->email = trim($_POST['email']);

		if( empty($errors) ){
			if( !$user->username_exists($user->username) ) {
				if ( !$user->email_exists($user->email) ){
					$user->save();
					$_SESSION['message'] = "Your account has been created. Time to log in.";
					redirect_to("login.php");
				} else {
					$message = "This email is taken. Use another.";
				}
			} else {
				$message = "User with that username exists. Use another.";
			}
		} else {
			$message = "";
		}
		
	} else {
		$message = "";
		$username = "";
		$password = "";
		$first_name = "";
		$last_name = "";
		$email = "";
	}

?>
<?php include("../layouts/user_header.php"); ?>

<main role="main">
	<header>
		<div class="row">
			<div class="col s12 center-align">
				<h1><span class="teal-text darken-1">Registration Panel</span></h1>
			</span>
		</span>
	</header>
	<section role="section" id="section1">
	<?php echo display_errors($errors); ?>
	<?php echo display_message_errors($message); ?>
	<div class="row register-user-panel">
    <form class="col s12" action="register.php" method="post" role="form">
      <div class="row">
        <div class="input-field col s12">
          <input  id="username" name="username" type="text" class="validate" <?php echo isset($user->username)  && $user->username != "" ? "value=\"{$user->username}\"" : "placeholder=\"Username\"" ?> >
        </div>
        <div class="input-field col s12">
          <input id="password" type="password" name="password" class="validate" placeholder="Password">
        </div>
        <div class="input-field col s12">
          <input id="confirm_password" type="password" name="confirmed_password" class="validate" placeholder="Confirm Password">
        </div>
        <div class="input-field col s12">
          <input id="first_name" type="text" name="first_name" class="validate" <?php echo isset($user->first_name) && $user->first_name != ""  ? "value=\"{$user->first_name}\"" : "placeholder=\"First Name\"" ?> >
        </div>
        <div class="input-field col s12">
          <input id="last_name" type="text" name="last_name" class="validate" <?php echo isset($user->last_name) && $user->last_name != ""  ? "value=\"{$user->last_name}\"" : "placeholder=\"Last Name\"" ?> >
        </div>
        <div class="input-field col s12">
          <input id="email" type="email" name="email" class="validate" <?php echo isset($user->email) && $user->email != "" ? "value=\"{$user->email}\"" : "placeholder=\"Your email\"" ?> >
        </div>
        
        <div class="input-field col s12 right-align">
			<input type="submit" class="waves-effect waves-light btn" name="submit" value="Register" >
        </div>
      </div>
    </form>
    
  </div>

	</section>
</main>