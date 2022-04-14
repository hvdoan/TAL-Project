<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Template FRONT</title>
        <meta name="description" content="Description de ma page">
        <link rel="stylesheet" href="../CSS/dist/main.css">
        <script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../CSS/dist/main.js"></script>
    </head>

    <body>
        <?php \App\Core\Notification::displayNotifications(); ?>

        <nav class="nav-ctn-row">
            <header>
                <img src="./../CSS/asset/img/logo.png" alt="logo">
            </header>

            <div class="nav">
                <ul>
                    <a class="btn" href="userManagement.Template.html">Game</a>
                    <a class="btn" href="form.template.html">News</a>
                    <a class="btn" href="#">About</a>
                    <a class="btn" href="#">Forum</a>
                    <a class="btn" href="#">Wiki</a>
	                
	                <?php if((isset($_SESSION['permission']) && !empty($_SESSION['permission'])) ? in_array("ADMIN_ACCESS", $_SESSION['permission']) : false):?>
		                <a class="btn" href="/dashboard">Dashboard</a>
	                <?php endif;?>
	                <?php if((isset($_SESSION['id']) && !empty($_SESSION['token']) && isset($_COOKIE['token'])) ? ($_SESSION['token'] === $_COOKIE['token']) : false):?>
		                <a class="btn" href="/logout">Déconnexion</a>
	                <?php else:?>
		                <a class="btn" href="/login">Connexion</a>
		                <a class="btn" href="/register">Inscription</a>
	                <?php endif;?>
                </ul>
            </div>
        </nav>
	    
        <?php include "View/".$this->view.".view.php"; ?>

    </body>
</html>