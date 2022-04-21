<style>
    form
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        width: 500px;
        height: 300px;

        background: #6d769e;
        border: solid 1px #000;
        overflow: hidden;
    }

    form > #slider
    {
        display: flex;
        flex-direction: row;

        width: 2000px;
        height: 100%;

        transition: .3s;
    }

    form > #slider > section
    {
        display: flex;
        flex-direction: column;

        width: 500px;
        padding: 20px;
        box-sizing: border-box;
    }

    form > #slider > section > h1
    {
        margin-bottom: 20px;
    }

    form > #slider > section > .input > label
    {
        display: inline-block;
        width: 100px;
    }

    form > #slider > section > .input > input,
    form > #slider > section > .input > select
    {
        width: 100%;
    }

    form > #slider > section > .nav
    {
        display: flex;
        flex-direction: row;
        justify-content: space-between;

        margin-top: auto;
    }

    form > #slider > section:nth-child(1) > .nav
    {
        justify-content: flex-end;
    }
</style>

<form method="post" action="config">
    <div id="slider">
        <section class="section">
            <h1>Configuration du site</h1>

            <div class="input">
                <label>Nom du site</label>
                <input type="text" name="websiteName" required>
            </div>

            <div class="nav">
                <button class="btn btn-edit" type="button" onclick="moveToSection('0', '1')">Suivant</button>
            </div>
        </section>

        <section class="section">
            <h1>Configuration de la base de donnée</h1>

            <div class="input">
                <label>Serveur</label>
                <input type="text" name="dbHost" required>
            </div>

            <div class="input">
                <label>Port</label>
                <input type="text" name="dbPort" required>
            </div>

            <div class="input">
                <label>Utilisateur</label>
                <input type="text" name="dbUser" required>
            </div>

            <div class="input">
                <label>Mot de passe</label>
                <input type="text" name="dbPassword" required>
            </div>

            <div class="nav">
                <button class="btn btn-edit" type="button" onclick="moveToSection('1', '0')">Précédant</button>
                <button class="btn btn-edit" type="button" onclick="moveToSection('1', '2')">Suivant</button>
            </div>
        </section>

        <section class="section">
            <h1>Configuration de Paypal</h1>

            <div class="input">
                <label>Clé client</label>
                <input type="text" name="paypalClientKey" required>
            </div>

            <div class="input">
                <label>Devise</label>
                <select name="paypalCurrency">
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                </select>
            </div>

            <div class="nav">
                <button class="btn btn-edit" type="button" onclick="moveToSection('2', '1')">Précédant</button>
                <button class="btn btn-edit" type="button" onclick="moveToSection('2', '3')">Suivant</button>
            </div>
        </section>

        <section class="section">
            <h1>Configuration de la boite mail</h1>

            <div class="input">
                <label>Email</label>
                <input type="text" name="phpmailerEmail" required>
            </div>

            <div class="input">
                <label>Mot de passe</label>
                <input type="text" name="phpmailerPassword" required>
            </div>

            <div class="input">
                <label>Port</label>
                <input type="text" name="phpmailerPort" required>
            </div>

            <div class="nav">
                <button class="btn btn-edit" type="button" onclick="moveToSection('3', '2')">Précédant</button>
                <button class="btn btn-validate" type="submit">Enregistrer</button>
            </div>
        </section>
    </div>

    <input type="hidden" name="requestType" value="initialization">
    <input type="hidden" name="token" value="<?=$this->data["token"]?>">
</form>

<script type="text/javascript">
    function moveToSection(position, movePosition)
    {
        let canMove = true;

        if (movePosition > position)
            if(!checkNotEmpty(position))
                canMove = false;

        if (canMove)
            $("#slider").css({marginLeft: "-" +(500 * movePosition) + "px"});
    }

    function checkNotEmpty(position)
    {
        let result      = true;
        let listInput   = $(".section:eq(" + position + ")").find("div").find("input");

        for(let i = 0; i < listInput.length; i++)
        {
            if(listInput[i].value === "")
                result = false;
        }

        return result;
    }
</script>