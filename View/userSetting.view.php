<style>
    h1 {
        color: black;
        margin: 20px auto 0;
    }

    .user {
        margin: 20px auto 0;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        width: 150px;
        height: 150px;
        background: #dcdcdc;
        border-radius: 50%;
        overflow: hidden;
        border: 1px solid #a7a7a7;
    }

    .user:hover {
        background-color: #2f2d2d;
        cursor: pointer;
    }

    i {
        font-size: 5rem;
    }
</style>

<h1>Parametres utilisateur</h1>
<div class="user">
    <?php if ($_SESSION['avatar'] != "") : ?>
        <img class="" src="data:<?= mime_content_type($_SESSION['avatar']) ?>>;base64, <?= $_SESSION['avatar'] ?>">
    <?php else : ?>
        <i class="fa-solid fa-user-astronaut"></i>
    <?php endif; ?>
</div>

<?php $this->includePartial("form", $user->getUserSettingForm()) ?>
