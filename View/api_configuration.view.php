<div id="api-configuration">
    <form class="form" action="/api-configuration" method="post">
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
                <input class="input" type="text" name="dbHost" value="<?=DBHOST?>" required>
            </div>
        </div>

        <!-- Port field -->
        <div class='field-row'>
            <div class="field">
                <label>Port <span class="required">*</span></label>
                <input class="input" type="text" name="dbPort" value="<?=DBPORT?>" required>
            </div>
        </div>


        <!-- User field -->
        <div class='field-row'>
            <div class="field">
                <label>Utilisateur <span class="required">*</span></label>
                <input class="input" type="text" name="dbUser" value="<?=DBUSER?>" required>
            </div>
        </div>


        <!-- Password field -->
        <div class='field-row'>
            <div class="field">
                <label>Mot de passe <span class="required">*</span></label>
                <div class="row">
                    <input id="input-dbPassword" class="input" type="password" name="dbPassword" value="<?=DBPWD?>" required>
                    <i id="hide-dbPassword" class="fa-solid fa-eye-slash pointer" onclick="triggerShowKey('#input-dbPassword', '#hide-dbPassword', '#show-dbPassword')"></i>
                    <i id="show-dbPassword" class="hide fa-solid fa-eye pointer" onclick="triggerShowKey('#input-dbPassword', '#hide-dbPassword', '#show-dbPassword')"></i>
                </div>
            </div>
        </div>

        <input type="hidden" name="requestType" value="updateDatabase">
        <input type="hidden" name="tokenForm" value="<?=$this->data["tokenForm"]?>">

        <!-- Cta field -->
        <div class='field-cta'>
            <button class="btnBack-form btnBack-form-validate" type="submit">Enregistrer</button>
        </div>
    </form>

    <form class="form" action="/api-configuration" method="post">
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
                    <input id="input-paypalClientKey" class="input" type="text" name="paypalClientKey" value="<?=PAYPALKEYCLIENT?>">
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

        <input type="hidden" name="requestType" value="updatePaypal">
        <input type="hidden" name="tokenForm" value="<?=$this->data["tokenForm"]?>">

        <div class="field-cta">
            <button class="btnBack-form btnBack-form-validate">Enregistrer</button>
        </div>
    </form>

    <form class="form" action="/api-configuration" method="post">
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
                <input class="input" type="text" name="mailerEmail" value="<?=PHPMAILEREMAIL?>" required>
            </div>
        </div>

        <!-- Password field -->
        <div class='field-row'>
            <div class="field">
                <label>Mot de passe <span class="required">*</span></label>
                <div class="row">
                    <input id="input-mailPassword" class="input" type="password" name="mailerPassword" value="<?=PHPMAILERPASSWORD?>" required>
                    <i id="hide-mailPassword" class="fa-solid fa-eye-slash pointer" onclick="triggerShowKey('#input-mailPassword', '#hide-mailPassword', '#show-mailPassword')"></i>
                    <i id="show-mailPassword" class="hide fa-solid fa-eye pointer" onclick="triggerShowKey('#input-mailPassword', '#hide-mailPassword', '#show-mailPassword')"></i>
                </div>
            </div>
        </div>

        <!-- Port field -->
        <div class='field-row'>
            <div class="field">
                <label>Port <span class="required">*</span></label>
                <input class="input" type="text" name="mailerPort" value="<?=PHPMAILERPORT?>" required>
            </div>
        </div>

        <!-- Client ID field -->
        <div class='field-row'>
            <div class="field">
                <label>Client ID <span class="required">*</span></label>
                <input class="input" type="text" name="mailerClientId" value="<?=PHPMAILERCLIENTID?>" required>
            </div>
        </div>

        <!-- Client secret field -->
        <div class='field-row'>
            <div class="field">
                <label>Client secret <span class="required">*</span></label>
                <div class="row">
                    <input id="input-mailClientSecret" class="input" type="password" name="mailerClientSecret" value="<?=PHPMAILERCLIENTSECRET?>" required>
                    <i id="hide-mailClientSecret" class="fa-solid fa-eye-slash pointer" onclick="triggerShowKey('#input-mailClientSecret', '#hide-mailClientSecret', '#show-mailClientSecret')"></i>
                    <i id="show-mailClientSecret" class="hide fa-solid fa-eye pointer" onclick="triggerShowKey('#input-mailClientSecret', '#hide-mailClientSecret', '#show-mailClientSecret')"></i>
                </div>
            </div>
        </div>

        <!-- Refresh token field -->
        <div class='field-row'>
            <div class="field">
                <label>Refresh token <span class="required">*</span></label>
                <input class="input" type="text" name="mailerToken" value="<?=PHPMAILERTOKEN?>" required>
            </div>
        </div>

        <input type="hidden" name="requestType" value="updateEmail">
        <input type="hidden" name="tokenForm" value="<?=$this->data["tokenForm"]?>">

        <div class="field-cta">
            <button class="btnBack-form btnBack-form-validate">Enregistrer</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    function triggerShowKey(p_input, p_hideIcon, p_showIcon)
    {
        paypalKey   = $(p_input);
        hideIcon    = $(p_hideIcon);
        showIcon    = $(p_showIcon);

        if(hideIcon.hasClass("hide"))
        {
            hideIcon.removeClass("hide");
            showIcon.addClass("hide");
            paypalKey.prop("type", "password");
        }
        else
        {
            hideIcon.addClass("hide");
            showIcon.removeClass("hide");
            paypalKey.prop("type", "text");
        }
    }
</script>