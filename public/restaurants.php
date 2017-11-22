<?php require_once("../includes/initialize.php"); ?>

<?php $restaurants = Restaurant::find_all(); ?>

<?php include("layouts/header/header_menu.php"); ?>
	
	<ul>
		<?php foreach( $restaurants as $restaurant ){ ?>
			<li><a href="chosen_restaurant.php?restaurant_id=<?php echo $restaurant->restaurant_id; ?>"><?php echo $restaurant->name; ?></a></li>
		<?php } ?> 
	</ul>
<?php include("layouts/footer/footer.php"); ?> 