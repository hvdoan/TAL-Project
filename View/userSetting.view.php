
<div class="userSetting">
    <h1 class="userSettingTitle">Parametres utilisateur</h1>
    <div class="content">
        <div class="user">
            <?php if ($_SESSION['avatar'] != "") : ?>
                <img class="avatarParam" src="data:<?= mime_content_type($_SESSION['avatar']) ?>>;base64, <?= $_SESSION['avatar'] ?>">
            <?php else : ?>
                <i class="fa-solid fa-user-astronaut"></i>
            <?php endif; ?>
        </div>

        <?php $this->includePartial("form", $user->getUserSettingForm()) ?>
    </div>
</div>
