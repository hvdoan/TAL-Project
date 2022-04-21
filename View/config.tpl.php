<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Configuration</title>
        <link rel="stylesheet" href="../CSS/dist/main.css">
        <script src="https://kit.fontawesome.com/62e5467ba7.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../CSS/dist/main.js"></script>
    </head>

    <body class="body-row">
        <?php \App\Core\Notification::displayNotifications(); ?>
        <?php include "View/" . $this->view . ".view.php"; ?>
    </body>
</html>