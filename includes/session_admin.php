<?php require_once("initialize.php"); ?>

<?php 

 class SessionAdmin {
 		private $logged_in = false;
		public $admin_id;
		public $message_admin;

		function __construct(){
				session_start();
				$this->check_message();
				$this->check_login();
		}

		public function is_logged_in(){
			return $this->logged_in;
		}

		public function login($admin){
			if( $admin ){
				$this->logged_in = true;
				$this->admin_id = $admin->admin_id;
				$_SESSION['admin_id'] = $admin->admin_id;
			}
		}

		public function logout($admin){
			unset($this->admin_id);
			unset($_SESSION['admin_id']);
			$this->logged_in = false;
		}

		private function check_login(){
			global $admin;
			if( isset($_SESSION['admin_id']) ){
				$this->admin_id = $_SESSION['admin_id'];
				$this->logged_in = true;
			}else {
				unset($this->admin_id);
				$this->logged_in = false;
			}
		}

		public function message($msg = "" ){
			if( !empty($msg)){
				$_SESSION['message_admin'] = $msg;
			} else {
				return $this->message_admin;
			}
		}

		private function check_message(){
			if( isset($_SESSION['message_admin']) ){
				// Adding as an attribute
				$this->message_admin = $_SESSION['message_admin'];
				// unsetting $_SESSION element to have it disappeared after refreshing
				unset($_SESSION['message_admin']);
			} else {
				$this->message_admin = "";
			}
		}
 }

 $session_admin = new SessionAdmin();
 $message_admin = $session_admin->message();

?>