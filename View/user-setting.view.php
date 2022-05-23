<h1 style="color: black">Parametres utilisateur</h1>
<div>
    <img class="icon" src="data:<?= mime_content_type($_SESSION['avatar']) ?>>;base64, <?= $_SESSION['avatar'] ?>">
</div>

<?php $this->includePartial("form", $user->getUserSettingForm()) ?>

