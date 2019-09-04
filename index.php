<?php
// Initialize the session
session_start();
include('conn.inc');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<title>PropertyVillage</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href='./css/default1.css' rel='stylesheet' />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

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


        $("div#cards a").click(function(){
    var val = $(this).data("value");
    var loadUrl = "ajaxhome.php?home=" + val;
    $("#ajax_delivery").load(loadUrl);
    $('#ajax_delivery').addClass('active');
})

		
    $("#loadBasic").click(function(){
        
    });
});
</script>
<body>
<header>
<a href="index.php" class="logohref"><div id="logo">Property<span>Village</span></div></a>
<div id="item" class="search">
        <form action="search.php" method="get">
<input type="text" name="term"><input type="submit">
</form>
    </div>
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
<div id="content">
    <h2 style="">Cities</h2>
    <div id="section" class="subject"  style="">
    <a id="homeItem" href="search.php?term=Seattle">
<div id="item">
        <div id="photo" class="seattle">
        </div>
        <div id="caption">
        Seattle
        </div>
    </div>
    </a>
    <a id="homeItem" href="search.php?term=Tacoma">

    <div id="item">
        <div id="photo" class="tacoma">
        </div>
        <div id="caption">
        Tacoma
        </div>
    </div>
    </a>
    <a id="homeItem" href="search.php?term=Portland">
    <div id="item">
        <div id="photo" class="portland">
        </div>
        <div id="caption">
        Portland
        </div>
    </div>
    </a>
    <a style="display:none" id="homeItem" href="search.php?term=San Francisco">
    <div id="item">
        <div id="photo" class="sanfrancisco">
        </div>
        <div id="caption">
        San Francisco
        </div>
    </div>
    </a>
    <a style="display:none" id="homeItem" href="search.php?term=Los Angeles">
    <div id="item">
        <div id="photo" class="losangeles">
        </div>
        <div id="caption">
        Los Angeles
        </div>
    </div>
    </a>
    <a style="display:none" id="homeItem" href="search.php?term=San Diego">
    <div id="item">
        <div id="photo" class="sandiego">
        </div>
        <div id="caption">
        San Diego
        </div>
    </div>
    </a>
    </div>

<?php

$query2 = "select * from listing order by created_at desc LIMIT 5";
$result2 = mysqli_query($con,  $query2);
echo ' <div class="align left">
<h3>Five Most Recent Properties</h3>
<div>
<div class="properties">
<div id="cards">';
while($row2 = mysqli_fetch_array($result2))
{
echo '<div id="homeItem">';

$bed = floatval($row2['bed']);
$bath = floatval($row2['bath']);

$cardItems = $cardItems . '<a href="#" data-value="' .  $row2['property_id'] . '"><div id="item" style="background-size: cover; background: url(img/' . $row2['property_id']  . '.png) no-repeat center, #c9c9c9;"> <div id="photo"> </div> 
<div id="cost"> ' . $cost  . ' </div> <div id="description">' . $bed . ' Beds, ' . $bath . ' Baths, ' . $row2['sqft'] . ' Square Feet</div> <div id="address">' . 
$row2['address'] . ', ' . $row2['city'] . ', ' . $row2['state'] . ', ' . $row2['zipcode'] . '</div> </div></a>';

}
echo $cardItems;
echo '</div>';
    echo ' </div></div>
    </div>
    </div></div>'; 

?>
   
    <?php 
 
    
    echo '
    <div class="align left" style="display: none;">
    <h3>Favorites</h3>
    <div>
    <div class="properties">
    <div id="cards">';

    $query = "select * from favorites where id = '" . htmlspecialchars($_SESSION['username']) . "'
    ";
    $result = mysqli_query($con,  $query);
    while($row = mysqli_fetch_array($result))
    {
        $query2 = "select * from listing where property_id = '" . $row['property_id']. "'";
        $result2 = mysqli_query($con,  $query2);
        while($row2 = mysqli_fetch_array($result2))
        {
       echo '<div id="homeItem">';
    
       $bed = floatval($row2['bed']);
       $bath = floatval($row2['bath']);

       $cardItems = '<a href="#" data-value="' .  $row2['property_id'] . '"><div id="item" style="background-size: cover; background: url(img/' . $row2['property_id']  . '.png) no-repeat center, #c9c9c9;"> <div id="photo"> </div> 
<div id="cost"> ' . $cost  . ' </div> <div id="description">' . $bed . ' Beds, ' . $bath . ' Baths, ' . $row2['sqft'] . ' Square Feet</div> <div id="address">' . 
$row2['address'] . ', ' . $row2['city'] . ', ' . $row2['state'] . ', ' . $row2['zipcode'] . '</div> </div></a>';
echo $cardItems;
        echo '</div>';
        }
        
    }
    
    echo ' </div></div>
    </div>
    </div></div>
    </div>'; 
    

    ?>
   
</div>
<div id="subsection">
</div>

<div id="footer">
    <div id="sitemap">
    </div>
    <div id="bottom_menu">
    </div>
    </div>

</div>
</div>
<div id="ajax_delivery">
   
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
</body>
</head>
</html>