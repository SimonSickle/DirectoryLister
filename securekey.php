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

// Redirect to the download
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=download.php?id=' . $key . '">';
//show HTML below for 5 seconds
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
<p> <?php echo "downloading: " . $file . " Redirecting in 10 seconds"; ?> </p>
<p>Click here if you are not redirected automatically in 10 seconds<br/>
            <a href="<?php echo $_SERVER['REQUEST_URI']; ?>">Get More Files</a>.
</p>
</body>
</html>
