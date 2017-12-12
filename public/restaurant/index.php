<?php 
require_once("../../includes/initialize.php");
	
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


	// Submiting tables
	if( isset($_POST['submit_tables']) ){
		$one_seat = $database->escape_value($_POST['one_seat']);
		$two_seats = $database->escape_value($_POST['two_seats']);
		$three_seats = $database->escape_value($_POST['three_seats']);
		$four_seats = $database->escape_value($_POST['four_seats']);
		$five_seats = $database->escape_value($_POST['five_seats']);
		$six_seats = $database->escape_value($_POST['six_seats']);


		if( !isset($available_tables->restaurant_id) ){
			if( Table::insert_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant->restaurant_id) ){
				if( $table->add_available_tables() ){
					$message_restaurant = "Your tables are updated.";
				}
			} else {
				$message_restaurant = "Something went wrong.";
			}
		} else {
			if( Table::edit_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant->restaurant_id) ){
				if( $table->edit_available_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant->restaurant_id) ){
					$message_restaurant = "Your tables are updated.";
					redirect_to("index.php");
				}
			}
		}

		// submiting caption
	}	else if( isset($_POST['submit_caption']) ){
		$caption = $database->escape_value($_POST['caption']);

		if( Restaurant::edit_caption($caption, $restaurant->restaurant_id) ){
			$message_restaurant = "Your caption has been edited.";
			redirect_to("index.php");
		} else {
			$message_restaurant = "Something went wrong. Try again.";
			redirect_to("index.php");
		}
	} else if ( isset($_POST['submit_logo']) ){
		
	}
	
?>
<?php include("../layouts/header/restaurant_header_menu.php"); ?>
	<div class="row">
		<div class="col s12 center-align">
			<h3 class="restaurant-panel-message"><?php echo display_message_errors($message_restaurant); ?></h3>
			<h1 class="teal-text darken-2 restaurant-title">Hello, <?php echo $restaurant->name; ?>!</h1>
			<h2 class="restaurant-subtitle">Here is your panel.</h2>
		</div>
	</div>
	<br />

	<div class="row">
		<div class="col s12 m8 offset-m2 restaurant-card">
		  <div class="card horizontal">
		    <div class="card-image responsive-img" style="height: auto;">
		      <img src="images/stary_mlyn.jpg" class="card-image">
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
		<div class="col s12 m8 offset-m2">
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
		
		<div class="col s12 center-align" style="padding: 1em 0 1em 0;">
			<button id="edit-tables-button" class="btn">Click me to Edit tables</button>
		</div>
		<div class="edit-tables-form-hidden" id="edit-tables-container">
		<form action="index.php" method="post">

		<div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">1 seat table</p>
	    <select name="one_seat">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" <?php echo $table->one_seat == $a ? "selected" : "" ?>><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">2 seats table</p>
	    <select name="two_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" <?php echo $table->two_seats == $a ? "selected" : "" ?>><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">3 seats table</p>
	    <select name="three_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" <?php echo $table->three_seats == $a ? "selected" : "" ?>><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">4 seats table</p>
	    <select name="four_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" <?php echo $table->four_seats == $a ? "selected" : "" ?>><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">5 seats table</p>
	    <select name="five_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" <?php echo $table->five_seats == $a ? "selected" : "" ?>><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
	      <?php } ?>
	    </select>
	  </div>

	  <div class="input-field col s12 m6">
	    <p class="teal-text darken-2 center-align" style="font-size: 1.3em;">6 seats table</p>
	    <select name="six_seats">
	      <?php for( $a = 0; $a <= 6; $a++) { ?>
	      <option value="<?php echo $a; ?>" <?php echo $table->six_seats == $a ? "selected" : "" ?> ><?php echo $a != 1 ? "{$a} tables" : "{$a} table"; ?> </option>
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
  <br />
	
	<!-- // Make it depended on if link to logo exists -->
	<div class="row">
		<div class="col s12 m8 offset-m2">
			<h5 class="file-input-title center-align teal-text darken-2">Upload Logo</h5>
			<form action="#">
		    <div class="file-field input-field">
		      <div class="btn">
		        <span>File</span>
		        <input type="file">
		      </div>
		      <div class="file-path-wrapper">
		        <input class="file-path validate" type="text">
		      </div>
		    </div>
		  </form>
  </div>
  </div>

  <br />
  <br />
	
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