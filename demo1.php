<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<link href='./css/default.css' rel='stylesheet' />

<?php 
// 
include(headers.inc);
?>
    
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.52.0/mapbox-gl.css' rel='stylesheet' />

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

</div></div>
<?php 
// Adding items from menu views
include("menu.inc");
echo '<ul id="menu">';
foreach ($views as $item => $value) {
    echo '<li><a href="' . $item . '">' .  $value . '</a></li>';
}
echo '</ul>';
?>
<button class="button login" onclick="$('ul#menu').toggle()">Login</button>
</header>

<div id='map'></div>
<script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiZWRhbGkiLCJhIjoiY2pyNHB5ejR2MXl3cjQ0bzBsNnV2Z3M3OCJ9.ypnlWXvz0ps-HVntevQchQ';
// eslint-disable-next-line no-undef
var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
mapboxClient.geocoding.forwardGeocode({
    <?php
    $location = "1740 Pacific Ave, Tacoma, WA 98402";
    $location = "-122.333,47.591"; // 47.591,122.333
    echo "query: '" . $location . "'"; ?>,
    autocomplete: false,
    limit: 1
})
    .send()
    .then(function (response) {
        if (response && response.body && response.body.features && response.body.features.length) {
            var feature = response.body.features[0];

            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v9',
                center: feature.center,
                zoom: 16
            });
            map.addControl(new mapboxgl.NavigationControl());

            new mapboxgl.Marker()
                .setLngLat(feature.center)
                .addTo(map);
        }
        
    });
    new mapboxgl.Marker()
  .setLngLat([30.5, 50.5])
  .addTo(map);
        

</script>
</body>
</head>
</html>