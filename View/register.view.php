
<style>

    .form {
        margin: 50px auto;
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

</style>

<div class="form">
    <h1>Inscription</h1>
    <?php $this->includePartial("form", $user->getRegisterForm()) ?>
</div>




