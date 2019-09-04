<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<html>
<head>
<script type="text/javascript">
function closeWindow() {
setTimeout(function() {
window.close();
}, 3000);
}

//window.onload = closeWindow();
</script>
<body>
<?php
include('conn.inc');

$query ="delete from attributes where property_id = '" . $_GET['delete'] ."'";
$result = mysqli_query($con,  $query);
$query ="delete from listing where property_id = '" . $_GET['delete'] ."'";
$result = mysqli_query($con,  $query);

?>
</body>