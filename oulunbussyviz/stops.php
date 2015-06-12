<?php 
require_once("config.php");
header("Content-type: text/xml; charset=ISO-8859-1");
header('Access-Control-Allow-Origin: *');

$response_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$response_xml .= "<bus_stops>\n";

$get_new_busses_sql = "	SELECT *
						FROM `stops` a";
$result = $conn->query($get_new_busses_sql);
while($row = $result->fetch_assoc())
{
	$response_xml .= "\t<stop>\n";
	$response_xml .= "\t\t<stop_id>".$row['stop_id']."</stop_id>\n";
	$response_xml .= "\t\t<stop_code>".$row['stop_code']."</stop_code>\n";
	$response_xml .= "\t\t<stop_name>".$row['stop_name']."</stop_name>\n";
	$response_xml .= "\t\t<stop_lat>".$row['stop_lat']."</stop_lat>\n";
	$response_xml .= "\t\t<stop_lon>".$row['stop_lon']."</stop_lon>\n";
	$response_xml .= "\t</stop>\n";
}
$result->close();
$response_xml .= "</busses>";
echo $response_xml;
?>