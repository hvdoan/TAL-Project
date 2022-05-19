<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Configuration</title>
        <!-- CSS -->
        <link rel="stylesheet" href="../Stylesheet/style.css">
        <!-- FONT AWESOME -->
        <script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- JS -->
        <script src="../JS/main.min.js"></script>
    </head>

    <body class="body-row">
        <?php \App\Core\Notification::displayNotifications(); ?>
        <?php include "View/" . $this->view . ".view.php"; ?>
    </body>
</html>