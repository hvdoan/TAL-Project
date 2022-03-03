
<style>
    body
    {
        overflow: hidden;
    }

    .form {
        height: 60vh;
        margin: 0 auto;
        margin-top: 50vh;
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

</style>

<?php $this->includePartial("form", $user->getLoginForm()) ?>
        
        