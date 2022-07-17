<style>
    body
    {
        overflow: hidden;
    }

    .form {
        height: 60vh;
        margin: 50vh auto 0;
        transform: translateY(-50%);
    }
</style>

<?php $this->includePartial("form", $user->getResetPassword()) ?>