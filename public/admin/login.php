<?php 
	
	if( isset($_SUBMIT['submit']) ){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
	} else {
		$username = "";
	}

?>


<?php include("../layouts/admin_header.php"); ?>

<main role="main">
	<header>
		<div class="row">
			<div class="col s12 center-align">
				<h1><span class="teal-text darken-1">Admin Login Panel</span></h1>
			</span>
		</span>
	</header>
	<section role="section" id="section1">
		
	<div class="row login-admin-panel">
    <form class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <input value="<?php echo $username; ?>" id="username" name="username" type="text" class="validate">
          <label for="first_name">Username</label>
        </div>
        <div class="input-field col s12">
          <input id="password" type="password" name="password" class="validate">
          <label for="last_name">Password</label>
        </div>
        <div class="input-field col s12">
					<input type="submit" class="waves-effect waves-light btn" name="submit" value="Login" >
        </div>
      </div>
    </form>
  </div>

	</section>
</main>

<?php include("../layouts/admin_footer.php"); ?>