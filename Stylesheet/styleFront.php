<?php header("Content-type: text/css");

$color = "#FFFFFF";
$color2 = "#ff00dc";

$file = 'style.json';
$style = null;
if (file_exists($file)) {
    $style = json_decode(file_get_contents($file), true);
}

?>
<style>

    body {}

    body {
        color: <?= $style['pickerText'] ?> !important;
    }

    nav, .nav-ctn {
        background: <?= $style['pickerHeader'] ?> !important;
    }

    .ce-header {
        background: <?= $style['pickerTitle'] ?> !important;
    }

    .editorjs {
        background: <?= $style['pickerBackground'] ?> !important;
    }
</style>

