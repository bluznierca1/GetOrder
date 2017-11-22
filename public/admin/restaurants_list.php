<?php require_once("../../includes/initialize.php"); ?>

<?php 
	if( $session_admin->is_logged_in() ){
		$restaurants = Restaurant::restaurants_marked();
	} else {
		redirect_to("login.php");
	}
?>

<?php include("../layouts/header/admin_header_menu.php"); ?>
	<div class="row">
  <div class="s12 center-align">
    <h2 class="teal-text lighten-2">Marked</h2>
    <p><?php echo isset($_SESSION['admin_message']) ? display_message_errors($_SESSION['admin_message']) : ""; ?></p>
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
              <th>Edit</th>
              <th>Remove</th>
          </tr>
        </thead>
        <tbody>
 <?php foreach( $restaurants as $restaurant ) { ?>
          <tr>
          	<td><?php echo $restaurant->restaurant_id; ?></td>
            <td><?php echo $restaurant->username; ?></td>
            <td><?php echo $restaurant->created; ?></td>
            <td><?php echo $restaurant->name; ?></td>
            <td><?php echo $restaurant->email; ?></td>
            <td><?php echo $restaurant->city; ?></td>
            <td><?php echo $restaurant->street; ?></td>
            <td><?php echo $restaurant->number; ?></td>
            <td><?php echo $restaurant->zip_code; ?></td>
            <td><?php echo $restaurant->phone_number; ?></td>
            <td><a href="#" style="color: red;"><i class="material-icons">edit</i></a></td>
            <td><a href="#" style="color: red;"><i class="material-icons">remove</i></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table>
     </div>
   </div>

  
   <div class="row">
  <div class="s12 center-align">
    <h2 class="teal-text lighten-2">To Mark </h2>
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
              <th>Mark</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          $restaurants_to_mark = Restaurant::restaurants_to_mark();
        ?>
        <?php foreach( $restaurants_to_mark as $mark ) { ?>
          <tr>
            <td><?php echo $mark->restaurant_id; ?></td>
            <td><?php echo $mark->username; ?></td>
            <td><?php echo $mark->created; ?></td>
            <td><?php echo $mark->name; ?></td>
            <td><?php echo $mark->email; ?></td>
            <td><?php echo $mark->city; ?></td>
            <td><?php echo $mark->street; ?></td>
            <td><?php echo $mark->number; ?></td>
            <td><?php echo $mark->zip_code; ?></td>
            <td><?php echo $mark->phone_number; ?></td>
            <td><a href="mark_restaurant.php?restaurant_id=<?php echo $mark->restaurant_id; ?>" style="color: green;"><i class="material-icons">assignment_turned_in</i></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table> 
     </div>
   </div>
   
 <?php include("../layouts/footer/admin_footer.php"); ?>