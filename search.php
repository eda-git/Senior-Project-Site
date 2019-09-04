<?php
session_start();
?>
<!DOCTYPE html>
<?php
include('conn.inc');
if(!empty($_GET["term"])){

}else{
    header("Location: index.php");
die();
}
if(empty($_GET["miles"])){
    $GLOBALS['milesWanted'] = 15;
}else{
    $GLOBALS['milesWanted'] = $_GET["miles"];
}
$term = $_GET['term'];
$term = str_replace(" ", "%20", $term);
$url = 'http://api.mapbox.com/geocoding/v5/mapbox.places/' . $term . '.json?access_token=' . $accessToken;
$json = file_get_contents($url);
$obj = json_decode($json);
$area = $obj->features[0]->center;
$GLOBALS['jsonLong'] = $area[0];
$GLOBALS['jsonLat'] = $area[1];


?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<title>PropertyVillage</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link href='./css/default1.css' rel='stylesheet' />
    <?php 
// 
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
?>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
        crossorigin="">
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
        crossorigin=""></script>
      

 
<body>
<header>
<a href="index.php" class="logohref"><div id="logo">Property<span>Village</span></div></a>
<a href="login.php"><button class="button login">Account</button></a>
</header>
<div id="menus"><div id="holder"><div id="item" class="search">
        <form action="search.php" method="get">
<input type="text" name="term"><input type="submit">
</form>
    </div>
    <div id="item" class="add">
        <a href="add.php">Add a Property</a>
    </div>
    </div>
    </div>
<div id="content" style="height: 84%;">





<div id="map_container">
        <div id="mapid"></div>

        <script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
        <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>


        <div id="result">
	<div id="search_filters"> <form id="loadBasic" style="margin-top:1em;">
				<select name="miles">   
                <option>Miles Filter</option> 
                <option value="15">15 miles</option>  
 
				<option value="25">25 miles</option>  
				<option value="50">50 miles</option>                              
				<option value="100">100 miles</option>
				<option value="250">250 miles</option>
				<option value="500">500 miles</option>				
				</select>
            </form>

            <form id="filterBasic" style="margin-top:1em;">
				<select name="aOrD">   
                <option value="">Filtered Search</option> 
                <option value="distance">Distance</option>  
				<option value="pricelow">Price Low to High</option>  
				<option value="pricehigh">Price High to Low</option>
                <option value="sqft">Square Feet</option>  
                <option value="beds">Beds</option>  
                <option value="baths">Baths</option>  

				</select>
            </form>

            <button id="search" class="button refine">Refine Search</button>
            </div>
            <div id="cards">
            <?php 
        include('dollar.php');
$query = "select `property_id`, `cost`, `bed`, `bath`, `sqft`, `address`, `zipcode`, `city`, `state`, `latitude`, `longitude` from listing where 
(latitude < ((" . $milesWanted . "/69) + " . $jsonLat . ")) 
and (latitude > ( " . $jsonLat . " - (" . $milesWanted . "/69))) 
and (`longitude` < ((" . $milesWanted . "/54.6) + " . $jsonLong . ")) 
and (`longitude` > (" . $jsonLong . " - (" . $milesWanted . "/54.6)));";
$result = mysqli_query($con,  $query);
$total = [];
$ids = [];
$GLOBALS['cardItems'] = "";
$GLOBALS["markers"] = "";
while($row = mysqli_fetch_array($result))
{
    $cost = $row['cost'];
    $bed = floatval($row['bed']);
    
    $bath = floatval($row['bath']);
    $cost = dollar_func($cost);
$descriptors = '<strong><a href="home.php?home=' .  $row['property_id'] . '">' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . "</a></strong>" . "<h2>" . $cost . "</h2><p>" . $bed . ' Beds, ' . $bath . ' Baths, ' . $row['sqft'] . " Square Feet</p>";
$coordinates = $row['latitude'] . "," . $row['longitude'] . ":" . $descriptors;
array_push($total, $coordinates);

$cardItems = $cardItems . '<a href="#" data-value="' .  $row['property_id'] . '"><div id="item" <div id="item" style="background-size: cover; background: url(img/' .  $row['property_id'] . '.png) no-repeat center, #c9c9c9;"> <div id="photo"> </div> 
<div id="cost"> ' . $cost  . ' </div> <div id="description">' . $bed . ' Beds, ' . $bath . ' Baths, ' . $row['sqft'] . ' Square Feet</div> <div id="address">' . 
$row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zipcode'] . '</div> </div></a>';
}

foreach ($total as $coordinates) {
$items = explode(":", $coordinates);

$markers = $markers . "L.marker([" . $items[0]  . "]).addTo(mymap).bindPopup('" . $items[1] . "');


";
}
?>
<?php echo $cardItems;  ?>
                <script>
                    mapboxgl.accessToken = 'pk.eyJ1IjoiZWRhbGkiLCJhIjoiY2pyNHB5ejR2MXl3cjQ0bzBsNnV2Z3M3OCJ9.ypnlWXvz0ps-HVntevQchQ';
                    // eslint-disable-next-line no-undef
                    var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
                    mapboxClient.geocoding.forwardGeocode({
    <?php
    $location = "1740 Pacific Ave, Tacoma, WA 98402";
                    $location = "-122.333,47.591"; // 47.591,122.333
                    $location = $_GET["term"];
                    echo "query: '".$location. "'"; ?>,
                        autocomplete: false,
                            limit: 1
})
    .send()
                        .then(function geoLocation(response) {
                            if (response && response.body && response.body.features && response.body.features.length) {
                                var feature = response.body.features[0];
                                console.log(feature.center[1] + "," + feature.center[0]);
                                var zoomLevel = parseInt(8);
                                var mymap = L.map('mapid').setView([feature.center[1], feature.center[0]], 10);
                                var point = L.point(50, 0);
                                var latLng = mymap.layerPointToLatLng(point);
                                //var latLngPoint = L.marker([latLng.lat + "," + latLng.lng]).addTo(mymap);
                                var latitude = parseFloat(feature.center[0]);
                                var metersPerPixel = 40075016.686 * Math.abs(Math.cos(latitude * 180 / Math.PI)) / Math.pow(2, zoomLevel + 10);
                                var milesRadius = 1609.344 * <?php echo $milesWanted; ?>;// meters * desired miles
                                console.log(metersPerPixel);
        //var marker = L.marker([feature.center[1], feature.center[0]]).addTo(mymap);
        var circle = L.circle([feature.center[1], feature.center[0]], {
                                    color: 'red',
                                    fillColor: '#f03',
                                    fillOpacity: 0.5,
                                    radius: milesRadius
                                }).addTo(mymap);
                                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiZWRhbGkiLCJhIjoiY2pyNHB5ejR2MXl3cjQ0bzBsNnV2Z3M3OCJ9.ypnlWXvz0ps-HVntevQchQ', {
                                    maxZoom: 30,
                                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                                    id: 'mapbox.streets'
                                }).addTo(mymap);
                                <?php
                                  echo $markers; 
        ?>

                            }

                        });

                </script>
            </div>
        </div>




</div>
<div id="subsection">
</div>
<div id="footer">
    <div id="sitemap">
    </div>
    <div id="bottom_menu">
    </div>
    
<script>
    $(function() {
    $(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $("header").addClass("active");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
           $("header").removeClass("active");
        }
    });
});
</script>

</div>
</div>


<div id="ajax_delivery">
   
</div>
</body>
<script>


$(function(){
    $.ajaxSetup ({
        cache: false
    });
	
	
    var ajax_load = "<img src='http://i.imgur.com/pKopwXp.gif' alt='loading...' />";
       
        $("button#search.refine").click(function(){
            var selVal = $("#loadBasic select").val();
            var secVal = $("#filterBasic select").val();
			var loadUrl = "map.php?milesWanted=" + selVal + "&aOrD=" + secVal + "&<?php echo'&term=' . $term . '&jsonLong=' . $jsonLong . '&jsonLat=' . $jsonLat;?>";
            $("#map_container").load(loadUrl);
        });




		
    $("#loadBasic").click(function(){
        
    });
});
</script>
  <script src="js/ajax.js"></script>
</head>
</html>