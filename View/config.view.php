<style>
    form
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        width: 520px;

        overflow: hidden;
    }

    form > #slider
    {
        display: flex;
        flex-direction: row;
        align-items: center;

        width: 2080px;
        height: 100%;

        transition: .3s;
    }

    form > #slider > section
    {
        display: flex;
        flex-direction: column;

        width: 500px;
        height: fit-content;
        margin: 10px;
        box-sizing: border-box;

        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        overflow: hidden;
    }

    form > #slider > section > .input > input,
    form > #slider > section > .input > select
    {
        width: 100%;
    }
</style>

<form method="post" action="config">
    <div id="slider">
        <!-- WEBSITE CONFIGURATION -->
        <section class="section form">
            <!-- Header -->
            <div class='field-row'>
                <div class='field'>
                    <h1>Configuration du site</h1>
                </div>
            </div>

            <!-- Separator -->
            <div class='field-row'>
                <hr>
            </div>

            <!-- Name field -->
            <div class='field-row'>
                <div class="field">
                    <label>Nom du site <span class="required">*</span></label>
                    <input class="input" type="text" name="websiteName" required>
                </div>
            </div>

            <!-- Name field -->
            <div class='field-row'>
                <div class="field">
                    <label>Votre prénom <span class="required">*</span></label>
                    <input class="input" type="text" name="websiteAdminFirstname" required>
                </div>
            </div>

            <!-- Name field -->
            <div class='field-row'>
                <div class="field">
                    <label>Votre nom <span class="required">*</span></label>
                    <input class="input" type="text" name="websiteAdminLastname" required>
                </div>
            </div>

            <!-- Name field -->
            <div class='field-row'>
                <div class="field">
                    <label>Mail admin <span class="required">*</span></label>
                    <input class="input" type="email" name="websiteAdminMail" required>
                </div>
            </div>

            <!-- Name field -->
            <div class='field-row'>
                <div class="field">
                    <label>Mot de passe admin <span class="required">*</span></label>
                    <input class="input" type="text" name="websiteAdminPassword" required>
                </div>
            </div>

            <!-- Cta field -->
            <div class='field-cta'>
                <button class="btnBack-form btnBack-form-validate" type="button" onclick="moveToSection('0', '1')">Suivant</button>
            </div>
        </section>

        <!-- DATABASE CONFIGURATION -->
        <section class="section form">
            <!-- Header -->
            <div class='field-row'>
                <div class='field'>
                    <h1>Configuration de la base de donnée</h1>
                </div>
            </div>

            <!-- Separator -->
            <div class='field-row'>
                <hr>
            </div>

            <!-- Server field -->
            <div class='field-row'>
                <div class="field">
                    <label>Serveur <span class="required">*</span></label>
                    <input class="input" type="text" name="dbHost" required>
                </div>
            </div>

            <!-- Port field -->
            <div class='field-row'>
                <div class="field">
                    <label>Port <span class="required">*</span></label>
                    <input class="input" type="text" name="dbPort" required>
                </div>
            </div>


            <!-- User field -->
            <div class='field-row'>
                <div class="field">
                    <label>Utilisateur <span class="required">*</span></label>
                    <input class="input" type="text" name="dbUser" required>
                </div>
            </div>


            <!-- Password field -->
            <div class='field-row'>
                <div class="field">
                    <label>Mot de passe <span class="required">*</span></label>
                    <input class="input" type="text" name="dbPassword" required>
                </div>
            </div>

            <!-- Cta field -->
            <div class='field-cta'>
                <button class="btnBack-form btnBack-form-cancel" type="button" onclick="moveToSection('1', '0')">Précédant</button>
                <button class="btnBack-form btnBack-form-validate" type="button" onclick="moveToSection('1', '2')">Suivant</button>
            </div>
        </section>

        <!-- PAYPAL CONFIGURATION -->
        <section class="section form">
            <!-- Header -->
            <div class='field-row'>
                <div class='field'>
                    <h1>Configuration de Paypal</h1>
                </div>
            </div>

            <!-- Separator -->
            <div class='field-row'>
                <hr>
            </div>

            <!-- Client key field -->
            <div class='field-row'>
                <div class="field">
                    <label>Clé client <span class="required">*</span></label>
                    <input class="input" type="text" name="paypalClientKey" required>
                </div>
            </div>

            <!-- Currency field -->
            <div class='field-row'>
                <div class="field">
                <label>Devise <span class="required">*</span></label>
                    <div id="select-ctn">
                        <select name="paypalCurrency">
                            <option value="EUR">EUR</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Cta field -->
            <div class='field-cta'>
                <button class="btnBack-form btnBack-form-cancel" type="button" onclick="moveToSection('2', '1')">Précédant</button>
                <button class="btnBack-form btnBack-form-validate" type="button" onclick="moveToSection('2', '3')">Suivant</button>
            </div>
        </section>


        <!-- PHPMAILER CONFIGURATION -->
        <section class="section form">
            <!-- Header -->
            <div class='field-row'>
                <div class='field'>
                    <h1>Configuration de la boite mail</h1>
                </div>
            </div>

            <!-- Separator -->
            <div class='field-row'>
                <hr>
            </div>

            <!-- Mail field -->
            <div class='field-row'>
                <div class="field">
                    <label>Email <span class="required">*</span></label>
                    <input class="input" type="text" name="phpmailerEmail" required>
                </div>
            </div>

            <!-- Password field -->
            <div class='field-row'>
                <div class="field">
                    <label>Mot de passe <span class="required">*</span></label>
                    <input class="input" type="text" name="phpmailerPassword" required>
                </div>
            </div>

            <!-- Port field -->
            <div class='field-row'>
                <div class="field">
                    <label>Port <span class="required">*</span></label>
                    <input class="input" type="text" name="phpmailerPort" required>
                </div>
            </div>

            <!-- Client ID field -->
            <div class='field-row'>
                <div class="field">
                    <label>Client ID <span class="required">*</span></label>
                    <input class="input" type="text" name="phpmailerClientId" required>
                </div>
            </div>

            <!-- Client secret field -->
            <div class='field-row'>
                <div class="field">
                    <label>Client secret <span class="required">*</span></label>
                    <input class="input" type="text" name="phpmailerClientSecret" required>
                </div>
            </div>

            <!-- Cta field -->
            <div class='field-cta'>
                <button class="btnBack-form btnBack-form-cancel" type="button" onclick="moveToSection('3', '2')">Précédant</button>
                <button class="btnBack-form btnBack-form-validate" type="submit">Enregistrer</button>
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
            $("#slider").css({marginLeft: "-" +(520 * movePosition) + "px"});
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