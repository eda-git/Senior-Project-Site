<script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiZWRhbGkiLCJhIjoiY2pyNHB5ejR2MXl3cjQ0bzBsNnV2Z3M3OCJ9.ypnlWXvz0ps-HVntevQchQ';
// eslint-disable-next-line no-undef
var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
mapboxClient.geocoding.forwardGeocode({
        <?php
        include('conn.inc');
        $result = mysqli_query($con,  "select * from houses order by CITY");
        require_once('Mapbox.php');
        $mapbox = new Mapbox("pk.eyJ1IjoiZWRhbGkiLCJhIjoiY2pyNHB5ejR2MXl3cjQ0bzBsNnV2Z3M3OCJ9.ypnlWXvz0ps-HVntevQchQ");
        while($row = mysqli_fetch_array($result))
    {
        $dlocation = $row['ADDRESS'] . ', ' . $row['CITY'] . ', ' . $row['STATE'] . ', ' . $row['ZIPCODE'];
        // Get lat and long by address         
            $address = $dlocation;
            echo "query: '" . $address . "'";

    }
    ?>,
    autocomplete: false
   
})
    .send()
    .then(function geoLocation (response) {
        if (response && response.body && response.body.features && response.body.features.length) {
            var feature = response.body.features[0];
        console.log(feature.center[1] + "," + feature.center[0]);
        var zoomLevel = parseInt(8);
        var mymap = L.map('mapid').setView([feature.center[1], feature.center[0]], 8);
        var latitude = parseFloat(feature.center[0]);
        var metersPerPixel = 40075016.686 * Math.abs(Math.cos(latitude * 180/Math.PI)) / Math.pow(2, zoomLevel+8);
        var milesRadius = 1609.344 * 25;// meters * desired miles
        console.log(metersPerPixel);
        var marker = L.marker([feature.center[1], feature.center[0]]).addTo(mymap);
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
