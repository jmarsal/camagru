<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang ="fr">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
	    <title><?php echo isset($title_for_layout) ? $title_for_layout : 'Camagru';?></title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch|Cairo|Indie+Flower" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"/>
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'AccueilStyle.css';?> />
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'404Style.css';?> />
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'colors.css';?> />
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'form.css';?> />
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'AppStyle.css';?> />
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'galerie.css';?> />
        <link rel="icon" type="image/png" href="<?php echo BASE_URL.DS.'webroot'.DS.'images'.DS.'logo'.DS."logo.png";?>"/>
	</head>
	<body id="demo">
        <div class="site-container">
            <div class="site-pusher">
                <header class="header">
                    <a href="#" class="header__icon" id="header__icon" onclick="showhide()"></a>
                    <a class="header__logo" href="#">CAMAGRU</a>
                    <nav class="menu">
                        <a href="appCamagru">Studio</a>
                        <a href="galerieCamagru">Galerie</a>
                        <a href="../">Delog</a>
                    </nav>
                </header>
                <div class="post">
                    <?php echo $content_for_layout;?>
                </div>
                <div class="site-cache" id="site-cache" onclick="showhide()"></div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'oXHR.js';?>" ></script>
        <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'video.js';?>" ></script>
        <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'filters.js';?>" ></script>
        <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'objets-filter.js';?>" ></script>
        <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'ajaxApp.js';?>" ></script>
        <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'menu.js';?>" ></script>
    </body>
</html>