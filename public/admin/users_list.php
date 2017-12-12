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
  $users = User::find_all();
?>

<?php include("../layouts/header/admin_header_menu.php"); ?>
	
	<div class="row">
		<div class="s12 center-align">
			
		</div>
	</div>

	<div class="row">
 		<div class="col s12 m10 offset-m1">
    	<h1 class="users-list-title teal-text lighten-2 font-h1 center-align"> List of Users </h1>
      <p><?php echo isset($message_admin) ? display_message_errors($message_admin) : ""; ?></p>
      <table class="responsive-table bordered">
        <thead>
          <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Created</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Type</th>
              <th>Edit</th>
              <th>Remove</th>
          </tr>
        </thead>
        <tbody>
 <?php foreach( $users as $user ) { ?>
          <tr>
          	<td><?php echo htmlentities($user->user_id); ?></td>
            <td><?php echo htmlentities($user->username); ?></td>
            <td><?php echo htmlentities($user->created); ?></td>
            <td><?php echo htmlentities($user->first_name); ?></td>
            <td><?php echo htmlentities($user->last_name); ?></td>
            <td><?php echo htmlentities($user->email); ?></td>
            <td><?php echo htmlentities($user->type); ?></td>
            <td><a href="#" style="color: red;"><i class="material-icons">edit</i></a></td>
            <td><a href="remove_user.php?user_id=<?php echo htmlspecialchars($user->user_id); ?>" style="color: red;"><i class="material-icons">remove</i></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table> 	
     </div>
   </div>

 <?php include("../layouts/footer/admin_footer.php"); ?>