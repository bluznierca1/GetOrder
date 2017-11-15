<?php 
	$errors = [];

	function has_presence($value){
		return $value != "" && isset($value);
	}

	function fields_are_filled($required_fields){
		global $errors;

		foreach( $required_fields as $field ){
			$value = $_POST[$field];
			if( !has_presence($value) ){
				$errors[$field] = ucfirst($field) . " can not be empty.";
			}
		}
		return $errors;
	}

	function has_min_length($value, $min){
		return strlen($value) > $min;
	}

	function validate_min_length($fields_min_length){
		global $errors;

		foreach( $fields_min_length as $field => $min ){
			$value = trim($_POST[$field]);
			if( !has_min_length($value, $min) ){
				$errors[$field] = ucfirst($field) . " is too short. Should be at least {$min} letters long.";
			}
		}
		return $errors;
	}

	function passwords_match($password, $confirm_password){
		global $errors;

		if( $password != $confirm_password ){
			$errors[] = "Passwords do not match.";
		}
		return $errors;
	}

?>