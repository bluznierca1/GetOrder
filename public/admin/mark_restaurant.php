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

	$admin = Admin::find_by_id($_SESSION['admin_id']);
	$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);

	if( isset($_POST['submit']) ){
		$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);	
		$lng = $database->escape_value($_POST['lng']);
		$lat = $database->escape_value($_POST['lat']);
		
	if( $restaurant ){
		if( Restaurant::insert_into_markers($restaurant, $lat, $lng) ){
			$session_admin->message("Restaurant: {$restaurant->name} is now on the map!");
			redirect_to("restaurants_list.php"); 
			
		} else {
			$session_admin->message("Something went wrong. Try again.");
			redirect_to("restaurants_list.php");
		}
	} else {
		$session_admin->message("Restaurant could not be found.");
			redirect_to("restaurants_list.php");
	}		
	}

?>

	<?php include("../layouts/header/admin_header_menu.php"); ?>
	<?php 
		$address = $restaurant->city;
		$address .= ", ";
		$address .= $restaurant->street . " " . $restaurant->number;
	?>
	<div class="row">
    <form class="col s12" action="mark_restaurant.php?restaurant_id=<?php echo $restaurant->restaurant_id; ?>" method="post">
      <div class="row">
        <div class="input-field col s6">
          <input value="<?php echo htmlentities($restaurant->name); ?>" id="name" name="name" type="text" class="validate">
          <label for="name">Name</label>
        </div>
        <div class="input-field col s6">
          <input value="<?php echo htmlentities($address); ?>" id="address" type="text" class="validate" name="address">
          <label for="address">Address</label>
        </div>
      </div>
        <div class="input-field col s6">
          <input id="lat" type="text" class="validate" name="lat">
          <label for="lat">Lat</label>
        </div>

        <div class="input-field col s6">
          <input id="lng" type="text" class="validate" name="lng">
          <label for="lng">Lng</label>
        </div>
      	
      	<div class="row">
			<div class="col s12 center-align">
				<input type="submit" name="submit" value="Submit" class="waves-effect waves-light btn">
		</div>
      	</div>
      
    </form>
  </div>

	<?php include("../layouts/footer/admin_footer.php"); ?>
