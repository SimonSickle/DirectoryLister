<?php 

$limit = 50; 
$seconds = 60;  
$block_for_seconds = 300;

$status = 'OK';

$memcache = new Memcache;
$memcache->connect('localhost', 11211);

$ip = $_SERVER['REMOTE_ADDR'];

$r = $memcache->get($ip, array('c', 't'));

$c = 1; // count
$init_time = time();
if($r) {
  $s = $r[3]; // status
  $c = $r[0]+1;
  $init_time = $r[1];
  if($s == 'TOO_MANY_REQUESTS') {
    $d = time()-$r[1]; // time since block
    if($block_for_seconds-$d > 0) {  // still blocked
      die('Flood detected!! You are going to wait '.($block_for_seconds-$d).' and try again.');
    } else {  // block is over
      $status = 'OK';
      $init_time = time();
      $c = 0;
    }
  }

  $new_time = time();
  if($c > $limit) {  // check if happened within a minute
    $time_elapsed = $new_time - $init_time;
    if($time_elapsed < $seconds) {  
      $status = 'TOO_MANY_REQUESTS'; 
    }
    print "time elapsed: $time_elapsed, count:$c";
    $c = 0;
    $init_time = time();
  }
}
$memcache->set($ip, array($c, $init_time, $new_time, $status) );

// Add referer program
require ('dbconnect.php');
if(isset($_GET['ref']) && !empty($_GET['ref'])){
    $ref = $_GET['ref'];
    mysql_query("UPDATE referer SET count = count + 1 WHERE referer = '".$ref."'$
} else {
}

?>

<!DOCTYPE html>
<head>
    <title>Directory listing of <?php echo $lister->getListedPath(); ?></title>
    <link rel="shortcut icon" href="<?php echo THEMEPATH; ?>/images/folder.png" />
    <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/style.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo THEMEPATH; ?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo THEMEPATH; ?>/directorylister.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>

<div class="container">
    <div class="breadcrumb-wrapper">
        <ul class="breadcrumb">
            <?php $divider = FALSE; foreach($lister->listBreadcrumbs() as $breadcrumb): ?>
            <li>
                <?php if ($divider): ?>
                    <span class="divider">/</span>
                <?php endif; ?>
                <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['text']; ?></a>
            </li>
            <?php $divider = TRUE; endforeach; ?>
            <li class="floatRight" style="display: hidden;">
                <a href="#" id="pageTopLink">Top</a>
            </li>
        </ul>
    </div>

    <?php if($lister->getSystemMessages()): ?>
        <?php foreach ($lister->getSystemMessages() as $message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['text']; ?>
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div id="header" class="clearfix">
        <span class="fileName">File</span>
        <span class="fileSize">Size</span>
        <span class="fileDownloads">Downloads</span>
		<span class="fileModTime">Last Modified</span>
    </div>

    <ul id="directoryListing">
    <?php $x = 1; foreach($lister->listDirectory() as $name => $fileInfo): ?>
        <li class="<?php echo $x %2 == 0 ? 'even' : 'odd'; ?>">
            <a href="<?php if(is_dir($fileInfo['file_path'])) { echo '?dir=' . $fileInfo['file_path']; } elseif($fileInfo['icon_class'] == 'icon-up-dir') { echo  $fileInfo['file_path']; } else { echo 'securekey.php?file='. $fileInfo['file_path']; } ?>" class="clearfix">
                <span class="fileName">
                    <i class="<?php echo $fileInfo['icon_class']; ?>">&nbsp;</i>
                    <?php echo $name; ?>
                </span>
                <span class="fileSize"><?php echo $fileInfo['file_size']; ?></span>
				<span class="fileDownloads"><?php echo $fileInfo['file_downloads']; ?></span>
				<span class="fileModTime"><?php echo $fileInfo['mod_time']; ?></span>
            </a>
        </li>
    <?php $x++; endforeach; ?>
    </ul>

    <div class="footer">
        <p> Downloads: <?php echo $lister->getTotalDownloads(); ?></p>
    </div>
</div>


</body>
</html>
