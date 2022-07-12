<div id="templateManagement" class="ctn">

    <?php foreach ($this->data['names'] as $template): ?>

    <div class="template">
        <div class="preview"><img src="../Template/blue/preview.png"></div>
        <div class="title"><?= $template ?><span>Installer</span></div>
    </div>

    <?php endforeach; ?>
</div>