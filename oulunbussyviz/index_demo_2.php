<?php 
require_once("config.php");
header('Access-Control-Allow-Origin: *');
header("Content-type: text/xml; charset=ISO-8859-1");

$response_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$response_xml .= "\t<busses>\n";

$busses_number = 0;

$all_trips = [];
array_push($all_trips, ['trip_id' => '0000214002101111', 'shape_id' => '15_merged_429001110256', 'index' => 1]);
array_push($all_trips, ['trip_id' => '0000215002101111', 'shape_id' => '14_merged_429001110257', 'index' => 2]);
array_push($all_trips, ['trip_id' => '0000213502101111', 'shape_id' => '15_merged_429001110256', 'index' => 3]);
array_push($all_trips, ['trip_id' => '0000231502101111', 'shape_id' => '14_merged_429001110257', 'index' => 4]);
array_push($all_trips, ['trip_id' => '0000226202101111', 'shape_id' => '14_merged_429001110257', 'index' => 5]);
array_push($all_trips, ['trip_id' => '0000214602101111', 'shape_id' => '14_merged_429001110257', 'index' => 6]);
array_push($all_trips, ['trip_id' => '0000215402101111', 'shape_id' => '14_merged_429001110257', 'index' => 7]);
array_push($all_trips, ['trip_id' => '0000213102101111', 'shape_id' => '15_merged_429001110256', 'index' => 8]);
array_push($all_trips, ['trip_id' => '0000215802101111', 'shape_id' => '14_merged_429001110257', 'index' => 9]);
array_push($all_trips, ['trip_id' => '0000226402101111', 'shape_id' => '14_merged_429001110257', 'index' => 10]);
array_push($all_trips, ['trip_id' => '0000211702101111', 'shape_id' => '15_merged_429001110256', 'index' => 11]);
array_push($all_trips, ['trip_id' => '0000214502101111', 'shape_id' => '14_merged_429001110257', 'index' => 12]);
array_push($all_trips, ['trip_id' => '0000213802101111', 'shape_id' => '15_merged_429001110256', 'index' => 13]);
array_push($all_trips, ['trip_id' => '0000212702101111', 'shape_id' => '15_merged_429001110256', 'index' => 14]);
array_push($all_trips, ['trip_id' => '0000212302101111', 'shape_id' => '15_merged_429001110256', 'index' => 15]);
array_push($all_trips, ['trip_id' => '0000231102101111', 'shape_id' => '14_merged_429001110257', 'index' => 16]);
array_push($all_trips, ['trip_id' => '0000211902101111', 'shape_id' => '15_merged_429001110256', 'index' => 17]);
array_push($all_trips, ['trip_id' => '0000225402101111', 'shape_id' => '15_merged_429001110256', 'index' => 18]);
array_push($all_trips, ['trip_id' => '0000071502107031', 'shape_id' => '52_merged_429001110219', 'index' => 19]);
array_push($all_trips, ['trip_id' => '0000103402107031', 'shape_id' => '51_merged_429001110217', 'index' => 20]);
array_push($all_trips, ['trip_id' => '0000103602107031', 'shape_id' => '51_merged_429001110217', 'index' => 21]);
array_push($all_trips, ['trip_id' => '0000244602107031', 'shape_id' => '50_merged_429001110218', 'index' => 22]);
array_push($all_trips, ['trip_id' => '0000068502107031', 'shape_id' => '50_merged_429001110218', 'index' => 23]);
array_push($all_trips, ['trip_id' => '0000068602107031', 'shape_id' => '50_merged_429001110218', 'index' => 24]);
array_push($all_trips, ['trip_id' => '0000243802107031', 'shape_id' => '52_merged_429001110219', 'index' => 25]);

$r = rand(0, count($all_trips)-5);
for ($i=0; $i<=$r; $i++)
{
	array_pop($all_trips);
}
$row_1 = array_pop($all_trips);
$r = rand(0, count($all_trips)-2);
for ($i=0; $i<=$r; $i++)
{
	array_pop($all_trips);
}
$row_2 = array_pop($all_trips);

$shape_sql = "	SELECT a.shape_id, a.shape_pt_lat, a.shape_pt_lon, a.shape_pt_sequence, a.shape_dist_traveled, b.arrival_time, b.departure_time, 
				b.stop_id, b.stop_sequence, b.departure_number_time
				FROM `shapes` a
				left join stop_times b on a.shape_dist_traveled = IFNULL(b.shape_dist_traveled, 0) and b.trip_id='".$row_1['trip_id']."'
				where a.shape_id = '".$row_1['shape_id']."'";
$result_shape = $conn->query($shape_sql);
$response_xml .= "\t\t<bus_detail>\n";
while($row_bus_detail = $result_shape->fetch_assoc())
{
	$response_xml .= "\t\t\t<shape>\n";
	$response_xml .= "\t\t\t\t<shape_id>".$row_1['shape_id']."</shape_id>\n";
	$response_xml .= "\t\t\t\t<trip_id>".$row_1['trip_id']."</trip_id>\n";
	$response_xml .= "\t\t\t\t<shape_pt_lat>".$row_bus_detail['shape_pt_lat']."</shape_pt_lat>\n";
	$response_xml .= "\t\t\t\t<shape_pt_lon>".$row_bus_detail['shape_pt_lon']."</shape_pt_lon>\n";
	$response_xml .= "\t\t\t\t<shape_pt_sequence>".$row_bus_detail['shape_pt_sequence']."</shape_pt_sequence>\n";
	$response_xml .= "\t\t\t\t<shape_dist_traveled>".$row_bus_detail['shape_dist_traveled']."</shape_dist_traveled>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<arrival_time>".$row_bus_detail['arrival_time']."</arrival_time>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<departure_time>".$row_bus_detail['departure_time']."</departure_time>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<stop_id>".$row_bus_detail['stop_id']."</stop_id>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<stop_sequence>".$row_bus_detail['stop_sequence']."</stop_sequence>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<departure_number_time>".$row_bus_detail['departure_number_time']."</departure_number_time>\n";
	$response_xml .= "\t\t\t</shape>\n";
}
$result_shape->close();
$response_xml .= "\t\t</bus_detail>\n";

$shape_sql = "	SELECT a.shape_id, a.shape_pt_lat, a.shape_pt_lon, a.shape_pt_sequence, a.shape_dist_traveled, b.arrival_time, b.departure_time, 
				b.stop_id, b.stop_sequence, b.departure_number_time
				FROM `shapes` a
				left join stop_times b on a.shape_dist_traveled = IFNULL(b.shape_dist_traveled, 0) and b.trip_id='".$row_2['trip_id']."'
				where a.shape_id = '".$row_2['shape_id']."'";
$result_shape = $conn->query($shape_sql);
$response_xml .= "\t\t<bus_detail>\n";
while($row_bus_detail = $result_shape->fetch_assoc())
{
	$response_xml .= "\t\t\t<shape>\n";
	$response_xml .= "\t\t\t\t<shape_id>".$row_2['shape_id']."</shape_id>\n";
	$response_xml .= "\t\t\t\t<trip_id>".$row_2['trip_id']."</trip_id>\n";
	$response_xml .= "\t\t\t\t<shape_pt_lat>".$row_bus_detail['shape_pt_lat']."</shape_pt_lat>\n";
	$response_xml .= "\t\t\t\t<shape_pt_lon>".$row_bus_detail['shape_pt_lon']."</shape_pt_lon>\n";
	$response_xml .= "\t\t\t\t<shape_pt_sequence>".$row_bus_detail['shape_pt_sequence']."</shape_pt_sequence>\n";
	$response_xml .= "\t\t\t\t<shape_dist_traveled>".$row_bus_detail['shape_dist_traveled']."</shape_dist_traveled>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<arrival_time>".$row_bus_detail['arrival_time']."</arrival_time>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<departure_time>".$row_bus_detail['departure_time']."</departure_time>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<stop_id>".$row_bus_detail['stop_id']."</stop_id>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<stop_sequence>".$row_bus_detail['stop_sequence']."</stop_sequence>\n";
	if ($row_bus_detail['stop_id'] != '')
		$response_xml .= "\t\t\t\t<departure_number_time>".$row_bus_detail['departure_number_time']."</departure_number_time>\n";
	$response_xml .= "\t\t\t</shape>\n";
}
$result_shape->close();
$response_xml .= "\t\t</bus_detail>\n";

$response_xml .= "\t</busses>";
echo $response_xml;
?>