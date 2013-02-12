<?php
echo "<h1><center>";
include("dbconnect.php"); //make sure we connect to the database first
if(isset($_GET['ref']) && !empty($_GET['ref'])){
$ref = $_GET['ref'];
$query = "SELECT * FROM referer WHERE referer='$ref'";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
echo $row['referer'];
echo "<br>";
echo "Hits " . $row['count'];
} else {
echo "You didn't specify a referer";
echo "</center></h1>";
}
?>
