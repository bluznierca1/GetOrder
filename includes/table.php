<?php require_once("initialize.php"); ?>

<?php 
	
	class Table {
		protected static $db_fields = ['one_seat', 'two_seats', 'three_seats', 'four_seats', 'five_seats', 'six_seats', 'restaurant_id'];
		protected static $table_name = "tables";
		public $one_seat;
		public $two_seats;
		public $three_seats;
		public $four_seats;
		public $five_seats;
		public $six_seats;
		public $restaurant_id;

		public static function find_all(){
			return self::find_by_sql("SELECT * FROM " . self::$table_name);
		}

		public static function find_by_id($admin_id = null){
			global $database;
			$array_result = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE admin_id = {$admin_id} LIMIT 1");
			return !empty($array_result) ? array_shift($array_result) : false ;
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

		public static function find_by_restaurant_id($restaurant_id){
			$array_result = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE restaurant_id = '{$restaurant_id}' LIMIT 1");
			return !empty($array_result) ? array_shift($array_result) : false;
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
			foreach( self::$db_fields as $field ){
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

		public static function insert_tables($one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant_id){
			global $database;

			$sql = "INSERT INTO tables ( ";
			$sql .= "one_seat, two_seats, three_seats, four_seats, five_seats, six_seats, restaurant_id ";
			$sql .= ") VALUES( ";
			$sql .= "'{$one_seat}', '{$two_seats}', '{$three_seats}', '{$four_seats}', '{$five_seats}', '{$six_seats}', '{$restaurant_id}' ";
			$sql .= " ) ";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
		}

		public static function edit_tables( $one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant_id ){
			global $database;

			$sql = "UPDATE tables SET ";
			$sql .= "one_seat = '{$one_seat}', ";
			$sql .= "two_seats = '{$two_seats}', ";
			$sql .= "three_seats = '{$three_seats}', ";
			$sql .= "four_seats = '{$four_seats}', ";
			$sql .= "five_seats = '{$five_seats}', ";
			$sql .= "six_seats = '{$six_seats}' ";
			$sql .= " WHERE restaurant_id = '{$restaurant_id}' ";
			$sql .= "LIMIT 1";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}

			// return $sql;

		}

		public function add_available_tables(){
			global $database;
			$attributes = $this->sanitized_attributes();

			$sql = "INSERT INTO available_tables (";
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

		public function edit_available_tables( $one_seat, $two_seats, $three_seats, $four_seats, $five_seats, $six_seats, $restaurant_id ){
			global $database;

			$sql = "UPDATE available_tables SET ";
			$sql .= "one_seat = '{$one_seat}', ";
			$sql .= "two_seats = '{$two_seats}', ";
			$sql .= "three_seats = '{$three_seats}', ";
			$sql .= "four_seats = '{$four_seats}', ";
			$sql .= "five_seats = '{$five_seats}', ";
			$sql .= "six_seats = '{$six_seats}' ";
			$sql .= " WHERE restaurant_id = '{$restaurant_id}' ";
			$sql .= "LIMIT 1";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
			// return $sql;
		}

		public static function find_available_by_restaurant_id($id) {
			global $database;
			$object = [];

			$sql = "SELECT * FROM available_tables ";
			$sql .= "WHERE restaurant_id = {$id} ";
			$result = self::find_by_sql($sql);

			return empty($result) ? false : array_shift($result);
		}

		private static function update_minus_one_available($holder, $substracted, $restaurant_id){
			global $database;

			$sql = "UPDATE available_tables ";
			$sql .= "SET {$holder} = {$substracted} ";
			$sql .= "WHERE restaurant_id = {$restaurant_id} ";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
		}

		public function minus_one_available($seat, $restaurant_id){
			global $database;
			$holder = "";
			switch( $seat ){
				case 1:
					$holder = "one_seat";
					break;
				case 2:
					$holder = "two_seats";
					break;
				case 3:
					$holder = "three_seats";
					break;
				case 4:
					$holder = "four_seats";
					break;
				case 5:
					$holder = "five_seats";
					break;
				case 6:
					$holder = "six_seats";
					break;
			}

			$sql = "SELECT * FROM available_tables ";
			$sql .= "WHERE restaurant_id = {$restaurant_id} ";
			$sql .= "LIMIT 1";
			$result = $database->query($sql);
			$result_array = $database->fetch_array($result);
			$found_seat = $result_array[$holder];
			$substracted = $found_seat - 1;
			if( $this->update_minus_one_available($holder, $substracted, $restaurant_id) ){
				return true;
			} else {
				return false;
			}
		}

		public function update_add_one_available($holder, $added, $restaurant_id) {
			global $database;

			$sql = "UPDATE available_tables ";
			$sql .= "SET {$holder} = {$added} ";
			$sql .= "WHERE restaurant_id = {$restaurant_id} ";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}	
		}

		public function add_one_available($seat, $restaurant_id, $reservation_id){
			global $database;
			$holder = "";
			switch( $seat ){
				case 1:
					$holder = "one_seat";
					break;
				case 2:
					$holder = "two_seats";
					break;
				case 3:
					$holder = "three_seats";
					break;
				case 4:
					$holder = "four_seats";
					break;
				case 5:
					$holder = "five_seats";
					break;
				case 6:
					$holder = "six_seats";
					break;
			}

			$sql = "SELECT * FROM available_tables ";
			$sql .= "WHERE restaurant_id = {$restaurant_id} ";
			$sql .= "LIMIT 1";
			$result = $database->query($sql);
			$result_array = $database->fetch_array($result);
			$found_seat = $result_array[$holder];
			$added = $found_seat + 1;
			if( $this->update_add_one_available($holder, $added, $restaurant_id) ){
				return true;
			} else {
				return false;
			}
		}

	}

	$table = new Table();

?>