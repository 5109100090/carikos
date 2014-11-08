
<?php
$username="k4077620_kos";
$password="k4077620_gemastik";
$database="k4077620_kos";

define("MAPS_HOST", "maps.google.com");
define("KEY", "ABQIAAAA8n1NNoWYFgYv_GWU1p2c4RRLjChdnDwTg0uEDJhec5QgIb9wNBRMW2usfBnT1rVpFGAjbsPRSKAsNQ");

// Opens a connection to a MySQL server
$connection = mysql_connect("localhost", $username, $password);

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);

// Select all the rows in the markers table
$query = "SELECT * FROM kos";
$result = mysql_query($query);

// Initialize delay in geocode speed
$delay = 0;
$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;

// Iterate through the rows, geocoding each address
while ($row = @mysql_fetch_assoc($result)) {
    $address = $row["kos_lat"].','.$row["kos_lng"];
    $id = $row["kos_id"];
    $request_url = $base_url . "&q=" . urlencode($address);
    $xml = simplexml_load_file($request_url) or die("url not loading");
	$coordinates = $xml->Response->Placemark->address;
	echo $coordinates.'<br>';
	mysql_query("update kos set kos_alamat='$coordinates' where kos_id='$id'");
}
?>
