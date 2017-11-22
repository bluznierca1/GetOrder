<?php require_once("initialize.php"); ?>

<?php 

 class SessionRestaurant {
 		private $logged_in = false;
		public $restaurant_id;
		public $message_restaurant;

		function __construct(){
				// session_start();
				$this->check_message();
				$this->check_login();
		}

		public function is_logged_in(){
			return $this->logged_in;
		}

		public function login($restaurant){
			if( $restaurant ){
				$this->logged_in = true;
				$this->restaurant_id = $restaurant->restaurant_id;
				$_SESSION['restaurant_id'] = $restaurant->restaurant_id;
			}
		}

		public function logout($restaurant){
			unset($this->restaurant_id);
			unset($_SESSION['restaurant_id']);
			$this->logged_in = false;
		}

		private function check_login(){
			global $restaurant;
			if( isset($_SESSION['restaurant_id']) ){
				$this->restaurant_id = $_SESSION['restaurant_id'];
				$this->logged_in = true;
			}else {
				unset($this->restaurant_id);
				$this->logged_in = false;
			}
		}

		public function message($msg = "" ){
			if( !empty($msg)){
				$_SESSION['message_restaurant'] = $msg;
			} else {
				return $this->message_restaurant;
			}
		}

		private function check_message(){
			if( isset($_SESSION['message_restaurant']) ){
				// Adding as an attribute
				$this->message_restaurant = $_SESSION['message_restaurant'];
				// unsetting $_SESSION element to have it disappeared after refreshing
				unset($_SESSION['message_restaurant']);
			} else {
				$this->message_restaurant = "";
			}
		}
 }

 $session_restaurant = new SessionRestaurant();
 $message_restaurant = $session_restaurant->message();

?>