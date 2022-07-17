<?php
$file = 'Template/Castle Story/style/CSS/style.json';
$style = null;
if (file_exists($file)) {
    $style = json_decode(file_get_contents($file), true);
}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title><?=WEBSITENAME?></title>
		<meta name="description" content="Description de ma page">
        <!-- CSS -->
        <link rel="stylesheet" href="Template/Castle Story/style/CSS/style.css">
        <link rel="stylesheet" type="text/css" href="Template/Castle Story/style/CSS/styleFront.php">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=<?=  $style['fonts']['pickerFont']['value'] ?>">
        <!-- FONT AWESOME -->
		<script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
        <!-- JQUERY -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- JS -->
        <script src="../../../JS/main.min.js"></script>
        <!-- Add icon library -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	
	<body>
		<?php
			use App\Core\Notification;
			use App\Core\Verificator;
			
			Notification::displayNotifications();
		?>
		
		<nav class="nav-ctn-row">
			<header>
				<a href="/home"><img src="Template/Castle Story/asset/img/<?= $style['images']['pickerImage']['value'] ?>" alt="logo"></a>
			</header>
			
			<div class="nav">
				<ul>
					<a class="btn" href="/presentation">Game</a>
					<a class="btn" href="/rating">Avis</a>
					<a class="btn" href="/galerie">Galerie</a>
					<a class="btn" href="/forum-list">Forums</a>
					<a class="btn" href="/faq">FAQ</a>
					<a class="btn" href="/donation">Donation</a>
					
					
          
            <?php if($this->data["isConnected"]):?>
                <label class="avatar" for="trigger-user-menu">
                    <div id="avatar-container">
                        <?php if($_SESSION['avatar'] != "") : ?>
                            <img class="icon" src="data:<?=mime_content_type($_SESSION['avatar'])?>>;base64, <?=$_SESSION['avatar']?>" alt="avatar">
                        <?php else : ?>
                            <i class="icon fa-solid fa-user-astronaut"></i>
                        <?php endif; ?>
                    </div>
                </label>

                <input id="trigger-user-menu" type="checkbox" name="trigger-user-menu">

                <div id="user-menu">
                    <a href="/user-setting">Paramètre</a>
	                
	                <?php if($this->data["isConnected"] && isset($_SESSION['permission']) && !empty($_SESSION['permission']) && in_array("ADMIN_ACCESS", $_SESSION['permission'])): ?>
	                <a href="/dashboard">Dashboard</a>
	                <?php endif; ?>
	                
                    <a class="red" href="/logout">Déconnexion</a>
                </div>
					<?php else: ?>
						<a class="btn" href="/login">Connexion</a>
						<a class="btn" href="/register">Inscription</a>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
		
		<?php include "Template/Castle Story/View/" . $this->view . ".view.php"; ?>
	
	</body>
</html>