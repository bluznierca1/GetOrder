<?php require_once("../../includes/initialize.php"); ?>

<?php 
	if( $session_admin->is_logged_in() ){
		$users = User::find_all();
	} else {
		redirect_to("login.php");
	}
?>

<?php include("../layouts/header/admin_header_menu.php"); ?>
	
	<div class="row">
		<div class="col s12 center-align">
			<h1 class="users-list-title teal-text lighten-2"> List of Users </h1>
			<p><?php echo isset($message_admin) ? display_message_errors($message_admin) : ""; ?></p>
		</div>
	</div>

	<div class="row">
 		<div class="s12 table-container">
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
          	<td><?php echo $user->user_id; ?></td>
            <td><?php echo $user->username; ?></td>
            <td><?php echo $user->created; ?></td>
            <td><?php echo $user->first_name; ?></td>
            <td><?php echo $user->last_name; ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->type; ?></td>
            <td><a href="#" style="color: red;"><i class="material-icons">edit</i></a></td>
            <td><a href="remove_user.php?user_id=<?php echo $user->user_id; ?>" style="color: red;"><i class="material-icons">remove</i></a></td>
          </tr>
  <?php } ?>
        </tbody>
      </table> 	
     </div>
   </div>

 <?php include("../layouts/footer/admin_footer.php"); ?>