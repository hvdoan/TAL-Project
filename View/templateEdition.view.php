<div id="templateEdition" class="ctn">
    <h1>Edition de ma template</h1>
    <div class="edition">
        <form id="StyleForm">
            <fieldset>
                <legend> Couleurs </legend>
                <div class="field url-ctn">
                    <label for="pickerHeader">Couleur header : </label>
                    <div class="input-ctn">
                        <input type="color" value="<?= $this->data['style']['pickerHeader'] ?>" id="pickerHeader">
                    </div>
                </div>
                <div class="field url-ctn">
                    <label for="pickerBackground">Couleur de fond : </label>
                    <div class="input-ctn">
                        <input type="color" value="<?= $this->data['style']['pickerBackground'] ?>" id="pickerBackground">
                    </div>
                </div>
                <div class="field url-ctn">
                    <label for="pickerTitle">Couleur des titres : </label>
                    <div class="input-ctn">
                        <input type="color" value="<?= $this->data['style']['pickerTitle'] ?>" id="pickerTitle">
                    </div>
                </div>
                <div class="field url-ctn">
                    <label for="pickerText">Couleur du texte : </label>
                    <div class="input-ctn">
                        <input type="color" value="<?= $this->data['style']['pickerText'] ?>" id="pickerText">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend> Polices </legend>
                <div class="field url-ctn">
                    <label for="pickerFont">Police du texte : </label>
                    <div class="input-ctn">
                        <input class="input" type="text" value="" placeholder="https://fonts..." id="pickerFont">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <button class="btn-form btn-form-validate" onclick="saveStyle()">Sauvegarder</button>
</div>