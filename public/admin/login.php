<?php require_once("../../includes/initialize.php"); ?>
<?php 

	if ( $session_admin->is_logged_in() ){
		redirect_to("index.php");
	} else if( $session_user->is_logged_in() ){
		$session_user->message("You are logged in as User. Can not go to Admin panel.");
		redirect_to("../user/index.php");
	} else if ($session_restaurant->is_logged_in() ){
		$session_restaurant->message("You are logged in as Restaurant. Can not go to admin panel.");
		redirect_to("../restaurant/index.php");
	}
	
	if( isset($_POST['submit']) ){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		$found_admin = Admin::authenticate($username, $password);

		if( $found_admin ){
			$session_admin->login($found_admin);
			redirect_to("index.php");
		} else {
			$session_admin->message("Username/Password is wrong.");
		}
	} else {
		$username = "";
		$password = "";
	}

?>


<?php include("../layouts/header/admin_header.php"); ?>

<main role="main">
	<header>
		<div class="row">
			<div class="col s12 center-align">
				<h1><span class="teal-text darken-1">Admin Login Panel</span></h1>
			</span>
		</span>
	</header>
	<?php echo isset($session_admin->message) ? display_message_errors($session_admin->message) : ""; ?>
	<section role="section" id="section1">
	<div class="row login-admin-panel">
    <form class="col s12" action="login.php" method="post" role="form">
      <div class="row">
        <div class="input-field col s12">
          <input value="<?php echo $username; ?>" id="username" name="username" type="text" class="validate">
          <label for="username">Username</label>
        </div>
        <div class="input-field col s12">
          <input id="password" type="password" name="password" class="validate">
          <label for="password">Password</label>
        </div>
        <div class="input-field col s12">
			<input type="submit" class="waves-effect waves-light btn" name="submit" value="Login" >
        </div>
      </div>
    </form>
    <a href="../index.php">Home</a>
  </div>

	</section>
</main>

<?php include("../layouts/footer/admin_footer.php"); ?>