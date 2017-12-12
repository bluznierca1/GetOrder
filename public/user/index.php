<?php 
require_once("../../includes/initialize.php");
	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to user panel.";
		redirect_to("../admin/index.php");
	} else if( !$session_user->is_logged_in() ){
		redirect_to("login.php");
	} else if ($session_restaurant->is_logged_in() ){
		$message_restaurant = "You are logged in as Restaurant. Can not go to user panel.";
		redirect_to("../restaurant/index.php");
	}
	
	$user = User::find_by_id($_SESSION['user_id']);
	$counted_reservations = User::count_reservations($user->user_id);
?>

<?php include("../layouts/header/user_header_menu.php"); ?>

	<div class="row">
		<div class="col s12 center-align">
			<h4 class="user-panel-message"><?php echo display_message_errors($message_user); ?></h4>
			<h1 class="teal-text darken-2 user-title font-h1"><b>Hello, <?php echo $user->first_name; ?>!</b></h1>
			<p>In the menu button you can find more options for your account<p></p>
		</div>
	</div>

	<div class="row">
        <div class="col s12 m6 offset-m3">
          <div class="card">
            <div class="card-content teal-text darken-2">
              <span class="card-title-user"><?php echo $user->first_name . " " . $user->last_name; ?></span>
              <br />
              <br />
              <p class="card-details-font teal-text darken-4">Username: <span style="color:black;"><?php echo $user->username; ?></span></p>
              <p class="card-details-font teal-text darken-4">E-mail: <span style="color:black;"><?php echo $user->email; ?></p>
              <p class="card-details-font teal-text darken-4">Account created: <span style="color:black;"><?php echo $user->created; ?></p>
              <p class="card-details-font teal-text darken-4">Reservations: <span style="color:black;"><?php echo $counted_reservations; ?></p>
            </div>
            <div class="card-action right-align">
              <a href="edit_account.php" style="color:#fb8c00"><b>Edit account</b></a>
              <a href="reservations_list.php" style="color:#fb8c00"><b>Reservations</b></a>
            </div>
          </div>
        </div>
      </div>

<?php include("../layouts/footer/user_footer.php"); ?>