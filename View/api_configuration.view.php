<div id="api-configuration">
    <section id="paypal" class="ctn">
        <form action="/api-configuration" method="post">
            <h1>Configuration Paypal</h1>

            <hr>

            <div class="field">
                <label>Clé client public</label>
                <div class="row">
                    <input id="input-key" type="password" name="clientKey" value="<?=PAYPALKEYCLIENT?>">
                    <i id="hide-icon" class="fa-solid fa-eye-slash" onclick="triggerShowKey()"></i>
                    <i id="show-icon" class="hide fa-solid fa-eye" onclick="triggerShowKey()"></i>
                </div>
            </div>

            <div class="field">
                <label>Devise</label>
                <select name="currency">
                    <option value="EUR">EUR</option>
                    <option value="USD">USD</option>
                </select>
            </div>

            <input type="hidden" name="requestType" value="updatePaypal">
            <input type="hidden" name="tokenForm" value="<?=$this->data["tokenForm"]?>">

            <div class="field-submit">
                <button class="btn-validate">Sauvegarder</button>
            </div>
        </form>
    </section>

    <section id="email" class="ctn">
        <form action="/api-configuration" method="post">
            <h1>Configuration de la boite mail</h1>

            <hr>

            <div class="field">
                <label>Mail</label>
                <input type="text" name="email" value="<?=PHPMAILEREMAIL?>">
            </div>

            <div class="field">
                <label>Mot de passe</label>
                <input type="password" name="password" value="<?=PHPMAILERPASSWORD?>">
            </div>

            <div class="field">
                <label>Port</label>
                <input type="text" name="port" value="<?=PHPMAILERPORT?>">
            </div>

            <input type="hidden" name="requestType" value="updateEmail">
            <input type="hidden" name="tokenForm" value="<?=$this->data["tokenForm"]?>">

            <div class="field-submit">
                <button class="btn-validate">Sauvegarder</button>
            </div>
        </form>
    </section>
</div>

<script type="text/javascript">
    function triggerShowKey()
    {
        paypalKey   = $("#input-key");
        hideIcon    = $("#hide-icon");
        showIcon    = $("#show-icon");

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