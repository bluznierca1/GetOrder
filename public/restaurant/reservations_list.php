<?php require_once("../../includes/initialize.php"); ?>

<?php	
	if ( $session_admin->is_logged_in() ){
		$message_admin = "You are logged in as Admin. Can not go to restaurant panel.";
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$message_user = "You are logged in as User. Can not go to restaurant panel.";
		redirect_to("../user/index.php");
	} else if (!$session_restaurant->is_logged_in() ){
		redirect_to("login.php");
	}

	$restaurant = Restaurant::find_by_id($_SESSION['restaurant_id']);
	$table = Table::find_by_restaurant_id($restaurant->restaurant_id);
	$available_tables = Table::find_available_by_restaurant_id($restaurant->restaurant_id);
	$reservations = Reservation::find_by_sql("SELECT * FROM reservation WHERE restaurant_id = {$restaurant->restaurant_id} ORDER BY date_in ASC");
	$all_reservations = Reservation::find_by_sql("SELECT * FROM display_reservations WHERE restaurant_id = {$restaurant->restaurant_id} ORDER BY date_in DESC");

?>

<?php include("../layouts/header/restaurant_header_menu.php"); ?>

<div class="row">
		<div class="col s12 center-align">
			<h1 class="teal-text darken-2 center-align font-h1">Your Reservations</h1>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m8 offset-m2">
			<?php if( !empty($reservations) ){ ?>
				<h2 class="teal-text darken-2 center-align font-h2">For today</h2>
				<table class="centered stripped">
					<thead>
						<tr>
							<th>For</th>
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
					$user = User::find_by_id($reservation->user_id);
				?>
					<tbody>
						<tr>
							<td><?php echo "{$user->first_name} {$user->last_name}"; ?></td>
							<td><?php $time = strtotime($reservation->date_in);
							 	echo date("H:m", time($time));
							 ?></td></td>
							<td><?php echo $reservation->booked_table; ?></td>
							<td><?php echo $reservation->created; ?></td>
							<td><a href="remove_reservation.php?reservation_id=<?php echo $reservation->reservation_id; ?>" style="color: red;"><i class="material-icons">remove</i></a></td>
						</tr>
					</tbody>
				<?php } ?>
			</table>
			<?php 
				} else { // option for case there are no reservations for today
			?>
				<h2 class="orange-text darken-2 center-align font-h2">No reservations for today :(</h2>
			<?php
			} ?>
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
							<th>For</th>
							<th>Time</th>
							<th>Table's seats</th>
							<th>Created</th>
						</tr>
					</thead>

				<?php 
					// looping through all of the reservations
					foreach( $all_reservations as $done_reservation ) {
					//looking for restaurant's name
					$user = User::find_by_id($done_reservation->user_id);
				?>
					<tbody>
						<tr>
							<td><?php echo "{$user->first_name} {$user->last_name}"; ?></td>
							<td><?php echo $done_reservation->date_in; ?></td>
							<td><?php echo $done_reservation->booked_table; ?></td>
							<td><?php echo $done_reservation->created; ?></td>
						</tr>
					</tbody>
				<?php } ?>
			</table>
			<?php } else { ?>
				<h2 class="teal-text darken-2 center-align font-h2">Nothing at all.</h2>
			<?php } ?>
		</div>
	</div>

<?php include("../layouts/footer/restaurant_footer.php"); ?>