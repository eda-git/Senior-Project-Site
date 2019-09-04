<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<html>
<head>
<script type="text/javascript">
function closeWindow() {
setTimeout(function() {
window.close();
}, 3000);
}

//window.onload = closeWindow();
</script>
<body>
<?php
include('conn.inc');

$address = $_POST["address"];
$city =  ucfirst($_POST["city"]);
$state =  $_POST["state"];
$beds =  $_POST["beds"];
$baths =  $_POST["baths"];
$zipcode = $_POST["zipcode"];
$type =  $_POST["type"];
$pet =  $_POST["pet"];
$smoker =  $_POST["smoker"];
$popcorn =  $_POST["popcorn"];
$story =  $_POST["story"];
$description = $_POST["description"];
$sqft =  $_POST["sqft"];
$beddecimals = $_POST['beddecimal'];
$bathdecimals = $_POST['bathdecimals'];
$unit = $_POST['unit'];
$cost = $_POST['cost'];
$flooring = $_POST['flooring'];
$heating = $_POST['heating'];
$style = $_POST['style'];
$condition = $_POST['condition'];
$built = $_POST['built'];
$lot = $_POST['lot'];
$description = $_POST['description'];
$story = $_POST['story'];
$description = str_replace('"', "&quot;", $description);

if(empty($pet)){
    $pet = "0";
}else{
    $pet = "1";
}


if(empty($smoker)){
    $smoker = "0";
}else{
    $smoker = "1";
}



if(empty($popcorn)){
    $popcorn = "0";
}else{
    $popcorn = "1";
}

if(!empty($beddecimals)){
    $beds = $beds . ".5";
}

if(!empty($bathdecimals)){
    $baths = $baths . ".5";
}
//

$term = $address . ", " . $city . ", " . $state;
$term = str_replace(" ", "%20", $term);
$url = 'http://api.mapbox.com/geocoding/v5/mapbox.places/' . $term . '.json?access_token=' . $accessToken;
$json = file_get_contents($url);
$obj = json_decode($json);
$area = $obj->features[0]->center;
$GLOBALS['jsonLong'] = $area[0];
$GLOBALS['jsonLat'] = $area[1];


$query = 'insert into listing values ("0", "' . htmlspecialchars($_SESSION['username']) .'", "' . $type .'", "' . $address . '", "'. $city . '", "'. $state . '", 
"' . $zipcode . '", "' . $cost . '", "' . $unit . '", 
"' . $beds . '", "' . $baths . '", "' . $sqft  . '", "' . $pet . '", "' . $smoker . '", "' . $popcorn . '", "' . $jsonLong . '", "'. $jsonLat . '", now());';
//$query = 'insert into listing 
//values ("0", "' . htmlspecialchars($_SESSION['username']) .'", "' . $type . '", "' . $address . '", "' . $city . '", "' . $state . '", "' . $zipcode . '", "' . $unit . '", 
//"' . $beds . '", "' . $baths . '", "' . $sqft . '", "' . $pet . '", "' . $smoker . '", "' . $popcorn . '", "' . $jsonLong . '", "' . $jsonLong . '", now());';
$result = mysqli_query($con,  $query);

$query2 = 'select * from listing
order by property_id desc limit 1';

$result2 = mysqli_query($con,  $query2);

while($row = mysqli_fetch_array($result2))
{
 $property_id = $row['property_id'];
 }
$query3 = 'insert into attributes 
values("' . $flooring . '", "' . $story . '", "' . $heating . '", "' . $condition . '", "' .  $style . '", "' . $built . '", "' . $lot . '", "' . htmlentities($description, ENT_QUOTES) . '", "' . $property_id . '")';
$result3 = mysqli_query($con,  $query3);

?>
</body>