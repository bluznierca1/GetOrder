<?php require_once("../includes/initialize.php"); ?>

<?php 
	//Current page number
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	// Total amount of restaurant
	$total_count = Restaurant::count_all();
	// Amount of restaurants per page
	$per_page = 10;

	$pagination = new Pagination($page, $per_page, $total_count);

	//just find records for this page

	$sql = "SELECT * FROM restaurants ";
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
					<li>Kielce</li>
				</ul>
			</div>
			<div class="type filter-name">
				<h2 class="filter-title"> Type</h2>
				<ul>
					<li>Chinese</li>
				</ul>
			</div>
	</div>
	
	<?php foreach($restaurants as $restaurant ){ ?>
	
		<div class="row">
		  <div class="col s12 m8 offset-m3 restaurant-card">
		    <div class="card horizontal">
		      <div class="card-image responsive-img" style="height: auto;">
		        <img src="images/stary_mlyn.jpg" class="card-image">
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