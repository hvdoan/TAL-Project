<h1 style="color: black; margin: 20px auto 0;">Parametres utilisateur</h1>
<div style="
    margin: 20px auto 0;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    width: 150px;
    height: 150px;
    background: #ababab;
    border-radius: 50%;
    overflow: hidden;">
    <?php if ($_SESSION['avatar'] != "") : ?>
        <img class="" src="data:<?= mime_content_type($_SESSION['avatar']) ?>>;base64, <?= $_SESSION['avatar'] ?>">
    <?php else : ?>
        <i class="fa-solid fa-user-astronaut"></i>
    <?php endif; ?>
</div>

<?php $this->includePartial("form", $user->getUserSettingForm()) ?>
<button class="btn btn-delete" style="margin-left: 50px; width: 240px; margin-top: 20px">Supprimer mon compte</button>
