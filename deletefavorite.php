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
location.reload();

</script>
<body>
<?php
include('conn.inc');
$delete = $_GET['delete'];
$username = htmlspecialchars($_SESSION['username']);
$query = 'delete from favorites where property_id = "'. $delete .'" and id = "'. $username .'";';
echo $query;
$result = mysqli_query($con,  $query);


?>
</body>