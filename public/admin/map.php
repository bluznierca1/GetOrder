<?php require_once("../../includes/initialize.php"); ?>
<?php 
  if( !$session_admin->is_logged_in() ) {
    redirect_to("login.php");
  } 
  ?>

  <?php include("../layouts/header/admin_header_menu.php"); ?>
    
    <div class="row">
      <div class="col s12 center-align">
        <h3 class="teal-text text-darken-2">Choose Restaurant</h3>
      </div>
      <div class="col s12">
        <div id="map"></div>
      </div>
    </div>
   <script>
      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(50.882295, 20.632107),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('./markers.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));
              var restaurant_id = markerElem.getAttribute('restaurant_id');

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              //
              var a = document.createElement('a');
              var linkText = document.createTextNode(name);
              a.appendChild(linkText);
              a.title = "name";
              a.href = "../chosen_restaurant.php?restaurant_id=" + restaurant_id;
              a.className = "restaurant-link";
              
//
              strong.textContent = name;
              infowincontent.className = "restaurant-link-container";
              infowincontent.appendChild(a);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address;
              infowincontent.appendChild(text);
              console.log(id);
              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrkNhzYLD9ikPIE2N6Kzg0SGQmVfyyGDA&callback=initMap">
    </script>
    <!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrkNhzYLD9ikPIE2N6Kzg0SGQmVfyyGDA&libraries=places&callback=initMap">
    </script> -->
    <?php include("../layouts/footer/admin_footer.php"); ?>
  </body>
</html>
 