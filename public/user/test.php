<?php 
require_once("../../includes/initialize.php");

		// $user = new User();
		
		// $user->username = "grzechu";	
		// $user->password = "konkordad1122";
		// $created_time = strftime("%Y-%m-%d %H:%M:%S", time());
		// $user->created = date("Y-m-d H:i:s", strtotime($created_time));
		// $user->first_name = "Grzegorz";
		// $user->last_name = "Lasak";
		// $user->email = "grzesiuck95@op.pl";
		// $user->save();

	// $user = User::find_by_sql("SELECT * FROM users WHERE user_id = 1");
	// $user = array_shift($user);
	// print_r($user);
	// echo $user->username;
	
	// $user = User::find_by_id(1);
	// print_r($user);

	echo $_SESSION['user_id'] ? $_SESSION['user_id'] : 'no id.';
	echo "<hr />";
	$user = User::find_by_id($_SESSION['user_id']);
	print_r($user);
	echo "<hr />";
	echo $user->username;