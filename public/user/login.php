<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if( isset($_POST['submit']) ){

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		//Check database if user exists
			$found_user = User::authenticate($username, $password);

		if( empty($errors) ){
			if( $found_user ){
				$session->login($found_user);
				$_SESSION['message'] = $user;
				redirect_to("test.php");
			} else {
				// Username/Password combo was not found in the database
				$message = "Username/Password incorrect.";
			}
		}

	} else { //Form was not submitted.
		$username = "";
		$password = "";
		$message = "";
	}

?>

<?php include("../layouts/user_header.php"); ?>

<main role="main">
	<header>
		<div class="row">
			<div class="col s12 center-align">
				<h1><span class="teal-text darken-1">Login Panel</span></h1>
			</span>
		</span>
	</header>
	<section role="section" id="section1">
	<?php echo display_errors($errors); ?>
	<?php echo display_message_errors($message); ?>
	<div class="row register-user-panel">
    <form class="col s12" action="login.php" method="post" role="form">
      <div class="row">
        <div class="input-field col s12">
          <input  id="username" name="username" type="text" class="validate" placeholder="Username">
        </div>
        <div class="input-field col s12">
          <input id="password" type="password" name="password" class="validate" placeholder="Password">
        </div>        
        <div class="input-field col s12 right-align">
			<input type="submit" class="waves-effect waves-light btn" name="submit" value="Register" >
        </div>
      </div>
    </form>
  </div>

	</section>
</main>