
<style>
    body
    {
        overflow: hidden;
    }

    .form {
        height: 40vh;
        margin: 50vh auto 0;
        transform: translateY(-50%);
    }

    body:before
    {
        content: "";
        position: absolute;
        bottom: 10%;
        width: 1000px;
        height: 2000px;
        background: #E2E5EC;
        transform: rotate(60deg);
        z-index: -1;
    }

    body:after
    {
        content: "";
        position: absolute;
        left: 20%;
        top: 40%;
        width: 1000px;
        height: 2000px;
        transform:rotate(65deg);
        background: #E2E5EC;
        z-index: -1;
    }

    .mdpForget {
        margin: 20px auto;
        color: white;
        text-decoration: none;
    }

    .mdpForget:hover {
        text-decoration: underline;
    }

</style>


<div class="form">
    <h1>Réinitialisation Mot de passe</h1>
    <?php $this->includePartial("form", $user->getPwdForget()) ?>
</div>