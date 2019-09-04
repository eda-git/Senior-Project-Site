<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<script>
    window.location = "login.php";

</script>';
}else{
    include('conn.inc');
    $username = htmlspecialchars($_SESSION['username']);
    $propertyid = $_GET['property_id'];
    $query1 = 'insert into favorites values ("' . $username . '", "' . $_GET['property_id'] . '")';
    $result = mysqli_query($con,  $query1);
}
?>
<div id="favorite">
Favorite Saved
</div>