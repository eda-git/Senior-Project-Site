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

    $propertyid = $_GET['property_id'];
    $query1 = 'insert into report values ("' . $_GET['property_id'] . '", now())';
    $result = mysqli_query($con,  $query1);
}
?>
<div id="favorite">
Reported
</div>