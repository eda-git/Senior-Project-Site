<!DOCTYPE html>
<?php
include('conn.inc');
if(!empty($_GET["term"])){

}else{
    header("Location: index.php");
die();
}
if(empty($_GET["miles"])){
    $GLOBALS['milesWanted'] = 25;
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


<body class="map">

    <button id="loadbasic">basic load</button>
<div id="map_container"></div>
<script>
// learn jquery ajax 
// http://net.tutsplus.com/tutorials/javascript-ajax/5-ways-to-make-ajax-calls-with-jquery/

// no need to specify document ready

$(function(){
    // don't cache ajax or content won't be fresh
    $.ajaxSetup ({
        cache: false
    });
    var ajax_load = "<img src='http://i.imgur.com/pKopwXp.gif' alt='loading...' />";
    
    // load() functions
    var loadUrl = "map.php";
    $("#loadbasic").click(function(){
        $("#map_container").html(ajax_load).load(loadUrl);
    });

// end  
});
</script>
</body>
<title>Property Search of 
<?php echo $_GET['term'];

?></title>
</head>

</html>