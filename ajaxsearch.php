<?php 
include('conn.inc');
$result = mysqli_query($con,  "select houses.`HOUSEID`, `COST`, `BEDS`, `BATH`, `SQFT`, `ADDRESS`, `ZIPCODE`, `CITY`, `STATE`, `LAT`, `LONG` from houses 
INNER JOIN longlat ON longlat.HOUSEID=houses.HOUSEID where 
(Lat < ((5/69) + 47.241851)) 
and (Lat > ( 47.241851 - (5/69))) 
and (`LONG` < ((25/54.6) + -122.46056)) 
and (`LONG` > (-122.46056 - (25/54.6)));");
$total = [];
$GLOBALS["markers"] = "";
while($row = mysqli_fetch_array($result))
{

$coordinates = $row['LAT'] . "," . $row['LONG'];
array_push($total, $coordinates);
echo '<div id="item">
<div id="photo">
</div>  
<div id="cost">
' . $row['COST'] . ' ' . $row['LONG'] . ' ' . $row['LAT'] . '
</div>
<div id="description">' . $row['BEDS'] . ' Beds, ' . $row['BATHS'] . ' Baths, ' . $row['SQFT'] . ' Square Feet</div>
<div id="address">' . $row['ADDRESS'] . ', ' . $row['CITY'] . ', ' . $row['STATE'] . ', ' . $row['ZIPCODE'] . '</div>
</div>';
}

foreach ($total as $coordinates) {
$markers = $markers . "L.marker([" . $coordinates  . "]).addTo(mymap);

";
}
?>