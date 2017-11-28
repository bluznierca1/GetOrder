<?php require_once("initialize.php"); ?>

<?php 

	class Restaurant {

		protected static $db_fields = ['username', 'password', 'name', 'city', 'street', 'number', 'zip_code', 'phone_number', 'created', 'email', 'marked'];
		protected static $table_name = "restaurants";
		public $restaurant_id;
		public $username;
		public $password;
		public $created;
		public $name;
		public $city;
		public $street;
		public $number;
		public $phone_number;
		public $zip_code;
		public $email;
		public $marked;

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

		public static function find_by_id($restaurant_id = null){
			global $database;
			$array_result = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE restaurant_id = {$restaurant_id} LIMIT 1");
			return !empty($array_result) ? array_shift($array_result) : false ;
		}

		public function find_restaurant_by_username($username = ""){
			global $database;

			$sql = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE username='{$username}' ";
			$sql .= "LIMIT 1";
			$result = $database->query($sql);
			$restaurant = $database->fetch_array($result);

			if( $restaurant ){
				return $restaurant;
			} else {
				return false;
			}

		}

		public static function restaurants_to_mark(){
			return $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE marked = 'no' ");
		}

		public static function restaurants_marked(){
			return $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE marked = 'yes' ");
		}

		public static function insert_into_markers($restaurant, $lat, $lng){
			global $database;

			// inserting into markers
			$sql = "INSERT INTO markers (";
			$sql .= "id, name, address, lat, lng, type, restaurant_id ";
			$sql .= ") VALUES (";
			$sql .= "null, '{$restaurant->name}', '{$restaurant->city}, {$restaurant->street} {$restaurant->number}', '{$lat}', '{$lng}', 'restaurant', '{$restaurant->restaurant_id}' ";
			$sql .= ") ";
			

			//updating restaurants field 'marked'
			$query = "UPDATE restaurants ";
			$query .= "SET marked = 'yes' ";
			$query .= "WHERE restaurant_id = {$restaurant->restaurant_id} ";
			

			if( $database->query($sql) && $database->query($query) ){
				return true;
			} else {
				return false;
			}
			// return $sql;
			
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

		public function delete($id = null){
			global $database;
			$sql = "DELETE FROM " . self::$table_name ;
			$sql .= " WHERE restaurant_id = {$id} LIMIT 1";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
		}

		public static function unmark_restaurant($restaurant_id = null){
			global $database;

			$sql = "DELETE FROM markers ";
			$sql .= "WHERE restaurant_id = {$restaurant_id} ";
			$sql .= "LIMIT 1";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
		}

		public static function edit($name="", $email="", $city="", $street="", $number=null, $phone_number=null, $restaurant_id=null){
			global $database;

			$sql = "UPDATE " . self::$table_name . " SET ";
			$sql .= "name = '{$name}', ";
			$sql .= "email = '{$email}', ";
			$sql .= "city = '{$city}', ";
			$sql .= "street = '{$street}', ";
			$sql .= "number = '{$number}', ";
			$sql .= "phone_number = '{$phone_number}' ";
			$sql .= "WHERE restaurant_id = {$restaurant_id} ";
			$sql .= " LIMIT 1";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
		}

		public static function edit_password($new_password, $restaurant_id){
			global $database;
			
			$sql = "UPDATE " . self::$table_name . " SET ";
			$sql .= "password = '{$new_password}' ";
			$sql .= "WHERE restaurant_id = {$restaurant_id} ";
			$sql .= "LIMIT 1";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
		}
	}

	$restaurant = new Restaurant();

?>