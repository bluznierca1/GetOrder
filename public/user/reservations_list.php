<?php require_once("../../includes/initialize.php"); ?>

<?php 
	
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

	// Checking if there are reservations that are done
	$reservations = Reservation::find_by_sql("SELECT * FROM reservation WHERE user_id = {$user->user_id} ");
	if ( $reservation->check_reservation_time($reservations, $user->user_id) ){
		redirect_to("reservations_list.php");
		$message_user = "Tables are updated.";
	}

	// looking for following reservations
	$reservations = Reservation::find_by_sql("SELECT * FROM reservation WHERE user_id = {$user->user_id} ORDER BY date_in ASC");
	// looking for all reservations 
	$all_reservations = Reservation::find_by_sql("SELECT * FROM display_reservations WHERE user_id = {$user->user_id} ORDER BY date_in DESC");
?>

<?php include("../layouts/header/user_header_menu.php"); ?>
	<div class="row">
		<div class="col s12 center-align">
			<h1 class="teal-text darken-2 center-align font-h1">Your Reservations</h1>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m8 offset-m2">
			<?php if( !empty($reservations) ){ ?>
				<h2 class="teal-text darken-2 center-align font-h2">Today</h2>
				<table class="centered stripped">
					<thead>
						<tr>
							<th>Restaurant's name</th>
							<th>Time</th>
							<th>Table's seats</th>
							<th>Created</th>
							<th>Remove</th>
						</tr>
					</thead>

				<?php 
					// looping through all of the reservations
					foreach( $reservations as $reservation ) {
					//looking for restaurant's name
					$restaurant = Restaurant::find_by_id($reservation->restaurant_id);
				?>
					<tbody>
						<tr>
							<td><?php echo $restaurant->name; ?></td>
							<td><?php echo $reservation->date_in; ?></td>
							<td><?php echo $reservation->booked_table; ?></td>
							<td><?php echo $reservation->created; ?></td>
							<td><a href="remove_reservation.php?reservation_id=<?php echo $reservation->reservation_id; ?>" style="color: red;"><i class="material-icons">remove</i></a></td>
						</tr>
					</tbody>
				<?php } ?>
			</table>
			<?php // option for case there are no reservations for today
				} else { 
			?>
					<h2 class="orange-text darken-2 center-align font-h2">No reservations for today :(</h2>
			<?php } ?>
		</div>
	</div>

	<br />
	<br />

	<div class="row">
		<div class="col s12 m8 offset-m2">
			<?php if( !empty($all_reservations) ){ ?>
				<h2 class="teal-text darken-2 center-align font-h2">All</h2>
				<table class="centered stripped">
					<thead>
						<tr>
							<th>Restaurant's name</th>
							<th>Time</th>
							<th>Table's seats</th>
							<th>Created</th>
						</tr>
					</thead>

				<?php 
					// looping through all of the reservations
					foreach( $all_reservations as $done_reservation ) {
					//looking for restaurant's name
					$restaurant = Restaurant::find_by_id($done_reservation->restaurant_id);
				?>
					<tbody>
						<tr>
							<td><?php echo $restaurant->name; ?></td>
							<td><?php echo $done_reservation->date_in; ?></td>
							<td><?php echo $done_reservation->booked_table; ?></td>
							<td><?php echo $done_reservation->created; ?></td>
						</tr>
					</tbody>
				<?php } ?>
			</table>
			<?php } ?>
		</div>
	</div>

<?php include("../layouts/footer/user_footer.php"); ?>

