<?php require_once("../includes/initialize.php"); ?>

<?php 
	
	if( !isset( $_GET['city']) ){
		redirect_to("restaurants.php");
	}
	$city = $_GET['city'];

	//Current page number
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	// Total amount of restaurant
	$total_count = Restaurant::count_all();
	// Amount of restaurants per page
	$per_page = 50;

	$pagination = new Pagination($page, $per_page, $total_count);

	//just find records for this page

	$sql = "SELECT * FROM restaurants WHERE city = '{$city}' AND existing = 'yes' ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()} ";

	$restaurants = Restaurant::find_by_sql($sql); 

?>

<?php include("layouts/header/header_menu.php"); ?>


	<div class="row">
		<div class="col m2 restaurants-filter offset-m1 hide-on-small-only">
			<div class="cities filter-name">
			<h1 class="filter-title">Cities</h1>
				<ul>
				<?php 
					$cities = Restaurant::get_cities();
					foreach( $cities as $city ){
				?>
						<li><a href="sorted_restaurants.php?city=<?php echo $city['city']; ?>"><?php echo htmlspecialchars(ucfirst($city['city'])); ?></a></li>
				<?php
					}
				?>
				</ul>
			</div>
	</div>
	
	<?php 
		foreach($restaurants as $rest ){
			$restaurant = Restaurant::find_by_id($rest->restaurant_id); 
			$logo = Logo::find_by_restaurant_id($rest->restaurant_id); 
		?>
		<div class="row">
		  <div class="col s12 m8 offset-m3 restaurant-card">
			<div class="card horizontal">
			  <div class="card-image responsive-img" style="height: auto;">
				<img src="logo/<?php echo $logo->filename; ?>" class="card-image" alt="logo">
			  </div>
			  <div class="card-stacked">
				<div class="card-content">
					<p class="center-align teal-text darken-2 card-title"><a href="chosen_restaurant.php?restaurant_id=<?php echo $restaurant->restaurant_id; ?>"><?php echo $restaurant->name; ?></a></p>
				  <p class="card-caption"><?php echo $restaurant->caption != "" ? $restaurant->caption : "No description so far."; ?></p>
				</div>
				<p class="left-align card-address teal-text darken-2"><?php echo "{$restaurant->city}, {$restaurant->street} {$restaurant->number}"; ?></p>
			  </div>
			</div>
		  </div>
		 </div>
	<?php } ?>

<div class="row">
		<div class="col s12 center-align" id="pagination" class="pagination">
			<?php 



			if( $pagination->total_pages() > 1){

				if( $pagination->has_previous_page() ){
					echo " <a href=\"restaurants.php?page=";
					echo $pagination->previous_page();
					echo "\">&laquo; Previous &nbsp;&nbsp;  </a>";
				}

				for( $i=1; $i <= $pagination->total_pages(); $i++ ){
					if( $i == $page ){
						echo "<span class=\"selected\">{$i}</span>";
					} else {
						echo " <a href=\"restaurants.php?page={$i}\"> {$i} </a> ";
					}
				}

				if( $pagination->has_next_page() ){
					echo " <a href=\"restaurants.php?page=";
					echo $pagination->next_page();
					echo "\">Next &raquo; </a>";
				}
			}

			?>
		</div>
	</div> 
	
  <?php include("layouts/footer/footer.php"); ?> 