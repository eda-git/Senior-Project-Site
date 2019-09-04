<?php 
$term = $_GET['term'];
$url = 'http://api.mapbox.com/geocoding/v5/mapbox.places/' . $term . '.json?access_token=' . $accessToken;
$GLOBALS['milesWanted'] = $_GET['milesWanted'];
$GLOBALS['jsonLat'] = $_GET['jsonLat'];
$GLOBALS['jsonLong'] = $_GET['jsonLong'];
$GLOBALS['order'] = $_GET['order'];
$aOrD = $_GET['aOrD'];
if(empty($aOrD)){
    $order = "";
}
else{
if(strcmp($aOrD, "pricelow") == 0){
    $aOrD = "cost";
}else if (strcmp($aOrD, "pricehigh") == 0){
    $aOrD = "cost desc";
}else if (strcmp($aOrD, "sqft") == 0){
    $aOrD = "sqft desc";
}else if (strcmp($aOrD, "beds") == 0){
    $aOrD = "bed desc";
}else if (strcmp($aOrD, "baths") == 0){
    $aOrD = "bath desc";
}else if (strcmp($aOrD, "distance") == 0){

    $GLOBALS['selections'] = ", (
        3959 * acos (
          cos ( radians(78.3232) )
          * cos( radians( latitude ) )
          * cos( radians( longitude ) - radians(65.3234) )
          + sin ( radians(78.3232) )
          * sin( radians( latitude ) )
        )
      ) AS distance";

    $aOrD = "distance desc";
}
$order = "order by " . $aOrD;
}
?>
<script>

// no need to specify document ready

$(function(){
    // don't cache ajax or content won't be fresh
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
           

   <div id="map_container">
        <div id="mapid"></div>

        <script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
        <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>


        <div id="result">
			<div id="search_filters" style="margin-top:5em;"> <form id="loadBasic" style="margin-top:1em;">
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
            <div id="cards" style="margin-top:10em">
            <?php 
            include('conn.inc');

            include('dollar.php');
    $query = "select `property_id`, `cost`, `bed`, `bath`, `sqft`, `address`, `zipcode`, `city`, `state`, `latitude`, `longitude` " . $selections . " from listing where 
    (latitude < ((" . $milesWanted . "/69) + " . $jsonLat . ")) 
    and (latitude > ( " . $jsonLat . " - (" . $milesWanted . "/69))) 
    and (`longitude` < ((" . $milesWanted . "/54.6) + " . $jsonLong . ")) 
    and (`longitude` > (" . $jsonLong . " - (" . $milesWanted . "/54.6))) " . $order . ";";

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
    
    $cardItems = $cardItems . '<a href="#" data-value="' .  $row['property_id'] . '">
    <div id="item" style="background-size: cover; background: url(img/' .  $row['property_id'] . '.png) no-repeat center, #c9c9c9;"> <div id="photo"> </div> 
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
                                var mymap = L.map('mapid').setView([feature.center[1], feature.center[0]], 8);
                                var point = L.point(50, 0);
                                var latLng = mymap.layerPointToLatLng(point);
                                //var latLngPoint = L.marker([latLng.lat + "," + latLng.lng]).addTo(mymap);
                                var latitude = parseFloat(feature.center[0]);
                                var metersPerPixel = 40075016.686 * Math.abs(Math.cos(latitude * 180 / Math.PI)) / Math.pow(2, zoomLevel + 8);
                                var milesRadius = 1609.344 * <?php echo $_GET['milesWanted']; ?>;// meters * desired miles
                                console.log(metersPerPixel);
        //var marker = L.marker([feature.center[1], feature.center[0]]).addTo(mymap);
        var circle = L.circle([feature.center[1], feature.center[0]], {
                                    color: 'red',
                                    fillColor: '#f03',
                                    fillOpacity: 0.5,
                                    radius: milesRadius
                                }).addTo(mymap);
                                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiZWRhbGkiLCJhIjoiY2pyNHB5ejR2MXl3cjQ0bzBsNnV2Z3M3OCJ9.ypnlWXvz0ps-HVntevQchQ', {
                                    maxZoom: 18,
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


		<title>Property Search of 
<?php echo $_GET['term'];

?></title>

<?php 
echo '  <script src="js/ajax.js"></script>';
?>