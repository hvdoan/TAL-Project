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
        --main-fonts: <?= $style['fonts']['pickerFont']['value'] ?>;
    }
</style>

