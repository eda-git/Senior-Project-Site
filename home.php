<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
<title>PropertyVillage</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href='./css/default1.css' rel='stylesheet' />

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
<div id="content" class="house">
<?php
include('conn.inc');
include('dollar.php');

$nameHolder = "";
$query = "select * from listing inner join attributes where listing.property_id = '" . $_GET['home']  . "' and attributes.property_id  = '" . $_GET['home']  . "';";
$result = mysqli_query($con,  $query);
while($row = mysqli_fetch_array($result))
{
    if(strcmp($row['pet_friendly'], "1") == "0"){
        $pet = "Yes";
    }else{
        $pet = "No";
    }
    if(strcmp($row['popcorn_ceiling'], "1") == "0"){
        $pop = "Yes";
    }else{
        $pop = "No";
    }
    if(strcmp($row['smoker_friendly'], "1") == "0"){
        $smoke = "Yes";
    }else{
        $smoke = "No";
    }

    $money = floatval($row['cost']);
    $money = dollar_func($money);
   $nameHolder = $nameHolder . $row["address"];
   echo '<div id="housing_details"><div id="housing_information">
    <div id="housing_photo" style="background: url(img/' . $_GET['home'] . '.png) no-repeat center, #001; background-size: 100%;">
    </div>
    <div class="details"><h3 style="
font-size: 1.4em;
">' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zipcode']  .  '</h3>
<h3 style="
font-size: 1.4em;
">' . $money  .  '</h3>
<p style="
font-size: 1.4em;
">' . html_entity_decode($row['description']) .  '</p>
<div>
<div class="housing_information_items">
<span class="header">Property Type</span>
<span class="content">' . $row['property_type'] .  '</span>
</div>
    
    <div class="housing_information_items">
        <span class="header">Style</span>
        <span class="content">' . $row['story'] .  ' Story, ' . $row['style'] .  '</span>
    </div>
        <div class="housing_information_items">
            <span class="header">Pet Friendly</span>
            <span class="content">' .  $pet .  '</span>
        </div>
        <div class="housing_information_items">
        <span class="header">Popcorn Ceiling</span>
        <span class="content">' . $pop .  '</span>
    </div>
    <div class="housing_information_items">
    <span class="header">Smoker Friendly</span>
    <span class="content">' . $smoke .  '</span>
</div>
<div class="housing_information_items">
<span class="header">Condition</span>
<span class="content">' . $row['condition'] .  '</span>
</div>
       
        <div class="housing_information_items">
            <span class="header">Built</span>
            <span class="content">' . $row['built'] .  '</span>
        </div>
        </div>
        <div id="housing_controls">
    <button class="button favorite" data-value="' . $_GET['home'] . '">Favorite</button>
    <button class="button share" data-value=""><a href="home.php?property_id="' . $_GET['share'] . '">Share</a></button>

    <button class="button report" data-value="' . $_GET['home'] . '">Report</button>
    <i class="far fa-times-circle" onclick="$(\'#ajax_delivery\').removeClass(\'active\');" style="cursor: pointer"></i>
</div>
    </div>
    
<div>
</div>';

}
$GLOBALS["name"] = $nameHolder;
?>
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
</body>
</head>
</html>