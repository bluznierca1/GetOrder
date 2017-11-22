<?php require_once("../../includes/initialize.php"); ?>

<?php 

	if( $session_restaurant->is_logged_in() ){
		redirect_to("index.php");
	}

	if( isset($_POST['submit']) ){

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		//Check database if user exists
			$found_restaurant = Restaurant::authenticate($username, $password);

		if( empty($errors) ){
			if( $found_restaurant ){
				$session_restaurant->login($found_restaurant);
				redirect_to("index.php");
			} else {
				// Username/Password combo was not found in the database
				$message_restaurant = "Username/Password is wrong.";
			}
		}

	} else { //Form was not submitted.
		$username = "";
		$password = "";
		$message_restaurant = "";
	}

?>

<?php include("../layouts/header/restaurant_header.php"); ?>

<main role="main">
	<header>
		<div class="row">
			<div class="col s12 center-align">
				<h1><span class="teal-text darken-1">Restaurant Login Panel</span></h1>
			</span>
		</span>
	</header>
	<section role="section" id="section1">
	<?php echo display_errors($errors); ?>
	<?php echo display_message_errors($message_restaurant); ?>
	<div class="row login-restaurant-panel">
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
    <a href="../index.php">Home</a>
  </div>

	</section>
</main>

<?php include("../layouts/footer/restaurant_footer.php"); ?>