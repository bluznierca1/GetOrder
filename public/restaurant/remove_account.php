<?php 
require_once("../../includes/initialize.php");
	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to user panel.";
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$message_user = "You are logged in as User. Can not go to restaurant panel.";
		redirect_to("../user/index.php");
	} else if (!$session_restaurant->is_logged_in() ){
		redirect_to("login.php");
	}
	
	if( !isset($_GET['restaurant_id']) ){
		$message_restaurant = "No id given. ";
		redirect_to("index.php");
	}

	if( isset($_POST['submit'] ) ){
		if( $restaurant->delete($_GET['restaurant_id']) && $restaurant->unmark_restaurant($_GET['restaurant_id']) ){
			$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);
			$session_restaurant->logout($restaurant);
			redirect_to("../index.php");
		}
	}

	$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);
	
?>

<?php include("../layouts/header/restaurant_header_menu.php"); ?>

	<div class="row">
		<div class="col s12 center-align">
			<h1 class="teal-text darken-2 restaurant-title">Are you leaving us, <?php echo $restaurant->name; ?>?</h2>
			<h2 class="restaurant-subtitle">Account Details:</h2>
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
              <th>Name</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>Address</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          	<td><?php echo htmlentities($restaurant->restaurant_id); ?></td>
            <td><?php echo htmlentities($restaurant->username); ?></td>
            <td><?php echo htmlentities($restaurant->created); ?></td>
            <td><?php echo htmlentities($restaurant->name); ?></td>
            <td><?php echo htmlentities($restaurant->phone_number); ?></td>
            <td><?php echo htmlentities($restaurant->email); ?></td>
            <td><?php echo htmlentities("{$restaurant->city}, {$restaurant->street} {$restaurant->number}"); ?></td>
          </tr>
        </tbody>
      </table>
	<br />
   	<div class="row">
		<form class="col s6 right-align" action="remove_account.php?restaurant_id=<?php echo htmlspecialchars($restaurant->restaurant_id); ?>" method="post">
			<input type="submit" name="submit" value="Yes, remove." class="waves-effect waves-light btn">
		</form>
		<form class="col s6 left-align" action="index.php">
			<input type="submit" name="kidding" value="No, just kidding." class="waves-effect waves-light btn">
		</form>
   	</div>

<?php include("../layouts/footer/restaurant_footer.php"); ?>