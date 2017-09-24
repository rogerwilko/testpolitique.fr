<?php session_start();
      echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<!DOCTYPE html>
<html>
    <head>
	
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="css/testpol.css" />
        
		<!-- <script  type="text/javascript" src="js/jquery-1.7.1.min.js"></script> -->
		<script  type="text/javascript" src="js/prototype.js"></script>
		<script  type="text/javascript" src="js/scriptaculous.js"></script>

        <title>testpolitique.fr : Situez-vous sur l'échiquier politique.</title>
		
		
		<!-- favicon -->
		
		<link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
		<link rel="manifest" href="/images/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/images/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		
		
		<!-- integration templated-monochromed -->
		
		<link href='http://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->

    </head>

    
    <body class="homepage">
        
        
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		
		<div id="header">
			<div class="container">
					
				<!-- Logo -->
					<div id="logo">
						<h1><a href="#">testpolitique.fr</a></h1>
						<span style="color: #2e2528;">Situez-vous sur l'échiquier politique.</span>
					</div>
				
				<!-- Nav -->
					<nav id="nav">
						<ul>
							
							<?php $pageName = basename($_SERVER['PHP_SELF']); ?>
						
							<li <?php if($pageName == "index.php") echo 'class="active"'; ?>><a href="index.php">Accueil</a></li>
							<li <?php if($pageName == "zetest.php" && !isset($_GET["light"])) echo 'class="active"'; ?>><a href="zetest.php">Test Complet</a></li>
							<li <?php if($pageName == "zetest.php"&& isset($_GET["light"])) echo 'class="active"'; ?>><a href="zetest.php?light">Test Light</a></li>
							<li <?php if($pageName == "liens.php") echo 'class="active"'; ?>><a href="liens.php">Liens</a></li>
							<li <?php if($pageName == "contacts.php") echo 'class="active"'; ?>><a href="contacts.php">Contacts</a></li>
						</ul>
					</nav>

			</div>
		</div>

        
        <!--<div class="page">-->
		
		<div id="main">
			<div class="container">
        
        <!--<div class="logodiv">
			<a href="/"><img class="logo" src="img/logo.png" alt="logo" /></a>
		</div>
		
		<center><a href="https://play.google.com/store/apps/details?id=com.highway2game.gazelle" target="_blank" style="font-size: 12px;">[ Essayez notre application mobile Gazelle, le réseau social des histoires interactives ! ]</a><br /><br /></center>
       -->
