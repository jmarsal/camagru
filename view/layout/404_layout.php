<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang ="fr">
	<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo isset($title_for_layout) ? $title_for_layout : 'Camagru';?>
	</title>
	<link href="https://fonts.googleapis.com/css?family=Cabin+Sketch|Cairo|Indie+Flower" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'AccueilStyle.css';?>" >
    <link rel="stylesheet" href="<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'404Style.css';?>">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>"/>
    </head>
	<body>
	<div class="container">
	</div>
	<div class="hero-unit">
		<?php echo $content_for_layout;?>
	</div>
	</body>
</html>