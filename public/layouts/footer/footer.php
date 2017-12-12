<footer class="page-footer">
	<div class="container">
		<div class="row">
			<div class="col l4 s12">
				<h5>Description</h5>
				<p>Our mission is to give you an easyway to find restaurant and reserve table in the easiest way that is possible.</p>
			</div>
			<div class="col l4 s12">
				<h5 class="white-text">Social Media</h5>
					<ul>
            <li><a class="white-text " href="#!"> <i class="fa fa-facebook"></i>&nbsp;&nbsp; Facebook</a></li>
            <li><a class="white-text " href="#!"><i class="fa fa-instagram"></i> &nbsp; Instagram</a></li>
          </ul>
      </div>
      <div class="col l4 s12">
				<h5 class="white-text">Links</h5>
					<ul>
						<li><a class="white-text " href="index.php">Main Page</a></li>
						<li><a class="white-text " href="restaurant/register.php">Join us as restaurant</a></li>
						<li><a class="white-text " href="#!">FAQ</a></li>
						<li><a class="white-text " href="#!">Regulations</a></li>
						<li><a class="white-text " href="admin/login.php">Admin Panel</a></li>
					</ul>
			</div>
		</div>
  </div>
    <div class="footer-copyright">
      <div class="container center-align">
        <span class="white-text">© Copyrights <?php echo date("Y", time()); ?> Get Table
        </span></div>
      </div>
</footer>


 <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/js.js"></script>
<?php if( isset($database) ) { $database->close_connection(); } ?>
</body>

</html>