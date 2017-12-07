<?php require_once("initialize.php"); ?>

<?php 
	
	class SessionUser {
		private $logged_in = false;
		public $user_id;
		public $message_user;

		function __construct(){
			// session_start();
			$this->check_message();
			$this->check_login();
		}

		public function is_logged_in(){
			return $this->logged_in;
		}

		public function login($user){
			if( $user ){
				$this->logged_in = true;
				$this->user_id = $user->user_id;
				$_SESSION['user_id'] = $user->user_id;
			}
		}

		public function logout($user){
			unset($this->user_id);
			unset($_SESSION['user_id']);
			$this->logged_in = false;
		}

		private function check_login(){
			global $user;
			if( isset($_SESSION['user_id']) ){
				$this->user_id = $_SESSION['user_id'];
				$this->logged_in = true;
			}else {
				unset($this->user_id);
				$this->logged_in = false;
			}
		}

		public function message($msg = "" ){
			if( !empty($msg)){
				$_SESSION['message_user'] = $msg;
			} else {
				return $this->message_user;
			}
		}

		private function check_message(){
			if( isset($_SESSION['message_user']) ){
				// Adding as an attribute
				$this->message_user = $_SESSION['message_user'];
				// unsetting $_SESSION element to have it disappeared after refreshing
				unset($_SESSION['message_user']);
			} else {
				$this->message_user = "";
			}
		}
	}

		$session_user = new SessionUser();
		$message_user = $session_user->message();
	
?>