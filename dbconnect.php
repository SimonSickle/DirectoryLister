<?php
$host = 'localhost';
$user = 'root';
$password = '';

// Connect to database "download" using: dbname , username , password
	$link = mysql_connect($host, $user, $password) or die("Could not connect: " . mysql_error());
	mysql_select_db("FileDownloads") or die(mysql_error());
?>
