
<!-- saved from url=(0090)http://gmaps-samples.googlecode.com/svn/trunk/articles-phpsqlgeocode/phpsqlgeocode_xml.php -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"></head><body><pre style="word-wrap: break-word; white-space: pre-wrap;"><script type="text/javascript">window.onload = function(){window.location.reload();};</script>
<?php
$username="jmla_checkavet";
$password="56@D1iSf:{0'8+q";
$database="jmla_checkavet";

define("MAPS_HOST", "maps.google.com");
define("KEY", "AIzaSyBK2oBWwjz7a9TJQwjpZcFlSNxm_Cvq-P8");

// Opens a connection to a MySQL server
$connection = mysql_connect("localhost", $username, $password);
if (!$connection) {
  die("Not connected : " . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die("Can\'t use db : " . mysql_error());
}

// Select all the rows in the markers table
$query = "SELECT * FROM jmla_petservices WHERE 1";
$result = mysql_query($query);
if (!$result) {
  die("Invalid query: " . mysql_error());
}

// Initialize delay in geocode speed
$delay = 0;
//$base_url = "http://maps.googleapis.com/maps/api/geocode/xml?sensor=false";
$base_url = "http://maps.google.com/maps/geo?output=xml&sensor=false";

$success = 0;
$fail = 0;
$total = 0;

// Iterate through the rows, geocoding each address
while ($row = @mysql_fetch_assoc($result)) {
  $geocode_pending = true;
  
  if($row['lat'] != 0 && $row['lng'] != 0)
  	continue;
  
  $total++;
  if($total <= 2)
  {
	  //continue;
  }
  
  while ($geocode_pending) {
	$address = "";
    $address .= $row["address1"] == "" ? "" : $row['address1'].", ";
    $address .= $row["address2"] == "" ? "" : $row['address2'].", ";
    $address .= $row["address3"] == "" ? "" : $row['address3'].", ";
    $address .= $row["town"] == "" ? "" : $row['town'].", ";
    $address .= $row["county"] == "" ? "" : $row['county'].", ";
    $address .= $row["postcode"] == "" ? "" : $row['postcode'];
	//$address = substr($address, 0, -2);
	
    $id = $row["id"];
    //$request_url = $base_url . "&address=" . urlencode($address);
	$request_url = $base_url . "&q=" . urlencode($address);
	
    $xml = simplexml_load_file($request_url) or die("url not loading");	
    //$status = $xml->status;
	$status = $xml->Response->Status->code;
	
    if (strcmp($status, "OK") == 0 || strcmp($status, "200") == 0) {
      // Successful geocode
      $geocode_pending = false;

	 $coords = $xml->Response->Placemark->Point->coordinates; 
	 $coords = explode(",",$coords);
	 $lat = $coords[0];
	 $lng = $coords[1];

      $query = sprintf("UPDATE jmla_petservices " .
             " SET lat = '%s', lng = '%s' " .
             " WHERE id = '%s' LIMIT 1;",
             mysql_real_escape_string($lat),
             mysql_real_escape_string($lng),
             mysql_real_escape_string($id));
		echo $query.'<br />';
      $update_result = mysql_query($query);
      if (!$update_result) {
		 $fail++; 
        die("Invalid query: " . mysql_error());
      } else {
		  $success++;
	  }
	  
    } else if (strcmp($status, "OVER_QUERY_LIMIT") == 0 || strcmp($status, "620") == 0) {
      // sent geocodes too fast
	  echo "oql retrying {$row['id']}<br />";
     // $geocode_pending = false;
		// $fail++; 
      $delay += 10000;
    } else {
      // failure to geocode
	  $fail++; 
      $geocode_pending = false;
      echo "Address " . $address . " failed to geocoded. ";
      echo "Received status " . $status . "
\n";
    }
    usleep($delay);
  }
 
  if($total == 50)
  {
	  break;
  }
}
?>
<?php print("sucess: ".$success); ?>
<?php print("fail: ".$fail); ?>
<?php print("total: ".$total); ?>
</pre></body></html>