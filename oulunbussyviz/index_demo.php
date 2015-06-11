<?php 
require_once("config.php");
header("Content-type: text/xml; charset=ISO-8859-1");

$response_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$response_xml .= "\t<busses>\n";

$current_time = date('H:i:s');
$distance = 9999999999999999;
$current_value = intval(substr($current_time, 0, 2))*3600 + intval(substr($current_time, 3, 2))*60 + intval(substr($current_time, 6, 2));
$seconds = '';
for ($i=1; $i<5; $i++)
{
	$seconds .= '' . ($current_value-$i) . ',';
}
$seconds .= $current_value;
$get_new_busses_sql = "	SELECT a.trip_id, b.shape_id
						FROM `stop_times` a
						inner join trips b on a.trip_id = b.trip_id
						inner join calendar_dates c on b.service_id = c.service_id and c.date = '".date('Ymd')."'
						where stop_sequence = 1 and a.departure_number_time in ()";
$result = $conn->query($get_new_busses_sql);
$busses_number = 0;

$all_trips = [];
array_push($all_trips, );

while($row = $result->fetch_assoc())
{
	$shape_sql = "	SELECT *
					FROM `shapes` a
					left join stop_times b on a.shape_dist_traveled = IFNULL(b.shape_dist_traveled, 0) and b.trip_id='".$row['trip_id']."'
					where a.shape_id = '".$row['shape_id']."'";
	$result_shape = $conn->query($shape_sql);
	$response_xml .= "\t\t<bus_detail>";
	while($row_bus_detail = $result_shape->fetch_assoc())
	{
		$response_xml .= "\t\t\t<shape_id>".$row_bus_detail['shape_id']."</shape_id>";
		$response_xml .= "\t\t\t<shape_pt_lat>".$row_bus_detail['shape_pt_lat']."</shape_pt_lat>";
		$response_xml .= "\t\t\t<shape_pt_lon>".$row_bus_detail['shape_pt_lon']."</shape_pt_lon>";
		$response_xml .= "\t\t\t<shape_pt_sequence>".$row_bus_detail['shape_pt_sequence']."</shape_pt_sequence>";
		$response_xml .= "\t\t\t<shape_dist_traveled>".$row_bus_detail['shape_dist_traveled']."</shape_dist_traveled>";
		$response_xml .= "\t\t\t<arrival_time>".$row_bus_detail['arrival_time']."</arrival_time>";
		$response_xml .= "\t\t\t<departure_time>".$row_bus_detail['departure_time']."</departure_time>";
		$response_xml .= "\t\t\t<stop_id>".$row_bus_detail['stop_id']."</stop_id>";
		$response_xml .= "\t\t\t<stop_sequence>".$row_bus_detail['stop_sequence']."</stop_sequence>";
		$response_xml .= "\t\t\t<departure_number_time>".$row_bus_detail['departure_number_time']."</departure_number_time>";
	}
	$result_shape->close();
	$response_xml .= "\t\t</bus_detail>";
}
$result->close();
$response_xml .= "\t</busses>";
echo $response_xml;
?>