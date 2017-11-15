<?php require_once("initialize.php"); ?>


<?php 

	class MySQLDatabase {
		private $connection;

		function __construct(){
			$this->open_connection();
		}

		private function open_connection(){
			$this->connection =  mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
			if ( mysqli_connect_errno() ){
				die( "DATABASE CONNECTION ERROR: " .
					mysqli_connect_error() . 
					" ( " . mysqli_connect_errno() . " ) "
					);
			}
		}

		public function close_connection(){
			if( isset($this->connection) ){
				mysqli_close($this->connection);
				unset($this->connection);
			}
		}

		private function confirm_query($result){
			if( !$result ){
				die( "Database query error.");
			}
		}



		// Database functions that are going to be used in other files

		public function escape_value($string){
			$escaped_string = mysqli_real_escape_string($this->connection, $string);
			return $escaped_string;
		}

		public function query($sql){
			$result = mysqli_query($this->connection, $sql);
			$this->confirm_query($result);
			return $result;
		}

		public function fetch_array($result_set){
			return mysqli_fetch_array($result_set);
		}

		public function insert_id(){
			return mysqli_insert_id($this->connection);
		}

		public function num_rows($result_set){
			return mysqli_num_rows($result_set);
		}

		public function affected_rows(){
			return mysqli_affected_rows($this->connection);
		}
	}

	$database = new MySQLDatabase();

?>