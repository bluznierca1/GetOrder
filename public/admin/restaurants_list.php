<?php require_once("../../includes/initialize.php"); ?>

<?php 

  if ( !$session_admin->is_logged_in() ){
    $message_admin = "You are not logged in. Just do it.";
    redirect_to("login.php");
  } else if( $session_user->is_logged_in() ){
    $message_user = "You are logged in as User. Can not go to Admin panel.";
    redirect_to("../user/index.php");
  } else if ($session_restaurant->is_logged_in() ){
    $message_restaurant = "You are logged in as Restaurant. Can not go to admin panel.";
    redirect_to("../restaurant/index.php");
  }
  
  $admin = Admin::find_by_id($_SESSION['admin_id']);
  $restaurants = Restaurant::restaurants_marked();
?>

<?php include("../layouts/header/admin_header_menu.php"); ?>

	<div class="row">    
 		<div class="col s12 m10 offset-m1">
    	<h1 class="teal-text darken-2 center-align font-h1">Marked</h1>
      <p><?php echo display_message_errors($message_admin); ?></p>
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
            <td><a href="#" style="color: red;"><i class="material-icons">edit</i></a></td>
            <td><a href="remove_restaurant.php?restaurant_id=<?php echo htmlspecialchars($restaurant->restaurant_id); ?>" style="color: red;"><i class="material-icons">remove</i></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table>
     </div>
   </div>

  
   <div class="row">
    <div class="col s12 m10 offset-m1">
      <h2 class="teal-text darken-2 center-align font-h1">To Mark </h2>
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
              <th>Remove</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          $restaurants_to_mark = Restaurant::restaurants_to_mark();
        ?>
        <?php foreach( $restaurants_to_mark as $mark ) { ?>
          <tr>
            <td><?php echo htmlentities($mark->restaurant_id); ?></td>
            <td><?php echo htmlentities($mark->username); ?></td>
            <td><?php echo htmlentities($mark->created); ?></td>
            <td><?php echo htmlentities($mark->name); ?></td>
            <td><?php echo htmlentities($mark->email); ?></td>
            <td><?php echo htmlentities($mark->city); ?></td>
            <td><?php echo htmlentities($mark->street); ?></td>
            <td><?php echo htmlentities($mark->number); ?></td>
            <td><?php echo htmlentities($mark->zip_code); ?></td>
            <td><?php echo htmlentities($mark->phone_number); ?></td>
            <td><a href="mark_restaurant.php?restaurant_id=<?php echo htmlspecialchars($mark->restaurant_id); ?>" style="color: green;"><i class="material-icons">assignment_turned_in</i></a></td>
            <td><a href="remove_restaurant.php?restaurant_id=<?php echo htmlspecialchars($mark->restaurant_id); ?>" style="color: red;"><i class="material-icons">remove</i></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table> 
     </div>
   </div>
   
 <?php include("../layouts/footer/admin_footer.php"); ?>