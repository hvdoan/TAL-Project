<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Dashboard - <?=str_replace("/", "", $_SERVER["REQUEST_URI"])?></title>
		<link rel="stylesheet" href="../CSS/dist/main.css">
		<script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="../CSS/dist/main.js"></script>
		<!--datatables-->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
	</head>
	
	<body class="body-row">
		
		<nav id="nav">
			<header>
				<h1>TAL Project</h1>
				<i id="trigger-nav" class="fa-solid fa-bars"></i>
			</header>
			
			<ul class="nav nav--column">
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/statistics" || $_SERVER["REQUEST_URI"] == "/edit") ? "" : "close";?>">
					<i class="fa-solid fa-table-columns"></i>Tableau de bord<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/statistics")? "opened" : "" ;?>" href="#">Statistiques</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/edit")? "opened" : "" ;?>" href="#">Edition</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/usermanagement" || $_SERVER["REQUEST_URI"] == "/adduser") ? "" : "close";?>">
					<i class="fa-solid fa-user"></i>Gestion des utilisateurs<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/usermanagement")? "opened" : "" ;?>" href="/usermanagement">Tous les utilisateurs</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/adduser")? "opened" : "" ;?>" href="#">Ajout Utilisateur</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/pagemanagement" || $_SERVER["REQUEST_URI"] == "/addpage") ? "" : "close";?>">
					<i class="fa-solid fa-images"></i>Pages<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/pagemanagement")? "opened" : "" ;?>" href="#">Gestions des pages</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/addpage")? "opened" : "" ;?>" href="#">Ajout de page</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/images" || $_SERVER["REQUEST_URI"] == "/videos" || $_SERVER["REQUEST_URI"] == "/sounds") ? "" : "close";?>">
					<i class="fa-solid fa-film"></i>Médias<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/images")? "opened" : "" ;?>" href="/images">Images</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/videos")? "opened" : "" ;?>" href="/videos">Vidéos</a>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/sounds")? "opened" : "" ;?>" href="/sounds">Sons</a>
					</ul>
				</li>
				
				<li class="nav-section <?php echo ($_SERVER["REQUEST_URI"] == "/comments") ? "" : "close";?>">
					<i class="fa-solid fa-gear"></i>Modération<i class="fa-solid fa-angle-down"></i>
					<ul>
						<a class="btn <?php echo ($_SERVER["REQUEST_URI"] == "/comments")? "opened" : "" ;?>" href="/comments">Commentaires</a>
					</ul>
				</li>
				
				<a class="btn bottom" href="#"><span>Déconnexion</span><i class="fa-solid fa-power-off"></i></a>
			</ul>
		</nav>
		
		<main class="dashboard">
			<header>
				<div class="searchBar">
					<input type="text" name="searchBar" , placeholder="Recherche">
					<i class="fa-solid fa-magnifying-glass"></i>
				</div>
			</header>
			
			<?php include "View/" . $this->view . ".view.php"; ?>
		
		</main>
	</body>
</html>