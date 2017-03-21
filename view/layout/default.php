<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang ="fr">
	<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo isset($title_for_layout) ? $title_for_layout : 'Camagru';?>
	</title>
	<link rel="stylesheet" href="<?php echo BASE_URL.DS.'webroot'.DS.'css'.DS.'base.css';?>" >
	</head>
	<body>
		<div class="topbar">
			<div class="topbar-inner">
			<div class="container">
				<h3><a href="<?php echo BASE_URL ?>">Logout</a></h3>
				<ul class="nav">
					<li><a href="#" title="">Ma Deuxieme page</a></li>
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
	</body>
</html>