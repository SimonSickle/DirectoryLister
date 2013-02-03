<?php
// A script to generate unique download keys for the purpose of protecting downloadable goods

require ('dbconnect.php');

	// Get the filename given by directory linker
	$file = $_GET["file"];

	if(empty($_SERVER['REQUEST_URI'])) {
    	$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
	}

	// Strip off query string so dirname() doesn't get confused
	$url = preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']);
	$folderpath = 'http://'.$_SERVER['HTTP_HOST'].'/'.ltrim(dirname($url), '/');


// Generate the unique download key
	$key = uniqid(md5(rand()));

// Get the activation time
	$time = date('U');

// Write the key and activation time to the database as a new row.
	$registerid = mysql_query("INSERT INTO downloadkey (uniqueid,timestamp,filename) VALUES(\"$key\",\"$time\",\"$file\")") or die(mysql_error());

// Create the filename
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>

<DOCUTYPE html>
<head>
<title> Sick Files </title>
<script type="text/javascript">
                    window.setTimeout(function() {
                        location.href = 'index.php';
                    }, 10000);
</script>
</head>
<body>
<p>
<center>
<?php
$filename = basename($file);
echo "<a href=\"$data\">$filename</a>";
echo "<br><br>";
$query = sprintf("SELECT * FROM md5sums WHERE filename= '$file'",
mysql_real_escape_string($id, $link));
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);
        if (!$row) {
                $registerid = mysql_query("INSERT INTO md5sums (filename,md5) VALUES(\"$file\",\"$md5\")") or die(mysql_error());
                $md5 = md5_file($file);
                echo "MD5: " . $md5;
        }else{
                echo "MD5: " . $row[md5];
}
echo "<br><br>"
echo "Redirecting in 10 seconds"; ?> </p>

<p>Click here if you are not redirected automatically in 10 seconds<br/>
            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>">Get More Files</a>.
</p>
<?php
// Redirect to the download
echo '<META HTTP-EQUIV="Refresh" Content="2; URL=download.php?id=' . $key . '">';
//show HTML below for 5 seconds
?>
</body>
</html>
