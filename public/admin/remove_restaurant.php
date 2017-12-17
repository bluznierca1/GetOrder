<?php require_once("../../includes/initialize.php"); ?>

<?php 
	
	if ( !$session_admin->is_logged_in() ){
		redirect_to("login.php");
	} else if( $session_user->is_logged_in() ){
		$session_user->message("You are logged in as User. Can not go to Admin panel.");
		redirect_to("../user/index.php");
	} else if ($session_restaurant->is_logged_in() ){
		$session_restaurant->message("You are logged in as Restaurant. Can not go to admin panel.");
		redirect_to("../restaurant/index.php");
	}

	if( !isset($_GET['restaurant_id']) ){
		$session_admin->message("No restaurant_id given.");
		redirect_to("restaurants_list.php");
	}

	$admin = Admin::find_by_id($_SESSION['admin_id']);
	$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);

	if( isset($_POST['submit']) ){
		$id = $restaurant->restaurant_id;

		if( $restaurant->delete($id) ){
			$session_admin->message("Restaurant {$restaurant->name} has got removed.");
			redirect_to("restaurants_list.php");
		} else {
			$session_restaurant->message("Something went wrong.");
			redirect_to("restaurants_list.php");
		}
	}
?>

<?php include("../layouts/header/admin_header_menu.php"); ?>
	<div class="row">
		<div class="col s12 center-align">
			<h1 class="admin-title teal-text darken-2">Removing <?php echo htmlentities($restaurant->name); ?></h1>
		</div>
	</div>

	<div class="s12 table-container">
    	<table class="responsive-table bordered">
        <thead>
          <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Created</th>
              <th>Name</th>
              <th>Email</th>
              <th>City</th>
              <th>Street</th>
              <th>Number</th>
              <th>Zip Code</th>
              <th>Phone number</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          	<td><?php echo htmlentities($restaurant->restaurant_id); ?></td>
            <td><?php echo htmlentities($restaurant->username); ?></td>
            <td><?php echo htmlentities($restaurant->created); ?></td>
            <td><?php echo htmlentities($restaurant->name); ?></td>
            <td><?php echo htmlentities($restaurant->email); ?></td>
            <td><?php echo htmlentities($restaurant->city); ?></td>
            <td><?php echo htmlentities($restaurant->street); ?></td>
            <td><?php echo htmlentities($restaurant->number); ?></td>
            <td><?php echo htmlentities($restaurant->zip_code); ?></td>
            <td><?php echo htmlentities($restaurant->phone_number); ?></td>
          </tr>
 
        </tbody>
      </table>
      <br />
	<form class="col s12" action="remove_restaurant.php?restaurant_id=<?php echo htmlentities($restaurant->restaurant_id); ?>" method="post" role="form">
      <div class="input-field col s12 center-align">
			<input type="submit" class="waves-effect waves-light btn" name="submit" value="Remove" >
        </div>
    </form>
	
<?php include("../layouts/footer/admin_footer.php"); ?>