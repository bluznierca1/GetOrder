<?php require_once("initialize.php"); ?>

<?php 

	class Logo {
		protected static $table_name = "logos";
		protected static $db_fields = ['filename', 'type','size', 'restaurant_id'];
		public $id;
		public $filename;
		public $type;
		public $size;
		public $restaurant_id;

		private $temp_path;
		protected $upload_dir = "logo";
		public $errors = [];

		protected $upload_errors = [
			UPLOAD_ERR_OK => "No errors.",
			UPLOAD_ERR_INI_SIZE => "Larger than upload max filesize.",
			UPLOAD_ERR_FORM_SIZE => "Larger then MAX_FILE_SIZE",
			UPLOAD_ERR_PARTIAL => "Partial upload",
			UPLOAD_ERR_NO_FILE => "No file.",
			UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
			UPLOAD_ERR_CANT_WRITE => "Can't write to disk",
			UPLOAD_ERR_EXTENSION => "File upload failed by extension."
		];

		public function attach_file($file){
			if( !$file || empty($file) || !is_array($file) ){
				$this->errors[] = "No file uploaded.";
				return false;
			} else if ($file['error'] != 0 ){
				$this->erorrs[] = $this->upload_errors[$file['error']];
				return false;
			} else {
				$this->temp_path = $file['tmp_name'];
				$this->filename = basename($file['name']);
				$this->type = $file['type'];
				$this->size = $file['size'];

				return true;
			}
		}

		public function image_path(){
			return $this->upload_dir . "/" . $this->filename;
		}

		public function size_as_text(){
			if( $this->size < 1024 ){
				return "{$this->size} bytes";
			} else if ( $this->size < 1048576 ){
				$size_kb = round( $this->size / 1024 );
				return "{$size_kb} KB";
			} else {
				$size_mb = round( $this->size / 1048576, 1);
				return "{$size_mb} MB";
			}
		}

		public function save() {
			if( isset($this->id) ){
				$this->update();
			} else {
				// check if there are errors

				// can not save with errors
				if( !empty($this->errors) ) { return false; }

				// can not save without filename and temp location
				if( empty($this->filename) || empty($this->temp_path) ){
					$this->errors[] = "The file location was not available.";
					return false;
				} 

				// Determine the target path
				$this->target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;

				// check if there is not file with the same name
				if( file_exists($this->target_path) ){
					$this->errors[] = "The file {$this->filename} already exists.";
					return false;
				}

				// Attempt to move the file
				if( move_uploaded_file($this->temp_path, $this->target_path) ) {
					// success 
					//saving
					if( $this->create() ){
						unset($temp_path);
						return true;
					}
				} else {
					// Failure
					$this->errors[] = "The file upload failed probably due to incorrect prmissions on upload folder.";
					return false;
				}
			}
		}

		public function destroy(){
			if( $this->delete() ){
				$target_path = SITE_ROOT .DS. 'public' .DS. $this->image_path();
				return unlink($target_path) ? true : false;
			} else {
				//failure
				return false;
			}
		}

		public static function find_all(){
				return self::find_by_sql("SELECT * FROM " . self::$table_name );
			}

			public static function find_by_id($id = 0){
				global $database;

				$result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id = {$database->escape_value($id)} ");
				return !empty($result_array) ? array_shift($result_array) : false;
			}

			public static function find_by_restaurant_id($id = 0 ){
				$result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE restaurant_id = {$id} ");
				return !empty($result_array) ? array_shift($result_array) : false;
			}

			public static function find_by_sql($sql=""){
				global $database;

				$result_set = $database->query($sql);
				
				$object_array = [];
				
				while( $row = $database->fetch_array($result_set) ){
					$object_array[] = self::instantiate($row);
				}

				return $object_array;
			}

			public static function count_all(){
				global $database;

				$sql = "SELECT COUNT(*) FROM " . self::$table_name;
				$result_set = $database->query($sql);
				$row = $database->fetch_array($result_set);
				return array_shift($row);
			}

			private static function instantiate($record){
				$object = new self;
				// $object->id 				= $record['id'];
				// $object->username 	= $record['username'];
				// $object->password 	= $record['password'];
				// $object->first_name = $record['first_name'];
				// $object->last_name 	= $record['last_name'];

				//More dynamic, short-form approach
				foreach( $record as $attribute=>$value ){
					if( $object-> has_attribute($attribute)){
						$object->$attribute = $value;
					}
				}
				return $object;
			}

			private function has_attribute($attribute){
				//get_object_vars returns an assiciative array with all attributes
				//including PRIVATE ONES, as the keys and their current values as value
				$object_vars = get_object_vars($this);
				//We don't care about the value, we just want to know if the key exists,
				//will return true or false
				return array_key_exists($attribute, $object_vars);
			}			

			protected function attributes(){
							$attributes = [];
							foreach(self::$db_fields as $field){
								if(property_exists($this, $field)){
									$attributes[$field] = $this->$field;
								} 
							}
							return $attributes;
			}

			protected function sanitized_attributes(){
							global $database;
							$clean_attributes = [];

							foreach($this->attributes() as $key => $value ){
								$clean_attributes[$key] = $database->escape_value($value);
							}
							return $clean_attributes;
			}

			// replaced with save method  for files
			// public function save(){
				
			// 	return (isset($this->id)) ? $this->update() : $this->create(); 
			// }

			protected function create(){
							global $database;
							$attributes = $this->sanitized_attributes();

							$sql = "INSERT INTO " . self::$table_name . "(";
							$sql .= join(", ", array_keys($attributes) );
							$sql .= ") VALUES ('";
							$sql .= join("', '", array_values($attributes));
							$sql .= "')";
							
							if( $database->query($sql) ){
								$this->id = $database->insert_id();
								return true;
							} else {
								return false;
							}
			}

			protected function update(){
							global $database;

							$attributes = $this->sanitized_attributes();
							$attribute_pairs = [];
							foreach($attributes as $key=>$value){
								$attribute_pairs[] = "{$key} = '{$value}'";
							}

							$query = "UPDATE " . self::$table_name . " SET ";
							$query .= join(", ", $attribute_pairs);
							$query .= " WHERE id = " . $database->escape_value($this->id);
							$database->query($query);

							return ($database->affected_rows() == 1) ? true : false;
			}

			public function delete(){
							global $database;

							$sql = "DELETE FROM " . self::$table_name . " ";
							$sql .= "WHERE id = " . $database->escape_value($this->id);
							$sql .= " LIMIT 1";
							$database->query($sql);

							return ($database->affected_rows() == 1 ) ? true : false;
			}
	}

	$logo = new Logo();

?>