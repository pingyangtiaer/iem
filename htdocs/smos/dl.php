<?php 
include("../../config/settings.inc.php");
include("$rootpath/include/database.inc.php");

$conn = iemdb("smos");

$lat = isset($_REQUEST["lat"])? $_REQUEST["lat"] : die("No lat");
$lon = isset($_REQUEST["lon"])? $_REQUEST["lon"] : die("No lon");
$day1 = isset($_GET["day1"]) ? $_GET["day1"] : die("No day1 specified");
$day2 = isset($_GET["day2"]) ? $_GET["day2"] : die("No day2 specified");
$month1 = isset($_GET["month1"]) ? $_GET["month1"]: die("No month specified");
$month2 = isset($_GET["month2"]) ? $_GET["month2"]: die("No month specified");
$year1 = isset($_GET["year1"]) ? $_GET["year1"] : die("No year1 specified");
$year2 = isset($_GET["year2"]) ? $_GET["year2"] : die("No year2 specified");

$ts1 = mktime(0,0,0, $month1, $day1, $year1);
$ts2 = mktime(0,0,0, $month2, $day2, $year2);

pg_prepare($conn, "FIND", "select idx, distance( geom, geometryfromtext($1, 4326)) 
		from grid ORDER by distance ASC LIMIT 1");
$rs = pg_execute($conn, "FIND", Array("POINT($lon $lat)"));

$row = pg_fetch_assoc($rs, 0);
$idx = $row["idx"];
if ($row["distance"] > 1){
	die("Point too far away from our grid!");
}

$rs = pg_query($conn, "SELECT valid, 
		case when soil_moisture is null then 'M' else soil_moisture::text end as sm, 
		case when optical_depth is null then 'M' else optical_depth::text end as od 
		from data where grid_idx = $idx and 
		valid >= '". date("Y-m-d", $ts1) ."' and 
		valid <= '". date("Y-m-d", $ts2) ."' ORDER by valid ASC");

header("Content-type: text/plain");
echo "Timestamp,Longitude,Latitude,Soil_Moisture,Optical_Depth\n";
for ($i=0;$row=@pg_fetch_assoc($rs,$i);$i++){
	echo sprintf("%s,%s,%s,%s,%s\n", $row["valid"], $lon, $lat, 
			$row["sm"], $row["od"]);
	
}

?>