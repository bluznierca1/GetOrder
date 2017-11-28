<?php require_once("../../includes/initialize.php"); ?>

<?php 
	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to user panel.";
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		redirect_to("index.php");
	} else if ($session_restaurant->is_logged_in() ){
		$message_restaurant = "You are logged in as Restaurant. Can not go to user panel.";
		redirect_to("../restaurant/index.php");
	}

	if( isset($_POST['submit']) ){

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		//Check database if user exists
			$found_user = User::authenticate($username, $password);

		if( empty($errors) ){
			if( $found_user ){
				$session_user->login($found_user);
				redirect_to("index.php");
			} else {
				// Username/Password combo was not found in the database
				$message_user = "Username/Password incorrect.";
			}
		}

	} else { //Form was not submitted.
		$username = "";
		$password = "";
		$message_user = "";
	}

?>

<?php include("../layouts/header/user_header_menu.php"); ?>

<main role="main">
	<header>
		<div class="row">
			<div class="col s12 center-align">
				<h1><span class="teal-text darken-1">Login User Panel</span></h1>
			</span>
		</span>
	</header>
	<section role="section" id="section1">
	<?php echo display_errors($errors); ?>
	<?php echo display_message_errors($message_user); ?> 
	<div class="row register-user-panel">
    <form class="col s12" action="login.php" method="post" role="form">
      <div class="row">
        <div class="input-field col s12">
          <input  id="username" name="username" type="text" class="validate" placeholder="Username">
          <label for="username">Username</label>
        </div>
        <div class="input-field col s12">
          <input id="password" type="password" name="password" class="validate" placeholder="Password">
          <label for="password">Password</label>
        </div>        
        <div class="input-field col s12 right-align">
			<input type="submit" class="waves-effect waves-light btn" name="submit" value="Register" >
        </div>
      </div>
    </form>
    <a href="../index.php">Home</a>
  </div>

	</section>
</main>

<?php include("../layouts/footer/user_footer.php"); ?>