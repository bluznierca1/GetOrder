<?php require_once("initialize.php"); ?>

<?php 

	class Admin {
		
		protected static $db_fields = ['username', 'password', 'first_name', 'last_name', 'email', 'type'];
		protected static $table_name = "admins";
		public $admin_id;
		public $username;
		public $password;
		public $first_name;
		public $last_name;
		public $email;
		public $type;

		public static function authenticate($username="", $password=""){
				global $database;

				$username = $database->escape_value($username);
				$password = $database->escape_value($password);

				$query = "SELECT * FROM " . self::$table_name . " ";
				$query .= "WHERE username = '{$username}' ";
				$query .= "AND password = '{$password}' ";
				$query .= "LIMIT 1";
				$result_array = self::find_by_sql($query);

				return !empty($result_array) ? array_shift($result_array) : false;
			}


		public static function find_all(){
			return self::find_by_sql("SELECT * FROM " . self::$table_name);
		}

		public static function find_by_id($admin_id = null){
			global $database;
			$array_result = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE admin_id = {$admin_id} LIMIT 1");
			return !empty($array_result) ? array_shift($array_result) : false ;
		}

		public function find_admin_by_username($username = ""){
			global $database;

			$sql = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE username='{$username}' ";
			$sql .= "LIMIT 1";
			$result = $database->query($sql);
			$admin = $database->fetch_array($result);

			if( $admin ){
				return $admin;
			} else {
				return false;
			}

		}

		public static function find_by_sql($sql = ""){
			global $database;
			$object_array = [];

			$result = $database->query($sql);
			while( $row = $database->fetch_array($result) ){
				$object_array[] = self::instantiate($row);
			}

			return $object_array;
		}

		private static function instantiate($record){
			$object = new self;

			foreach( $record as $attribute=>$value) {
				if( $object->has_attribute($attribute) ){
					$object->$attribute = $value;
				}
			}

			return $object;
		}

		private function has_attribute($attr){
			$object_vars = get_object_vars($this);

			return array_key_exists($attr, $object_vars);
		}

		protected function attributes(){
			$attributes = [];
			foreach( self:: $db_fields as $field ){
				if(property_exists($this, $field)){
					$attributes[$field] = $this->$field;
				}
			}
			return $attributes;
		}

		private function sanitized_attributes(){
			global $database;
			$cleaned_attr = [];

			foreach( $this->attributes() as $key => $value ){
				$cleaned_attr[$key] = $database->escape_value($value);
			}
			return $cleaned_attr;
		}

		public function username_exists($username = ""){
			global $database;

			$sql = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE username = '{$username}' ";

			$result = $database->query($sql);
			$object = $database->fetch_array($result);
			if( !empty($object) ){
				return true;
			} else {
				return false;
			}

		}

		public function email_exists($email = ""){
			global $database;

			$sql = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE email = '{$email}' ";

			$result = $database->query($sql);
			$object = $database->fetch_array($result);

			if( !empty($object) ){
				return true;
			} else {
				return false;
			}
		}

		public function save(){
			return (isset($this->id)) ? $this->update() : $this->create(); 
		}

		public function create(){
			global $database;
			$attributes = $this->sanitized_attributes();

			$sql = "INSERT INTO " . self::$table_name . " (";
			$sql .= join(", ", array_keys($attributes) );
			$sql .= ") VALUES ('";
			$sql .= join("', '", array_values($attributes));
			$sql .= "') ";

			if( $database->query($sql) ) {
				$this->id = $database->insert_id();
				return true;
			} else {
				return false;
			}
			// return $sql;
		}
	}

	$admin = new Admin();

?>