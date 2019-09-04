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
    <div id="housing_photo">
    </div>
    <div class="details"><h3 style="
font-size: 1.4em;
">' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zipcode']  .  '</h3>
<h3 style="
font-size: 1.4em;
">' . $money  .  '</h3>
<p style="
font-size: 1.4em;
">' . $row['description'] .  '</p>
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
    <button class="button favorite">Favorite</button>
    <button class="button login">Share</button>
</div>
    </div>
    
<div>
</div>';

}
$GLOBALS["name"] = $nameHolder;
?>