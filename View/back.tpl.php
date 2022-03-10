<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Back</title>
        <link rel="stylesheet" href="../CSS/dist/main.css">
        <link rel="stylesheet" href="../CSS/dist/jquery.dataTables.min.css">
        <script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../CSS/dist/main.js"></script>
        <script src="../CSS/dist/jquery.dataTables.min.js"></script>
    </head>

    <body class="body-row">
        <nav id="nav">
            <header>
                <h1>TAL Project</h1>
                <i id="trigger-nav" class="fa-solid fa-bars"></i>
            </header>

            <ul class="nav nav--column">
                <li class="nav-section close"><i class="fa-solid fa-table-columns"></i>Tableau de bord<i class="fa-solid fa-angle-down"></i>
                    <ul>
                        <a class="btn opened" href="#">Statistiques</a>
                        <a class="btn opened" href="#">Edition</a>
                    </ul>
                </li>

                <li class="nav-section close" id="actuallyOpenedLi"><i class="fa-solid fa-user"></i>Gestion des utilisateurs<i class="fa-solid fa-angle-down"></i>
                    <ul>
                        <a class="btn opened" id="actuallyOpenedA" href="#">Tous les utilisateurs</a>
                        <a class="btn opened" href="#">Ajout Utilisateur</a>
                    </ul>
                </li>

                <li class="nav-section close"><i class="fa-solid fa-images"></i>Pages<i class="fa-solid fa-angle-down"></i>
                    <ul>
                        <a class="btn opened" href="#">Gestions des pages</a>
                        <a class="btn opened" href="#">Ajout de page</a>
                    </ul>
                </li>

                <li class="nav-section close"><i class="fa-solid fa-film"></i>Médias<i class="fa-solid fa-angle-down"></i>
                    <ul>
                        <a class="btn opened" href="#">Images</a>
                        <a class="btn opened" href="#">Vidéos</a>
                        <a class="btn opened" href="#">Sons</a>
                    </ul>
                </li>

                <li class="nav-section close"><i class="fa-solid fa-gear"></i>Modération<i class="fa-solid fa-angle-down"></i>
                    <ul>
                        <a class="btn opened" href="#">Commentaires</a>
                    </ul>
                </li>

                <a class="btn opened bottom" href="/logout"><span>Déconnexion</span><i class="fa-solid fa-power-off"></i></a>
            </ul>
        </nav>

        <main class="dashboard">
            <header>
                <div class="searchBar">
                    <input type="text" name="searchBar", placeholder="Recherche">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </header>

            <?php include "View/".$this->view.".view.php"; ?>
        </main>
    </body>
</html>
