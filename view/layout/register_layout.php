<?php
	if (isset($_SESSION['loged']) && $_SESSION['loged'] === 1){
		$_SESSION['loged'] = 0;}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang ="fr">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <link rel="icon" type="image/png" href="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>"/>
        <title><?php echo isset($title_for_layout) ? $title_for_layout : 'Camagru';?></title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch|Cairo|Indie+Flower" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'accueilStyle.css';?> >
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'404Style.css';?> >
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'registerStyle.css';?> >
    </head>
	<body>
	<div class="container">
        <div class="accueil_form" id="accueil_form">
            <div class="containerForm">
                <?php echo $content_for_layout;?>
            </div>
        </div>
    </div>
    <div class="footer" id="footer"></div>
    <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'oXHR.js';?>" ></script>
    <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'popup.js';?>" ></script>
    <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'accueilAjax.js';?>" ></script>
    <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'registerAjax.js';?>" ></script>
    <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'forgetIdAjax.js';?>" ></script>
	</body>
</html>