<?php
//YOU MUST SET THE VARIABLES BELOW OR IT WONT WORK
$hostname = '';
$username = '';
$password = '';
$con = mysql_connect($hostname,$username,$password);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

if (mysql_query("CREATE DATABASE FileDownloads",$con))
  {
  echo "Database created";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

mysql_select_db("FileDownloads", $con);

$sql = "CREATE TABLE downloadkey
(
uniqueid varchar(255) NOT NULL default '',
timestamp varchar(255) NOT NULL default '',
filename varchar(255) NOT NULL default '',
downloads varchar(255) NOT NULL default '0',
)";

mysql_query($sql,$con);

mysql_close($con);
echo "WARNING YOU MUST REMOVE THIS FILE OR SUFFER THE CONSEQUINCES!!!"
?>
