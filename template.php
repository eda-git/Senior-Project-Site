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
    <h2>Cities</h2>
    <div id="section" class="subject">
    <div id="item">
        <div id="photo" class="seattle">
        </div>
        <div id="caption">
        Seattle
        </div>
    </div>
    <div id="item">
        <div id="photo" class="spokane">
        </div>
        <div id="caption">
        Spokane
        </div>
    </div>
    <div id="item">
        <div id="photo" class="portland">
        </div>
        <div id="caption">
        Portland
        </div>
    </div>
    <div id="item">
        <div id="photo" class="sanfrancisco">
        </div>
        <div id="caption">
        San Francisco
        </div>
    </div>
    <div id="item">
        <div id="photo" class="losangeles">
        </div>
        <div id="caption">
        Los Angeles
        </div>
    </div>
    <div id="item">
        <div id="photo" class="sandiego">
        </div>
        <div id="caption">
        San Diego
        </div>
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