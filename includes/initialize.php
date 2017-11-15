<!-- This file is for gathering all classes and files that are being included in other files.
just for spacing space and making it easier -->

<?php require_once("config.php"); ?>
<?php require_once("functions.php"); ?>
<?php require_once("session.php"); ?>
	<!-- First is database - without that app will not work. -->
<?php require_once("database.php"); ?>

	<!-- Session has to be loaded before classes except database class -->


	<!-- Functionality is to keep functions loaded before any classes tasks -->
<?php require_once("validation_functions.php"); ?>


<?php require_once("user.php"); ?>
