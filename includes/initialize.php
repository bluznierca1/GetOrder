<!-- This file is for gathering all classes and files that are being included in other files.
just for spacing space and making it easier -->

<?php 

	defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

	defined('SITE_ROOT') ? null : define("SITE_ROOT",
		'C:'.DS.'laragon'.DS.'www'.DS.'getTable' .DS. 'GetTable');

	defined('LIB_PATH') ? null : define("LIB_PATH", SITE_ROOT.DS.'includes');

?>

<?php require_once("config.php"); ?>
<?php require_once("functions.php"); ?>

<?php require_once("session_admin.php"); ?>
<?php require_once("session_user.php"); ?>
<?php require_once("session_restaurant.php"); ?>

	<!-- First is database - without that app will not work. -->
<?php require_once("database.php"); ?>

	<!-- Session has to be loaded before classes except database class -->


	<!-- Functionality is to keep functions loaded before any classes tasks -->
<?php require_once("validation_functions.php"); ?>

<?php require_once("logo.php"); ?>
<?php require_once("reservation.php"); ?>
<?php require_once("pagination.php"); ?>
<?php require_once("table.php"); ?>
<?php require_once("admin.php"); ?>
<?php require_once("user.php"); ?>
<?php require_once("restaurant.php"); ?>
