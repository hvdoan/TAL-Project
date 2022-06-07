<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Template FRONT</title>
		<meta name="description" content="Description de ma page">
        <!-- CSS -->
        <link rel="stylesheet" href="../Stylesheet/style.css">
        <!-- FONT AWESOME -->
		<script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
        <!-- JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- JS -->
        <script src="../JS/main.min.js"></script>
	</head>
	
	<body>
		<?php
			use App\Core\Notification;
			use App\Core\Verificator;
			
			Notification::displayNotifications();
		?>
		
		<nav class="nav-ctn-row">
			<header>
				<a href="/home"><img src="../SASS/asset/img/logo.png" alt="logo"></a>
			</header>
			
			<div class="nav">
				<ul>
					<a class="btn" href="#">Game</a>
					<a class="btn" href="#">News</a>
					<a class="btn" href="#">About</a>
					<a class="btn" href="/forum-list">Forums</a>
					<a class="btn" href="#">Wiki</a>
					<a class="btn" href="/donation">Donation</a>
					
					<?php if($this->data["isConnected"] && isset($_SESSION['permission']) && !empty($_SESSION['permission']) && in_array("ADMIN_ACCESS", $_SESSION['permission'])): ?>
						<a class="btn" href="/dashboard">Dashboard</a>
					<?php endif;
					
					if($this->data["isConnected"]):?>
						<a class="btn" href="/logout">Déconnexion</a>
					<?php else: ?>
						<a class="btn" href="/login">Connexion</a>
						<a class="btn" href="/register">Inscription</a>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
		
		<?php include "View/" . $this->view . ".view.php"; ?>
	
	</body>
</html>