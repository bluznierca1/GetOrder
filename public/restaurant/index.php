<?php 
require_once("../../includes/initialize.php");
	
	if ( $session_admin->is_logged_in() ){
		$session_admin->message("You are logged in as Admin. Can not go to restaurant panel.");
		redirect_to("../admin/index.php");
	} else if( $session_user->is_logged_in() ){
		$session_user->message("You are logged in as User. Can not go to restaurant panel.");
		redirect_to("../user/index.php");
	} else if (!$session_restaurant->is_logged_in() ){
		redirect_to("login.php");
	}

	$restaurant = Restaurant::find_by_id($_SESSION['restaurant_id']);
	$table = Table::find_by_restaurant_id($restaurant->restaurant_id);
	$available_tables = Table::find_available_by_restaurant_id($restaurant->restaurant_id);
	$logo = Logo::find_by_restaurant_id($restaurant->restaurant_id);

	// Submitting booking table by restaurant
	if( isset($_POST['submit_add_booked_table']) ){
		$holder = $_POST['table'];
		if( $table->minus_one_available($holder, $restaurant->restaurant_id) ){
			$session_restaurant->message("Your tables are updated. Remember to unbook that tables!");
			redirect_to("index.php");
		}
	}
	// submitting unbooking tables by restaurant 
	if( isset($_POST['submit_unbooked_table']) ){
		$holder = $_POST['table'];
		if( $table->add_one_available($holder, $restaurant->restaurant_id, null) ){
			$session_restaurant->message("Your tables are updated.");
			redirect_to("index.php");
		}
	}

	// Submiting total amount of tables
	if( isset($_POST['submit_tables']) ){
		$one_seat = $database->escape_value($_POST['one_seat']);
		$two_seats = $database->escape_value($_POST['two_seats']);
		$three_seats = $database->escape_value($_POST['three_seats']);
		$four_seats = $database->escape_value($_POST['four_seats']);
		$five_seats = $database->escape_value($_POST['five_seats']);
		$six_seats = $database->escape_value($_POST['six_seats']);


		if( !isset($available_tables->restaurant_id) ){
			if( Table::insert_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant->restaurant_id) ){
				if( Table::add_available_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant->restaurant_id) ){
					$session_restaurant->message("Your tables are updated.");
					redirect_to("index.php");
				}
			} else {
				$session_restaurant->message("Something went wrong.");
				redirect_to("index.php");
			}
		} else {
			if( Table::edit_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant->restaurant_id) ){
				if( $table->edit_available_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant->restaurant_id) ){
					$session_restaurant->message("Your tables are updated.");
					redirect_to("index.php");
				}
			}
		}

		// submiting caption
	}	else if( isset($_POST['submit_caption']) ){
		$caption = $database->escape_value($_POST['caption']);

		if( Restaurant::edit_caption($caption, $restaurant->restaurant_id) ){
			$session_restaurant->message("Your caption has been edited.");
			redirect_to("index.php");
		} else {
			$message_restaurant = "Something went wrong. Try again.";
			redirect_to("index.php");
		}

		// submiting logo
	} else if ( isset($_POST['submit_logo']) ){
		$max_file_size = 1048576; // expressed in bytes
	
		$logo = new Logo();
		$logo->restaurant_id = $restaurant->restaurant_id;
		$logo->attach_file($_FILES['file_upload']);
		if($logo->save() ){
			//Success
			$session_restaurant->message("Your photo was uploaded successfully.");
			redirect_to("index.php");
		} else {
			// Failure
			$message_restaurant = join("<br /> ", $logo->errors);
		}
	}
		// Removing existing logo
	else if (isset($_POST['submit_destroy']) ){
		$logo = Logo::find_by_restaurant_id($restaurant->restaurant_id);
			if( $logo && $logo->destroy() ){
				$session_restaurant->message("Photo {$photo->filename} was deleted.");
				redirect_to("index.php");
			} else {
				$session_restaurant->message("The photo could not be removed.");
				redirect_to("index.php");
			}
	}
	
?>
<?php echo isset($holder) ? $holder : ""; ?>
<?php include("../layouts/header/restaurant_header_menu.php"); ?>

	<div class="row">
		<div class="col s12 center-align">
			<h3 class="restaurant-panel-message"><?php echo display_message_errors($session_restaurant->message_restaurant); ?></h3>
			<h1 class="teal-text darken-2 restaurant-title">Hello, <?php echo $restaurant->name; ?>!</h1>
			<h2 class="restaurant-subtitle">Here is your panel.</h2>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col s12 m6 offset-m3 restaurant-card">
		  <div class="card horizontal">
		    <div class="card-image responsive-img" style="height: auto;">
		      <img src="../logo/<?php echo $logo->filename; ?>" class="card-image" alt="logo">
		    </div>
		    <div class="card-stacked">
		      <div class="card-content">
		      	<h3 class="card-title center-align teal-text darken-2"><?php echo $restaurant->name; ?></h3>
		        <p class="card-caption center-align"><?php echo $restaurant->caption != "" ? $restaurant->caption : "No description so far."; ?></p>
		      </div>
		      <p class="right-align card-address teal-text darken-2"><?php echo "{$restaurant->city}, {$restaurant->street} {$restaurant->number}"; ?></p>
		    </div>
		  </div>
		</div>
	</div>

	<br />
	<br />
	
	<div class="row">
		<div class="col s12 m8 offset-m2">
	<table class="centered striped">
        <thead>
          <tr>
              <th>Displays</th>
              <th>Reservations</th>
          </tr>
        </thead>

        <tbody>
          <tr>
          	<td>172</td>
          	<td>21</td>
          </tr>
        </tbody>
      </table>
     </div>
  </div>

  <br />
	<br />

	<div class="row">
		<div class="col s12 m8 offset-m2">
		<!-- displaying all of the available tables  -->
		<h2 class="teal-text darken-2 center-align" style="font-size: 2em">Available Tables</h2>
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

  <div class="row">
		<div class="col s8 offset-s2 s6">
		<!-- buttons that are opening menus for updating available tables -->
		<div class="col s6 center-align" style="padding: 1em 0 1em 0;">
			<button id="edit-available-tables-button" class="btn orange darken-2">Click me to Book Table</button>
		</div>
		<div class="col s6 center-align" style="padding: 1em 0 1em 0;">
				<button id="edit-available-tables-unbook-button" class="btn orange darken-2">Click me to Unbook Table</button>
			</div>
		<div class="edit-available-tables-form-hidden" id="edit-available-tables-container">
			<form action="index.php" method="post">
				<!-- locked options are when there are 0 available seats -->
				<div class="input-field col s12 m8 offset-m2">
			    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">Choose table</p>
			    <select name="table">
						<option value="1" <?php echo $available_tables->one_seat < 1 ? 'disabled' : "" ?> >1 seat table</option>
						<option value="2" <?php echo $available_tables->two_seats < 1 ? 'disabled' : "" ?> >2 seats table</option>
						<option value="3" <?php echo $available_tables->three_seats < 1 ? 'disabled' : "" ?> >3 seats table</option>
						<option value="4" <?php echo $available_tables->four_seats < 1 ? 'disabled' : "" ?> >4 seats table</option>
						<option value="5" <?php echo $available_tables->five_seats < 1 ? 'disabled' : "" ?> >5 seats table</option>
						<option value="6" <?php echo $available_tables->six_seats < 1 ? 'disabled' : "" ?> >6 seats table</option>
			    </select>
			  </div>

			  <div class="input-field col s12 center-align">
					<input type="submit" name="submit_add_booked_table" id="submit_book_table" class="btn" value="Add booked table">
			  </div>
		  </form>
	  </div>
			
			<!-- Here are locked options when amount of available seats is equal to the total amount of tables  -->
			<div class="edit-available-tables-unbook-form-hidden" id="edit-available-tables-unbook-container">
				<form action="index.php" method="post">
					<div class="input-field col s12 m8 offset-m2">
				    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">Choose table</p>
				    <select name="table">
							<option value="1" <?php echo $available_tables->one_seat >= $table->one_seat ? 'disabled' : "" ?> >1 seat table</option>
							<option value="2" <?php echo $available_tables->two_seats >= $table->two_seats ? 'disabled' : "" ?> >2 seats table</option>
							<option value="3" <?php echo $available_tables->three_seats >= $table->three_seats ? 'disabled' : "" ?> >3 seats table</option>
							<option value="4" <?php echo $available_tables->four_seats >= $table->four_seats ? 'disabled' : "" ?> >4 seats table</option>
							<option value="5" <?php echo $available_tables->five_seats >= $table->five_seats ? 'disabled' : "" ?> >5 seats table</option>
							<option value="6" <?php echo $available_tables->six_seats >= $table->six_seats ? 'disabled' : "" ?> >6 seats table</option>
				    </select>
				  </div>

					<div class="input-field col s12 center-align">
						<input type="submit" name="submit_unbooked_table" id="submit_book_table" class="btn" value="Unbook table">
					</div>
			  </form>
	  	</div>
	  </div>
  </div>



  <div class="row">
		<div class="col s12 m8 offset-m2">
			<!-- displaying all of the tables in general -->
			<h3 class="teal-text darken-2 center-align" style="font-size: 2em">Tables</h3>
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
          	<td><?php echo isset($table->one_seat) ? htmlentities($table->one_seat) : "0"; ?></td>
          	<td><?php echo isset($table->two_seats) ? htmlentities($table->two_seats) : "0"; ?></td>
          	<td><?php echo isset($table->three_seats) ? htmlentities($table->three_seats) : "0"; ?></td>
          	<td><?php echo isset($table->four_seats) ? htmlentities($table->four_seats) : "0"; ?></td>
          	<td><?php echo isset($table->five_seats) ? htmlentities($table->five_seats) : "0"; ?></td>
          	<td><?php echo isset($table->six_seats) ? htmlentities($table->six_seats) : "0"; ?></td>
          </tr>
        </tbody>
      </table>
     </div>
  </div>
	
	<br />
	<br />
	
	<div class="row">
		<div class="col s8 offset-s2 s6">
		<!-- panel for editing total amount of tables in restaurant  -->
		<div class="col s12 center-align" style="padding: 1em 0 1em 0;">
			<button id="edit-tables-button" class="btn orange darken-2">Click me to Edit tables</button>
		</div>
		<div class="edit-tables-form-hidden" id="edit-tables-container">
		<form action="index.php" method="post">

		<div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">1 seat table</p>
	    <select name="one_seat">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" 
	      	<?php 
	      	//checking if there are already added tables for that restaurant
	      		if( isset($table->one_seat) ) {
	      			// if added - adding selected property for option HTML
	      			echo $table->one_seat == $a ? "selected" : "";
	      		} ?> ><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">2 seats table</p>
	    <select name="two_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" 
	      <?php 
	      	//checking if there are already added tables for that restaurant
	      		if( isset($table->two_seats) ) {
	      			// if added - adding selected property for option HTML
	      			echo $table->two_seats == $a ? "selected" : "";
	      		} ?> ><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">3 seats table</p>
	    <select name="three_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" 
	      <?php 
	      	//checking if there are already added tables for that restaurant
	      		if( isset($table->three_seats) ) {
	      			// if added - adding selected property for option HTML
	      			echo $table->three_seats == $a ? "selected" : "";
	      		} ?> ><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">4 seats table</p>
	    <select name="four_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>"
	      <?php 
	      	//checking if there are already added tables for that restaurant
	      		if( isset($table->four_seats) ) {
	      			// if added - adding selected property for option HTML
	      			echo $table->four_seats == $a ? "selected" : "";
	      		} ?> ><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">5 seats table</p>
	    <select name="five_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>"
	      <?php 
	      	//checking if there are already added tables for that restaurant
	      		if( isset($table->five_seats) ) {
	      			// if added - adding selected property for option HTML
	      			echo $table->five_seats == $a ? "selected" : "";
	      		} ?> ><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">6 seats table</p>
	    <select name="six_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>"<?php 
	      	//checking if there are already added tables for that restaurant
	      		if( isset($table->six_seats) ) {
	      			// if added - adding selected property for option HTML
	      			echo $table->six_seats == $a ? "selected" : "";
	      		} ?> ><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

		  <div class="input-field col s12 center-align">
				<input type="submit" name="submit_tables" id="submit_tables" class="btn" value="Submit">
		  </div>
	  </form>
	  </div>
	  </div>
  </div>

  <br />
  <div class="divider"></div>
  <br />
	<!-- panel for uploading/removing logo  -->
	<!-- // Make it depended on if link to logo exists -->
	<?php 
		if( isset($logo->filename) ){
	?>
		<div class="row">
			<div class="col s12 m8 offset-m2">	
				<h3 class="center-align font-h3 orange-text text-darken-2">
					You already have uploaded logo. Remove current to upload new one.
				</h3>
					<form action="index.php" method="post">
						<div class="input-field center-align col s12">
							<input type="submit" name="submit_destroy" class="btn" value="Remove">
						</div>
					</form>
			</div>
		</div>	 
	<?php
		} else {
	?>
	<div class="row">
		<div class="col s12 m8 offset-m2">
			<h5 class="file-input-title center-align teal-text darken-2">Upload Logo</h5>

	<form action="index.php" method="post" enctype="multipart/form-data">
    <div class="file-field input-field">
      <div class="btn orange darken-2">
        <span>File</span>
        <input type="file" name="file_upload">
      </div>
      <div class="file-path-wrapper">
      	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>">
        <input class="file-path validate" type="text">
      </div>
    </div>
    <div class="col s12 center-align">
    	<input type="submit" name="submit_logo" value="Upload" class="btn">
    </div>
  </form>
	<?php } ?>
  </div>
  </div>

  <br />
  <div class="divider"></div>
  <br />
	
	<!-- panel for adding caption -->
	<div class="row">
	  <form class="col s12" method="post" action="index.php">
	    <div class="row">
	      	<h1 class="caption-title center-align teal-text darken-2"><?php echo $restaurant->caption == "" ? "Add " : "Edit "; ?> Caption</h1>
	      	<div class="input-field col s12 m8 offset-m2">
	        <textarea id="caption" class="materialize-textarea caption-text" name="caption"><?php echo isset($restaurant->caption) ? htmlentities($restaurant->caption) : ""; ?></textarea>
	      </div>
	      <div class="input-field col s12 center-align">
					<input type="submit" name="submit_caption" id="submit_caption" value="Submit" class="waves-effect waves-light btn">
	      </div>
	    </div>
	  </form>
  </div>

<?php include("../layouts/footer/restaurant_footer.php"); ?>