<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <link href='./css/default.css' rel='stylesheet' />
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

</head>

<body class="map">
    <header>
        <div id="menu" onclick="$('#mobilemenu').toggle();">
            <div id="menubar"></div>
            <div id="menubar"></div>
            <div id="menubar"></div>
        </div>
        <div id="header_container">
            <div id="logo">Property<span>Village</span></div>

            <form action="search.php" method="get">
                <input type="text" name="term"><input type="submit">
            </form>

        </div>
        </div>
        <?php 
// Adding items from menu views
$directory = getcwd() . "/menu.inc";

include($directory);
echo '<ul id="menu">';
foreach ($views as $item => $value) {
    echo '<li><a href="' . $item . '">' .  $value . '</a></li>';
}
echo '</ul>';
?>
        <button class="button login" onclick="$('ul#menu').toggle()">Login</button>
    </header>

    <div id="map_container">
        <div id="mapid"></div>

        <script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
        <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>


        <div id="result">
            <div id="cards">
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

                                var latitude = parseFloat(feature.center[0]);
                                var metersPerPixel = 40075016.686 * Math.abs(Math.cos(latitude * 180 / Math.PI)) / Math.pow(2, zoomLevel + 8);
                                var milesRadius = 1609.344 * 25;// meters * desired miles
                                console.log(metersPerPixel);
        //var marker = L.marker([feature.center[1], feature.center[0]]).addTo(mymap);
        <?php 
        echo $markers;
        ?>
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

                            }

                        });

                </script>
            </div>
        </div>


</body>

</html>