<?php require_once("../includes/initialize.php"); ?>

<?php 
		
	if( !isset($_GET['restaurant_id']) || $_GET['restaurant_id'] == ""){
		redirect_to("index.php");
	}

	global $errors;
	$message_error = "";

	if( isset($_SESSION['user_id']) ){
		$user = User::find_by_id($_SESSION['user_id']);
	}

	$restauranta = Restaurant::find_by_id($_GET['restaurant_id']);
	$available_tables = Table::find_available_by_restaurant_id($restauranta->restaurant_id);
	$table = Table::find_by_restaurant_id($restauranta->restaurant_id);

	// $if = $reservation->check_time($restauranta->restaurant_id);
	$reservations = Reservation::find_by_sql("SELECT * FROM reservation WHERE restaurant_id = {$restauranta->restaurant_id} ");
	if ( $reservation->check_reservation_time($reservations, $restauranta->restaurant_id) ){
		$session_user->message("Tables are updated.");
		redirect_to("chosen_restaurant.php?restaurant_id={$restauranta->restaurant_id}");
	}
	
	if( isset($_POST['submit']) ){

		$required_fields = ['time', 'table'];
		fields_are_filled($required_fields);

		if( empty($errors) ){
			$date_in = $database->escape_value($_POST['time']); //getting only H:m from $_POST
			$today = date("Y-m-d", time() +3600); // Getting today's date as reservations are only for today
			$reservation->date_in = date("Y-m-d H:m:s", strtotime($today . " " . $date_in) ); // connected times for reservations
			$reservation->user_id = $database->escape_value($_SESSION['user_id']); 
			$date_out = date("H:i:s", strtotime($date_in) + 7200); // reservation is for 2 hours or till it is removed by restaurant
			$reservation->date_out = $today . " " . $date_out; // f. ex. 23:08
			$reservation->restaurant_id = $database->escape_value($restauranta->restaurant_id);
			$reservation->booked_table = $database->escape_value($_POST['table']);
			$reservation->created = date("Y-m-d H:i:s", time() ); // cause there is GMT +00

			//checking if chosen time is right
			if( strtotime($reservation->date_in) > (strtotime($restauranta->open_to) - 7200 ) ){
				$message_error = "Pick up a time 2 hours before restaurant is closed.";
			} else if ( strtotime($reservation->date_in) < strtotime($restauranta->open_from) ){
				$message_error = "Pick up a time when restaurant is open.";
			} else if( strtotime($reservation->date_in) < strtotime($reservation->created) ){
				$message_error = "Pick up a future time.";
			}	else {
				// chosen time is OK
				// 1. Creating reservation
				if( $reservation->create() ){
					// 2. Substracting one table from available tables
					if( $table->minus_one_available($reservation->booked_table, $restauranta->restaurant_id) ){
						$message_user = "Your reservation is done.";
						redirect_to("chosen_restaurant.php");
					} else {
						$message_user = "Something went wrong.";	
					}
				} else {
					// Something is wrong
					$message_user = "Something went wrong.";
					redirect_to("user/index.php");
				}
			}	
		}
	}

?>

<?php include("layouts/header/header_menu.php"); ?>
	<div class="row">
			<div class="col s12 m8 offset-m2 restaurant-card">
				<?php echo display_message_errors($session_user->message_user); ?>  
			  <div class="card horizontal">
			    <div class="card-image responsive-img" style="height: auto;">
			      <img src="" class="card-image" alt="restaurant's logo">
			    </div>
			    <div class="card-stacked">
			      <div class="card-content">
			      	<p class="card-title center-align teal-text darken-2"><?php echo $restauranta->name; ?></p>
			        <p class="card-caption center-align"><?php echo $restauranta->caption != "" ? $restauranta->caption : "No description so far."; ?></p>
			      </div>
			      <p class="right-align card-address teal-text darken-2"><?php echo "{$restauranta->city}, {$restauranta->street} {$restauranta->number}"; ?></p>
			    </div>
			  </div>
			</div>
		</div>
	
		<br />
		<br />

	<div class="row">
		<h1 class="teal-text darken-2 center-align table-title" >Tables in restaurant</h1>
		<div class="col s12 m8 offset-m2">
			<table class="centered striped">
        <thead>
          <tr>
              <th>1 seat table</th>
              <th>2 seats table</th>
              <th>3 seats table</th>
              <th>4 seats table</th>
              <th>5 seats table</th>
              <th>6 seats table</th>
          </tr>
        </thead>

        <tbody>
          <tr>
	         	<td><?php echo isset($available_tables->one_seat) ? htmlentities($available_tables->one_seat) : "0"; ?></td>
	         	<td><?php echo isset($available_tables->two_seats) ? htmlentities($available_tables->two_seats) : "0"; ?></td>
	         	<td><?php echo isset($available_tables->three_seats) ? htmlentities($available_tables->three_seats) : "0"; ?></td>
	         	<td><?php echo isset($available_tables->four_seats) ? htmlentities($available_tables->four_seats) : "0"; ?></td>
	         	<td><?php echo isset($available_tables->five_seats) ? htmlentities($available_tables->five_seats) : "0"; ?></td>
	          <td><?php echo isset($available_tables->six_seats) ? htmlentities($available_tables->six_seats) : "0"; ?></td>
          </tr>
        </tbody>
      </table>
     </div>
  </div>

	<br />
	<?php echo display_errors($errors); ?>
	<br />
	
	<?php 
		// checking if there is user session on
		// if not - no option for booking tables
		if( isset($user->user_id) ) {
	 		if( !$reservation->user_has_reservation($user->user_id, $restauranta->restaurant_id)) { ?>
			  <div class="row">
					<div class="s12 m6">
						<h3 class="teal-text darken-2 center-align font-h3">
							Open: <?php echo "{$restauranta->open_from} - {$restauranta->open_to} "; ?> 
						</h3>
						<p class="teal-text darken-2 center-align" style="color:red">Book a table minimum 2 hours before restaurant is closed.</p>
						<?php echo empty($errors) ? display_errors($errors) : "" ; ?>
						<?php echo display_message_errors($message_error); ?>
						
						<form class="s12 edit-form" action="chosen_restaurant.php?restaurant_id=<?php echo $restauranta->restaurant_id; ?>" method="post" >
							<div class="input-field col s12 m5 offset-m1">
								<input type="text" id="time" name="time" class="timepicker" placeholder="Pick up a time">
							</div>
							
							<div class="input-field col s12 m5 validate">
						    <select name="table">
						      <option value="1" <?php echo $available_tables->one_seat < 1 ? 'disabled' : "" ?> >1 seat table</option>
						      <option value="2" <?php echo $available_tables->two_seats < 1 ? 'disabled' : "" ?> >2 seats table</option>
						      <option value="3" <?php echo $available_tables->three_seats < 1 ? 'disabled' : "" ?> >3 seats table</option>
						      <option value="4" <?php echo $available_tables->four_seats < 1 ? 'disabled' : "" ?> >4 seats table</option>
						      <option value="5" <?php echo $available_tables->five_seats < 1 ? 'disabled' : "" ?> >5 seats table</option>
						      <option value="6" <?php echo $available_tables->six_seats < 1 ? 'disabled' : "" ?> >6 seats table</option>
								</select>
							</div>

						  <div class="col s12 center-align">
								<input type="submit" name="submit" value="Reserve" class="waves-effect waves-light btn" >
						 	</div>
						</form>

					</div>
				</div>
	<?php // end of if( !$reservation->user_has_reservation($user->user_id, $restauranta->restaurant_id))
			} else {
			?>
				<h3 class="red-text darken-2 center-align">Not able to reserve.</h3>
				<h4 class="teal-text darken-2 center-align font-h4">You have already made reservation for that restaurant.
					Remove existing one to be able to reserve again. <br />
					<p><a href="user/reservations_list.php">Go to Reservations</a></p> </h4>
		<?php }
		} else { // end of user session on
		?>
			<h3 class="red-text text-red-darken-2 font-h3 center-align">
				You need to be registered as user to book a table.
			</h3>
		<?php
		}
	 ?>			

<?php include("layouts/footer/footer.php"); ?>