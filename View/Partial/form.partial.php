<form class="<?= $data["config"]["classForm"]??"" ?> form-partial" method="<?= $data["config"]["method"]??"POST" ?>"  action="<?= $data["config"]["action"]??"" ?>">
    <h1><?= $data["config"]["title"]??"" ?></h1>
    <?php foreach ($data["inputs"] as $name=>$input) :?>

    <div class="field">
        <label><?= $input["label"]??"" ?></label>
        <input
                type="<?= $input["type"]??"text" ?>"
                name="<?= $name?>"
                placeholder="<?= $input["placeholder"]??"" ?>"
                value="<?= $input["value"]??"" ?>"
                id="<?= $input["id"]??"" ?>"
                class="<?= $input["class"]??"" ?>"
                <?= empty($input["required"])?"":'required="required"' ?>
                <?= empty($input["disabled"])?"":'disabled="disabled"' ?>
        >
    </div>

    <?php endforeach;?>

    <input class="<?= $data["config"]["classSubmit"]??""?>" type="submit" value="<?= $data["config"]["submit"]??"Valider" ?>">
</form>
