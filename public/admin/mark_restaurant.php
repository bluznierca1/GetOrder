<?php require_once("../../includes/initialize.php"); ?>

<?php 
	

	$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);

	if( isset($_POST['submit']) ){
		$restaurant = Restaurant::find_by_id($_GET['restaurant_id']);	
		$lng = $database->escape_value($_POST['lng']);
		$lat = $database->escape_value($_POST['lat']);
		
	if( $restaurant ){
		if( Restaurant::insert_into_markers($restaurant, $lat, $lng) ){
			$_SESSION['admin_message'] = "Restaurant: {$restaurant->name} is now on the map!";
			redirect_to("restaurants_list.php"); 
			
		} else {
			$_SESSION['admin_message'] = "Something went wrong. Try again.";
			redirect_to("restaurants_list.php");
		}
	} else {
		$_SESSION['admin_message'] = "Restaurant could not be found.";
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
          <input value="<?php echo $restaurant->name; ?>" id="name" name="name" type="text" class="validate">
          <label for="name">Name</label>
        </div>
        <div class="input-field col s6">
          <input value="<?php echo $address?>" id="address" type="text" class="validate" name="address">
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
