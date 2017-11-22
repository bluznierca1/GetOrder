<?php require_once("../../includes/initialize.php"); ?>

<?php 

	function parseToXML($htmlStr){
		$xmlStr = str_replace('<', '&lt', $htmlStr);
		$xmlStr=str_replace('>','&gt;',$xmlStr);
		$xmlStr=str_replace('"','&quot;',$xmlStr);
		$xmlStr=str_replace("'",'&#39;',$xmlStr);
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		return $xmlStr;
	}

	$query = " SELECT * FROM markers WHERE 1";
	$result = $database->query($query);

	header("Content-type: text/xml");

	echo "<markers>";

	while($row = mysqli_fetch_assoc($result) ){
		echo '<marker ';
	  echo 'id="' . $row['id'] . '" ';
	  echo 'name="' . parseToXML($row['name']) . '" ';
	  echo 'address="' . parseToXML($row['address']) . '" ';
	  echo 'lat="' . $row['lat'] . '" ';
	  echo 'lng="' . $row['lng'] . '" ';
	  echo 'type="' . $row['type'] . '" ';
	  echo '/>';
	}

	echo "</markers>";
?>