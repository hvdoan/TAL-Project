<div id="templateEdition" class="ctn">
    <h1>Edition de ma template</h1>
    <h3>Template actuel : <?= $this->data['templateSelected'] ?></h3>
    <div class="edition">
        <form id="StyleForm">
            <?php if (isset($this->data['style']['colors'])): ?>
            <fieldset>
                <legend> Couleurs </legend>
                <?php foreach ($this->data['style']['colors'] as $key => $color): ?>
                <div class="field url-ctn">
                    <label for="pickerHeader"><?= $color['label'] ?></label>
                    <div class="input-ctn">
                        <input type="color" value="<?= $color['value'] ?>" id="<?= $key ?>">
                    </div>
                </div>
                <?php endforeach; ?>
            </fieldset>
            <?php endif; ?>
            <?php if (isset($this->data['style']['fonts'])): ?>
            <fieldset>
                <legend> Polices </legend>
                <?php foreach ($this->data['style']['fonts'] as $key => $font): ?>
                <div class="field url-ctn">
                    <label for="pickerFont"><?= $font['label'] ?></label>
                    <div class="input-ctn">
                        <input class="input fontPicker" type="text" value="<?= $font['value'] ?>" placeholder="Roboto" id="<?= $key ?>">
                    </div>
                    <span class="advise">Entrer le nom d'une police google fonts</span>
                </div>
                <?php endforeach; ?>
            </fieldset>
            <?php endif; ?>
            <?php if ((!isset($this->data['style']['colors'])) && (!isset($this->data['style']['fonts']))): ?>
                <div>Aucune modification n'est disponible</div>
            <?php endif; ?>
        </form>
    </div>
    <button class="btnBack-form btnBack-form-validate" onclick="saveStyle()">Sauvegarder</button>
</div>
<div id="jsonHidden" style="visibility: hidden"><?php print_r($this->data['styleHidden'])?></div>
<input id='tokenForm' type='hidden' name='tokenForm' value='<?= $this->data['tokenCSRF'] ?>'>