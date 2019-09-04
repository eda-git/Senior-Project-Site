<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if(empty($_SESSION["admin"])){

    header("location: index.php");
    exit;
}
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

        <script>


$(function(){
    $.ajaxSetup ({
        cache: false
    });
	
	
    var ajax_load = "<img src='http://i.imgur.com/pKopwXp.gif' alt='loading...' />";
       
        $("#loadBasic select").on("change",function(){
            var selVal = $(this).val();
			var loadUrl = "map.php?milesWanted=" + selVal + "&<?php echo'&term=' . $term . '&jsonLong=' . $jsonLong . '&jsonLat=' . $jsonLat;?>";
            $("#map_container").load(loadUrl);
        });
        $("a#carditem").click(function(){
    var val = $(this).data("value");
    var loadUrl = "ajaxhome.php?home=" + val;
    $("#ajax_delivery").load(loadUrl);
    $('#ajax_delivery').addClass('active');
})



$("div#cards.listing div#delete").click(function(){
    var val = $(this).data("value");
    $('#delete_delivery #yes').attr("data-value", val);
    $('#delete_delivery').addClass('active');
    })
    $("#addimage").click(function(){
    var val = $(this).data("value");
    $('#delete_report_delivery #yes').attr("data-value", val);
    $('#delete_report_delivery').addClass('active');
    })
    $("div#favs div#delete").click(function(){
    var val = $(this).data("value");
    $('#yes').attr("data-value", val);
    $('#favorite_delivery').addClass('active');
    })
$("div#no").click(function(){
    $('#yes').attr("data-value", "0");    
})	
$("#favorite_delivery div#yes").click(function(){
    var val = $(this).data("value");
    var loadUrl = "deletefavorite.php?delete=" + val;

    $.ajax({url: loadUrl, success: function(result){
        location.reload();

  }});
    
})	
$("#delete_report_delivery div#yes").click(function(){
    var val = $(this).data("value");
    var loadUrl = "deletereport.php?delete=" + val;

    $.ajax({url: loadUrl, success: function(result){
        location.reload();

  }});
    
})	


$("#delete_delivery div#yes").click(function(){
    var val = $(this).data("value");
    var loadUrl = "delete.php?delete=" + val;
    $("#delete_delivery").load(loadUrl);
    $('#delete_delivery').removeClass('active');
    
})	
$.ajax({url: loadUrl, success: function(result){
        location.reload();

  }});
});
</script>
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
        <a href="#">Add a Property</a>
    </div>
    </div>
    </div>
<div id="content">
<div id="members">

<div id="contents" class="admin">
<div><h2>ADMIN PROFILE: <?php echo htmlspecialchars($_SESSION['username']); ?></h2></div>
<div class="align left">
    <h3>Existing Properties</h3>
    <div id="overflow_container">
    <div id="cards" class="listing">
    <?php
include('conn.inc');
include('dollar.php');
$query = "select * from listing
";

$result = mysqli_query($con,  $query);
while($row = mysqli_fetch_array($result))
{
$cardItems = $cardItems . '<div id="homeItem"><a href="#" id="carditem" data-value="' .  $row['property_id'] . '">
<div id="item"> <div id="photo"> </div>
<div id="cost"> ' . dollar_func($row['cost']) . '</div> 
<div id="description">' . floatval($row['bed']) . ' Beds, ' . floatval($row['bath']) . ' Baths, ' . $row['sqft'] . ' Square Feet</div> <div id="address">' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zipcode'] . '</div> </div></a>
<div id="delete" data-value="' .  $row['property_id'] . '">
Delete
</div>

</div>';
}

echo $cardItems;
?>
</div>
</div>


<h3>Reports</h3>
    <div id="overflow_container">
    <div id="cards">
    <?php
$query = "select * from report";

$result = mysqli_query($con,  $query);
while($row = mysqli_fetch_array($result)){
    $query2 = "select * from listing where property_id = '" . $row['property_id'] . "'";
    $result2 = mysqli_query($con,  $query2);
    while($row2 = mysqli_fetch_array($result2))
    {
    $cardItems =  '<div id="homeItem"><a href="#" id="carditem" data-value="' .  $row2['property_id'] . '">
    <div id="item"> <div id="photo"> </div>
    <div id="cost"> ' . dollar_func($row2['cost']) . '</div> 
    <div id="description">' . floatval($row2['bed']) . ' Beds, ' . floatval($row2['bath']) . ' Baths, ' . $row2['sqft'] . ' Square Feet</div> <div id="address">' . $row2['address'] . ', ' . $row2['city'] . ', ' . $row2['state'] . ', ' . $row2['zipcode'] . '</div> </div></a>
    <div style="
    display: -webkit-box;
"><div id="delete" data-value="' .  $row2['property_id'] . '">
    Delete
    </div>
    <div id="addimage" class="report" data-value="' .  $row['property_id'] . '">
    Delete Report
    </div>
    </div>
    </div>';
    echo $cardItems;
    }

   
}
?>
</div>
</div>



    </div>
   




</div></div>

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
   <div id="favorite_saved">
   
   </div>
   <div id="favorite_delivery">
   <div id="form">
       <h3>Are you sure that you would like to delete?</h3>
       <div style="
    display: inline-flex;
    margin: 0 auto;
    text-align: center;
    width: 100%;
">
           
           <div id="yes" data-value="0">Yes</div>
           <div id="no" onclick="$('#favorite_delivery').removeClass('active');">No</div>
       </div>
    </div>
   </div>
  
   <div id="delete_delivery">
   <div id="form">
       <h3>Are you sure that you would like to delete?</h3>
       <div style="
    display: inline-flex;
    margin: 0 auto;
    text-align: center;
    width: 100%;
">
           
           <div id="yes" data-value="0">Yes</div>
           <div id="no" onclick="$('#delete_delivery').removeClass('active');">No</div>
       </div>
    </div>
   </div>

   <div id="delete_report_delivery">
   <div id="form">
       <h3>Are you sure that you would like to delete?</h3>
       <div style="
    display: inline-flex;
    margin: 0 auto;
    text-align: center;
    width: 100%;
">
           
           <div id="yes" data-value="0">Yes</div>
           <div id="no" onclick="$('#delete_report_delivery').removeClass('active');">No</div>
       </div>
    </div>
   </div>

</body>

</head>
</html>