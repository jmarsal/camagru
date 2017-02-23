<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang ="fr">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo isset($title_for_layout) ? $title_for_layout : 'Camagru';?></title>
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch|Cairo|Indie+Flower" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'AccueilStyle.css';?> >
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'404Style.css';?> >
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'button_flat.css';?> >
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'form.css';?> >
        <link rel="stylesheet" href=<?php echo BASE_URL.DS.'webroot'.DS.'css' .DS.'AppStyle.css';?> >
	</head>
	<body>
		<div class="topbar">
			<div class="topbar-inner">
			    <div class="container">
                    <div id="menu">
                        <ul id="onglets">
                            <li class="active"><a href="<?php echo 'logout'; ?>"> Accueil </a></li>
                            <li><a href=""> Application </a></li>
                            <li><a href=""> Galerie </a></li>
                            <li><a href=""> Mon compte </a></li>
                            <li><a href="<?php echo 'logout'; ?>"> Delog </a></li>
                        </ul>
                    </div>
                </div>
			</div>
		</div>
    	<div class="container">
	    </div>
        <div class="post">
			<?php echo $content_for_layout;?>
		</div>
        <script type="text/javascript" src="<?php echo BASE_URL.DS.'view'.DS.'js'.DS.'video.js';?>" ></script>
    </body>
</html>