<?php require_once("initialize.php"); ?>

<?php 

	class Reservation {
		protected static $table_name = "reservation";
		protected static $db_fields = ['date_in', 'date_out', 'user_id', 'restaurant_id', 'booked_table', 'created'];

		public $reservation_id;
		public $date_in;
		public $date_out;
		public $restaurant_id;
		public $user_id;
		public $booked_table;
		public $created;

		public static function find_all(){
			return self::find_by_sql("SELECT * FROM " . self::$table_name);
		}

		public static function find_by_id($reservation_id = null){
			global $database;
			$array_result = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE reservation_id = {$reservation_id} LIMIT 1");
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

		public function create(){
			global $database;
			$attributes = $this->sanitized_attributes();

			$sql = "INSERT INTO " . self::$table_name . " (";
			$sql .= join(", ", array_keys($attributes) );
			$sql .= ") VALUES ('";
			$sql .= join("', '", array_values($attributes));
			$sql .= "') ";

			$query = "INSERT INTO display_reservations (";
			$query .= join(", ", array_keys($attributes) );
			$query .= ") VALUES ('";
			$query .= join("', '", array_values($attributes));
			$query .= "') ";

			if( $database->query($sql) && $database->query($query)) {
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
			$sql .= " WHERE reservation_id = {$id} LIMIT 1";

			if( $database->query($sql) ){
				return true;
			} else {
				return false;
			}
		}

		public static function reservation_is_done($reservation_id = null, $restaurant_id = null){
			global $database;
			global $table;

			// first we add one more table to the available ones
			$query = "SELECT * FROM " . self::$table_name . " ";
			$query .= "WHERE reservation_id = {$reservation_id} ";
			$query .= "LIMIT 1";
			$result = $database->query($query);
			$booked_table = $database->fetch_array($result);
			$seat = $booked_table['booked_table']; // the booked table is here

			if( $table->add_one_available($seat, $restaurant_id, $reservation_id) ){
				// then we can remove reservation
				$sql = "DELETE FROM " . self::$table_name . " ";
				$sql .= "WHERE reservation_id = {$reservation_id} LIMIT 1";
				if( $database->query($sql) ){
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}

		public function check_reservation_time($reserved_tables = [], $restaurant_id = null){
			$today = date("Y-m-d H:m:s", time() + 3600);
			foreach( $reserved_tables as $b ) {
				if( strtotime($today) > strtotime($b->date_out) ){
					$this->reservation_is_done($b->reservation_id, $restaurant_id);
					return true;
				}
			}
		}

		public function user_has_reservation($user_id, $restaurant_id){
			global $database;
			$sql = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE user_id = {$user_id} ";
			$sql .= "AND restaurant_id = {$restaurant_id} ";
			$result = $database->query($sql);
			$result_array = $database->fetch_array($result);
			if( !empty($result_array) ){
				return true;
			} else {
				return false;
			}
		}

	}

	$reservation = new Reservation();
	
?>