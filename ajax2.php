<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
body {
 font-family: Arial;   
}

.excontainer {
  padding: 1em;    
}

label {
 display: block;
 width: 100%;   
}

p {
 padding: .5em;   
}

a, a:visited {
 color: #2d9afd;   
}

.changed {
  color: #ff0099;   
}

.highlight {
  background: #faffda;   
}

.entered {
  color: #f5560a;
}

.green {
 color: #7fbf38;   
}

.hellomouse, .clickable, #foo, #event {
 cursor: pointer;   
}

button {
 margin-bottom: 1em;   
}

div {
  margin: 1em 0;   
}

#foo {
 display: inline-block;   
}



ul {
 margin: 1em 0;   
}

.form, form, .stuff, .morestuff, stuff3 {
    margin: 1em 0;
    padding: 1em;
    background: #ececec;
}

input {
 font-size: 1.1em;
 padding: 2px;    
}

.placeholder {
   color: #ff0099;  
   font-weight: normal; 
}

::-webkit-input-placeholder {
   color: #cccccc;
}

:-moz-placeholder {  
   color: #cccccc;  
}

:-ms-input-placeholder {
    color: #cccccc;
}

:focus::-webkit-input-placeholder {
    color:transparent;
}

.content {
    margin-top: 5px;
    padding: 1em;
    background: #eeeeee;     
}

</style>
<body>
<div class="excontainer">
    <div id="result">   
	test
	<div id="map_container">
        <div id="mapid"></div>

        <script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
        <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>


        <div id="result">
            <div id="cards">
<?php 
$query = "select houses.`HOUSEID`, `COST`, `BEDS`, `BATH`, `SQFT`, `ADDRESS`, `ZIPCODE`, `CITY`, `STATE`, `LAT`, `LONG` from houses 
INNER JOIN longlat ON longlat.HOUSEID=houses.HOUSEID where 
(Lat < ((" . $milesWanted . "/69) + " . $jsonLat . ")) 
and (Lat > ( " . $jsonLat . " - (" . $milesWanted . "/69))) 
and (`LONG` < ((" . $milesWanted . "/54.6) + " . $jsonLong . ")) 
and (`LONG` > (" . $jsonLong . " - (" . $milesWanted . "/54.6)));";
echo $query;
$result = mysqli_query($con,  $query);
$total = [];
$GLOBALS['cardItems'] = "";
$GLOBALS["markers"] = "";
while($row = mysqli_fetch_array($result))
{

$coordinates = $row['LAT'] . "," . $row['LONG'];
array_push($total, $coordinates);
$cardItems = $cardItems . '<div id="item"> <div id="photo"> </div> <div id="cost"> ' . $row['COST'] . ' ' . $row['LONG'] . ' ' . $row['LAT'] . ' </div> <div id="description">' . $row['BEDS'] . ' Beds, ' . $row['BATHS'] . ' Baths, ' . $row['SQFT'] . ' Square Feet</div> <div id="address">' . $row['ADDRESS'] . ', ' . $row['CITY'] . ', ' . $row['STATE'] . ', ' . $row['ZIPCODE'] . '</div> </div>';
}

foreach ($total as $coordinates) {
$markers = $markers . "L.marker([" . $coordinates  . "]).addTo(mymap);

";
}
?>
<?php echo $cardItems; ?>
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


		</div>
 
</div>




</body>
</head>
</html>