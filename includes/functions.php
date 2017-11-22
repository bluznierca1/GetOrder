<?php 
	function redirect_to($location){
		header("Location: " . $location);
	}

	function password_encrypt($password){
		$hash_format = "$2y$10$"; // BlowFish format

		$salt_length = 22;

		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);

		return $hash;
	}

	function generate_salt($length){
		// random key
		// md5 return 32 characters
		$unique_random_string = md5(uniqid(mt_rand(), true));

		// making validate format for salt
		$base64_string = base64_encode($unique_random_string);

		// removing "+" from $base64_string
		$modified_base64_string = str_replace("+", '.', $base64_string);

		// Truncate string to correct length
		$salt = substr($modified_base64_string, 0, $length);

		return $salt;
	}

	function password_check($password, $existing_hash){
		$hash = crypt($password, $existing_hash);
		if( $hash === $existing_hash){
			return true;
		} else {
			return false;
		}
	}

	function display_errors($errors){
		$output = "";
		if( !empty($errors) ){
			$output .= "<div class=\"row\"> ";
			$output .= "<div class=\errors-container\" >";
			$output .= "<div class=\"col s12 errors-container\">";
			$output .= "<h2 class=\"errors-title center-align\" style=\"color: #e61b1b;font-size: 2em;\">Please fix the following errors: </h2>";
			$output .= "<ul class=\"errors center-align\">";
			foreach( $errors as $key => $error ){
				$output .= "<li class=\"error\" style=\"color: #f12020;\"> - {$error} </li>";
			}
			$output .= "</ul>";
			$output .= "</div>";
			$output .= "</div>";
		}
		return $output;
	}

	function display_message_errors($message){
		$output = "";
		if( isset($message) && $message != "" ){
			$output .= "<div class=\"row\">";
			$output .= "<div class=\"col s12 center-align\">";
			$output .= "<p class=\"message\" style=\"color: #e61b1b\">{$message}</p>";
			$output .= "</div>";
			$output .= "</div>";
		}
		return $output;
	}

	function display_message_success($message){
		$output = "";
		if( isset($message) && $message != "" ){
			$output .= "<div class=\"row\">";
			$output .= "<div class=\"col s12 center-align\">";
			$output .= "<p class=\"message\" style=\"color: #088e00; font-weight: bold;\">{$message}</p>";
			$output .= "</div>";
			$output .= "</div>";
		}
		return $output;
	}

	

?>