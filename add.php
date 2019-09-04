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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{     width: 22%;
    padding: 20px;
    background: #FFF;
    border-style: solid;
    margin: 0 auto;
    height: 73%;
    margin-top: 20px; }
    </style>
    <link href="./css/default.css" rel="stylesheet">
<body style="overflow: hidden; 
    background: url(./img/demo2.jpg) no-repeat 100% 63%;
    background-size: cover;">
    <div class="wrapper" style="width: 36%; height: 97%;">
    <a href="index.php" style="text-decoration: none; color: #000;"><div id="logo">Property<span>Village</span></div></a>
        <h2>Add a Property</h2>
        <p>Please fill in the information.</p>
        <form name="add" action="refine.php" method="post"  style="zoom:80%" target="_blank" onsubmit="return validateForm()">
            
        <div class="form-group">
                <label>Cost</label>
                <input type="text" name="cost" class="form-control">
            </div>
            <div class="form-group" >
            <div style="
    display: inline-flex;
    width: 100%;
">
<div style="    width: 75%;">
                <label>Address</label>
                <input type="text" name="address" class="form-control">
                </div>
                <div style="margin-left: 1em;">
                <label>Bldg/Apt/Unit Number</label>
                <input type="text" name="unit" class="form-control">
                </div>
            </div> 
            <div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" class="form-control">
            </div> 
            </div>
            
            <div class="form-group">
        <label>State</label>
        <select name="state">
    <option value="AL">Alabama</option>
    <option value="AK">Alaska</option>
    <option value="AZ">Arizona</option>
    <option value="AR">Arkansas</option>
    <option value="CA">California</option>
    <option value="CO">Colorado</option>
    <option value="CT">Connecticut</option>
    <option value="DC">District of Columbia</option>
    <option value="DE">Delaware</option>
    <option value="FL">Florida</option>
    <option value="GA">Georgia</option>
    <option value="GU">Guam</option>
    <option value="HI">Hawaii</option>
    <option value="ID">Idaho</option>
    <option value="IL">Illinois</option>
    <option value="IN">Indiana</option>
    <option value="IA">Iowa</option>
    <option value="KS">Kansas</option>
    <option value="KY">Kentucky</option>
    <option value="LA">Louisiana</option>
    <option value="ME">Maine</option>
    <option value="MD">Maryland</option>
    <option value="MA">Massachusetts</option>
    <option value="MI">Michigan</option>
    <option value="MN">Minnesota</option>
    <option value="MS">Mississippi</option>
    <option value="MO">Missouri</option>
    <option value="MT">Montana</option>
    <option value="NE">Nebraska</option>
    <option value="NV">Nevada</option>
    <option value="NH">New Hampshire</option>
    <option value="NJ">New Jersey</option>
    <option value="NM">New Mexico</option>
    <option value="NY">New York</option>
    <option value="NC">North Carolina</option>
    <option value="ND">North Dakota</option>
    <option value="OH">Ohio</option>
    <option value="OK">Oklahoma</option>
    <option value="OR">Oregon</option>
    <option value="PR">Puerto Rico</option>
    <option value="PA">Pennsylvania</option>
    <option value="RI">Rhode Island</option>
    <option value="SC">South Carolina</option>
    <option value="SD">South Dakota</option>
    <option value="TN">Tennessee</option>
    <option value="TX">Texas</option>
    <option value="UT">Utah</option>
    <option value="VT">Vermont</option>
    <option value="VA">Virginia</option>
    <option value="WA">Washington</option>
    <option value="WV">West Virginia</option>
    <option value="WI">Wisconsin</option>
    <option value="WY">Wyoming</option>
    </select>
            </div> 
            <div class="form-group">
                <label>Zipcode</label>
                <input type="text" name="zipcode" class="form-control">
            </div> 

      

            <div style="zoom: 90%;">
<div style="display: inline-flex; ">
            <div class="form-group">
                <label>Beds</label>
                <select name="beds">
                <option value="0">0</option>

    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">>=6</option>
    </select>
    <input type="checkbox" name="beddecimal" value="true">.5?
            </div>      

                        <div class="form-group" style="margin-left: 1em;">
                <label>Baths</label>
                <select name="baths">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">>=6</option>
    </select>
    <input type="checkbox" name="bathdecimal" value="true">.5?
            </div>      
            <div class="form-group" style="margin-left: 1em;">
                <label>Story</label>
                <select name="story">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">>=6</option>
    </select>

            </div>      
</div>


<div >
<div style="display: inline-flex; ">
            <div class="form-group">
                <label>Condition</label>
                <select name="condition">
    <option value="Excellent">Excellent</option>
    <option value="Great">Great</option>
    <option value="Good">Good</option>
    <option value="Bad">Bad</option>
    <option value="For Renovation">For Renovation</option>
    </select>
            </div>      

            <div class="form-group" style="margin-left: 1em;display: inline-flex;">
               <div> <label>Year Built</label>
                <input type="text" name="built" class="form-control" style="
    width: 85%;
"> </div>
    <div>
                <label>Heating</label><br>
                <select name="heating">
        <option value="Blown Air">Blown Air</option>

                <option value="Radiated">Radiated</option>
                <option value="Fireplace">Gas/Electrical Fireplace</option>


    <option value="Other">Other</option>
        </select> </div><div>
    <label>Flooring</label>
                <select name="flooring">
                <option value="Hardwood">Hardwood</option>

    <option value="Carpet">Carpet</option>
    <option value="Tile">Tile</option>

    <option value="Other">Other</option>
    </select>
            </div></div></div>


<div style="display: inline-flex;">


            <div class="form-group">
                <label>Type</label>
                <br>
                <input type="radio" name="type" value="1"> For Sale<br>
<input type="radio" name="type" value="2"> For Rent<br>
<input type="radio" name="type" value="3"> For Auction
            </div>      
            <div class="form-group" style="margin-left: 1em;">
                <label>Attributes</label>
                <br>
                <input type="checkbox" name="pet" value="true"> Pet Friendly<br>
<input type="checkbox" name="smoker" value="true"> Smoker Friendly <br>
<input type="checkbox" name="popcorn" value="true"> Popcorn Ceiling <br>
<input type="text" name="sqft" style="
    width: 5em;
">Total Square Feet in House
<br><input type="text" name="lot" style="
    width: 5em;
">Total Square Feet for whole Lot
<br>
        <select name="style">
    <option value="Apartment">Apartment</option>
    <option value="Cottage">Cottage</option>
    <option value="Condominium">Condominium</option>
    <option value="Craftsman">Craftsman</option>
    <option value="Colonial">Colonial</option>
    <option value="Cape Cod">Cape Cod</option>
    <option value="Contemporary">Contemporary</option>
    <option value="European">European</option>
    <option value="Farmhouse">Farmhouse</option>
    <option value="Gablefront">Gablefront</option>
    <option value="I-House">I-House</option>
    <option value="Mediterranean">Mediterranean</option>
    <option value="Modern">Modern</option>
    <option value="Prairie">Prairie</option>
    <option value="Ranch">Ranch</option>
    <option value="Spanish">Spanish</option>
    <option value="Townhouse">Townhouse</option>
    <option value="Tudor">Tudor</option>
    <option value="Victorian">Victorian</option>
    <option value="Other">Other</option>
    <option value="N/A">N/A</option>
    </select> Style
            
            </div>    
                  

</div>
<div class="form-group">
                <label>Description</label>
                <input type="text" name="description" class="form-control" maxlength="1000">
            </div> 
</div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add">
            </div></p>
        </form>
    </div>    
</body>
<script>
function validateForm() {
  var x = document.forms["add"]["city"].value;
  var y = document.forms["add"]["address"].value;
  var z = document.forms["add"]["zipcode"].value;
  if (x == "") {
    alert("City must be filled out");
    return false;
  }
  if (y == "") {
    alert("Address must be filled out");
    return false;
  }
  if (z == "") {
    alert("Zipcode must be filled out");
    return false;
  }
}
</script>
</head>
</html>