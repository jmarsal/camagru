<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang ="fr">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo isset($title_for_layout) ? $title_for_layout : 'Camagru';?>
	</title>
	<link rel="stylesheet" href=<?php echo $cssDir;?> >
	</head>
	<body>
		<div class="topbar">
			<div class="topbar-inner">
			<div class="container">
				<h3><a href="#">Camagru</a></h3>
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
			<?php echo $content_for_layout;
?>
		</div>
	</body>
</html>