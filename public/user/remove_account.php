<?php 
require_once("../../includes/initialize.php");
	
	if ( $session_admin->is_logged_in() ){
		$session_admin->message("You are logged in as Admin. Can not go to user panel.");
		redirect_to("../admin/index.php");
	} else if( !$session_user->is_logged_in() ){
		redirect_to("login.php");
	} else if ($session_restaurant->is_logged_in() ){
		$session_restaurant->message("You are logged in as Restaurant. Can not go to user panel.");
		redirect_to("../restaurant/index.php");
	}
	
	if( !isset($_GET['user_id']) ){
		$session_user->message("No id given.");
		redirect_to("index.php");
	}

	if( isset($_POST['submit'] ) ){
		if( $user->delete($_GET['user_id']) ){
			$user = User::find_by_id($_GET['user_id']);
			$session_user->logout($user);
			redirect_to("../index.php");
		}
	}

	$user = User::find_by_id($_GET['user_id']);
	
?>

<?php include("../layouts/header/user_header_menu.php"); ?>

	<div class="row">
		<div class="col s12 center-align">
			<h1 class="teal-text darken-2 user-title">Are you leaving us, <?php echo $user->first_name; ?>?</h2>
			<h2 class="user-subtitle">Account Details:</h2>
		</div>
	</div>
	<div class="row">
 		<div class="s12 table-container">
    	<table class="responsive-table bordered">
        <thead>
          <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Created</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Type</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          	<td><?php echo htmlentities($user->user_id); ?></td>
            <td><?php echo htmlentities($user->username); ?></td>
            <td><?php echo htmlentities($user->created); ?></td>
            <td><?php echo htmlentities($user->first_name); ?></td>
            <td><?php echo htmlentities($user->last_name); ?></td>
            <td><?php echo htmlentities($user->email); ?></td>
            <td><?php echo htmlentities($user->type); ?></td>
          </tr>
        </tbody>
      </table>
	<br />
   	<div class="row">
		<form class="col s6 right-align" action="remove_account.php?user_id=<?php echo htmlspecialchars($user->user_id); ?>" method="post">
			<input type="submit" name="submit" value="Yes, remove." class="waves-effect waves-light btn">
		</form>
		<form class="col s6 left-align" action="index.php">
			<input type="submit" name="kidding" value="No, just kidding." class="waves-effect waves-light btn">
		</form>
   	</div>
   </div>

<?php include("../layouts/footer/user_footer.php"); ?>