<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Dashboard - <?=str_replace("/", "", $_SERVER["REQUEST_URI"])?></title>
        <!-- CSS -->
		<link rel="stylesheet" href="../Stylesheet/style.css">
        <!-- FONT AWESOME -->
		<script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
        <!-- JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- JS -->
        <script src="../JS/main.min.js"></script>
		<!-- datatables -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
	</head>
	
	<body class="body-row">
		
		<nav id="nav">
			<header>
				<a href="/home"><h1><?=WEBSITENAME?></h1></a>
				<i id="trigger-nav" class="fa-solid fa-bars"></i>
			</header>
			
			<ul class="nav nav--column">
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/dashboard" || $_SERuglVER["REQUEST_URI"] == "/edit") ? "" : "close"; ?>">
					<i class="fa-solid fa-table-columns"></i>Tableau de bord<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/dashboard") ? "opened" : ""; ?>" href="/dashboard">Statistiques</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/edit") ? "opened" : ""; ?>" href="#">Edition</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/user-management" || $_SERVER["REQUEST_URI"] == "/role-management") ? "" : "close"; ?>">
					<i class="fa-solid fa-user"></i>Gestion des utilisateurs<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/user-management") ? "opened" : ""; ?>" href="/user-management">Tous les utilisateurs</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/role-management") ? "opened" : ""; ?>" href="/role-management">Tous les rôles</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/page-management" || $_SERVER["REQUEST_URI"] == "/page-creation") ? "" : "close"; ?>">
					<i class="fa-solid fa-images"></i>Pages<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/page-management") ? "opened" : ""; ?>" href="/page-management">Gestions des pages</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/page-creation") ? "opened" : ""; ?>" href="/page-creation">Ajout de page</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/images" || $_SERVER["REQUEST_URI"] == "/videos" || $_SERVER["REQUEST_URI"] == "/sounds") ? "" : "close"; ?>">
					<i class="fa-solid fa-film"></i>Médias<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/images") ? "opened" : ""; ?>" href="/images">Images</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/videos") ? "opened" : ""; ?>" href="/videos">Vidéos</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/sounds") ? "opened" : ""; ?>" href="/sounds">Sons</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/palier-donation") ? "" : "close"; ?>">
					<i class="fa-solid fa-film"></i>Donation<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/palier-donation") ? "opened" : ""; ?>" href="/palier-donation">Paliers de donation</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/comments") ? "" : "close"; ?>">
					<i class="fa-solid fa-gear"></i>Modération<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/comments") ? "opened" : ""; ?>" href="/comments">Commentaires</a>
					</ul>
				</li>
				
				<a class="btn bottom" href="/logout" "><span>Déconnexion</span><i class="fa-solid fa-power-off"></i></a>
			</ul>
		</nav>
		
		<main class="dashboard">
			<header>
				<div class="searchBar">
					<input type="text" name="searchBar", placeholder="Recherche">
					<i class="fa-solid fa-magnifying-glass"></i>
				</div>
			</header>
			
			<?php include "View/" . $this->view . ".view.php"; ?>
		
		</main>
	</body>
</html>
