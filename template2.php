<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
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
<div id="content">
<div id="members">

<div id="contents">
<div><h2>Hi <?php echo htmlspecialchars($_SESSION['username']); ?></h2></div>
<div class="addnewproperty"><a href="add.php">Add a Property</a></div>
<div class="align left">
    <h3>My Properties</h3>
    <div class="properties"><?php
include('conn.inc');

$query = "select * from listing where id = '" . htmlspecialchars($_SESSION['username']) . "'
";

$result = mysqli_query($con,  $query);
while($row = mysqli_fetch_array($result))
{
$cardItems = $cardItems . '<div id="homeItem"><a href="home.php?home=' . $row['property_id'] . '"><div id="item"> <div id="photo"> </div> <div id="cost"> ' . $row['cost'] . ' ' . $row['LONG'] . ' ' . $row['LAT'] . ' </div> <div id="description">' . $row['bed'] . ' Beds, ' . $row['bath'] . ' Baths, ' . $row['sqft'] . ' Square Feet</div> <div id="address">' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zipcode'] . '</div> </div></a>
<div id="delete">
Delete
</div>

</div>';
}

echo $cardItems;
?>
</div>
    </div>
<div class="align left">
    <h3>Saved Searches</h3>
    <div>Lorem Ipsum</div>
    </div>
<div class="align left">
    <h3>Account Settings</h3>
    <div>Lorem Ipsum</div>
    </div>
</div></div></div>

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