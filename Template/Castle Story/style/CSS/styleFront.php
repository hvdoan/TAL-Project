<?php header("Content-type: text/css");

$file = 'style.json';
$style = null;
if (file_exists($file)) {
    $style = json_decode(file_get_contents($file), true);
}

?>
<style>

    body {}

    :root {
        --main-color: <?= $style['colors']['pickerMain']['value'] ?>;
        --bg-color: <?= $style['colors']['pickerBackground']['value'] ?>;
        --title-color: <?= $style['colors']['pickerTitle']['value'] ?>;
        --text-color: <?= $style['colors']['pickerText']['value'] ?>;
        --forum-color: <?= $style['colors']['pickerForum']['value'] ?>;
        --main-fonts: <?= $style['fonts']['pickerFont']['value'] ?>;
        --second-fonts: <?= $style['fonts']['pickerSecondFont']['value'] ?>;
        --url-banner-image: url('/Template/Castle Story/asset/img/<?= $style['images']['pickerBanner']['value'] ?>');
    }
</style>

