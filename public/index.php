<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>GetOrder App</title>

	 <!--Import Google Icon Font-->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <!--Import materialize.css-->
   <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
   <link type="text/css" rel="stylesheet" href="stylesheet/styles.css" media="all">

   <!--Let browser know website is optimized for mobile-->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>
<body>

	<!-- header section -->
	<header role="banner" id="header">
		<div class="row">

			<!-- paralax main photo -->
				<div class="parallax-container">

					<div class="row">
					<!-- dividing header into two sections: logo and menu -->
						<div class="col s2 center-align">
							<span><img src="images/logo/logo.png" class="logo"></span>
						</div>
						<div class="col offset-s7 s3 right-align">

							<!-- slide out menu -->

							<!-- hard data option -->
							<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons menu-icon" id="menu">menu</i></a>
							<ul id="slide-out" class="side-nav side-menu">
								<li>
									<div class="user-view">
										<div class="background">											
											<img src="images/menu/menu-back.jpg" class="responsive-img">
										</div>
										<div class="menu-info">
											<a href="#"><img src="images/foto.jpg" class="circle"></a>
											<a href="#"><span class="menu-user-info">Grzechu</span></a> 
											<a href="#"><span class="menu-user-info">email</span></a>
										</div>	
									</div>
								</li>
								<li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
    						<li><a href="#!">Second Link</a></li>
    						<li><div class="divider"></div></li>
    						<li><a class="subheader">Subheader</a></li>
    						<li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
							</ul>
						</div>
					</div>

					<div class="parallax">
						<img src="images/home/home_photo.jpg">
					</div>
				</div>
		</div>
	</header>

	<main role="main" id="main">
		<section id="section1">
		<div class="row">
			<div class="col s3 right-align">
				<i class="material-icons arrow-down">arrow_downward</i>
			</div>
				
				<div class="col s6 center-align">
					<h3 class="how-it-works">How does it work?</h3>
				</div>

			<div class="col s3 left-align">
				<i class="material-icons arrow-down">arrow_downward</i>
			</div>
		</div>
		</section>

		<section id="section2">
			<div class="row">
				<div class="col hide-on-small-only m3 center-align ">
					<img src="images/steps/first.png" class="responsive-img stopka">
					<div class="step-description">
						1. Choose a restaurant	
					</div>
				</div>
				<div class="col hide-on-small-only m3 center-align ">
					<img src="images/steps/second.png" class="responsive-img stopka">
					<div class="step-description">
						2. Book a table	
					</div>
				</div>
				<div class="col hide-on-small-only m3 center-align ">
					<img src="images/steps/third.png" class="responsive-img stopka">
					<div class="step-description">
						3. Pick up your menu and pay
					</div>
				</div>
				<div class="col hide-on-small-only m3 center-align ">
					<img src="images/steps/fourth.png" class="responsive-img stopka">
					<div class="step-description">
						4. Come and enjoy without waiting!	
					</div>
				</div>
			</div>
		</section>

	</main>

	<footer  style="height: 900px;">
	</footer>


 <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/js.js"></script>

</body>

</html>