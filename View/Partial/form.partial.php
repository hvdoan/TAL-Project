<form class="<?= $data["config"]["classForm"]??"" ?>" method="<?= $data["config"]["method"]??"POST" ?>"  action="<?= $data["config"]["action"]??"" ?>">
    <h1><?= $data["config"]["title"]??"" ?></h1>
    <?php foreach ($data["inputs"] as $name=>$input) :?>

    <div class="field">
        <label><?= $name ?></label>
        <input
                type="<?= $input["type"]??"text" ?>"
                name="<?= $name?>"
                placeholder="<?= $input["placeholder"]??"" ?>"
                id="<?= $input["id"]??"" ?>"
                class="<?= $input["class"]??"" ?>"
                <?= empty($input["required"])?"":'required="required"' ?>
        ><br>
    </div>

    <?php endforeach;?>

    <input class="<?= $data["config"]["classSubmit"]??""?>" type="submit" value="<?= $data["config"]["submit"]??"Valider" ?>">
</form>
