<div id="templateManagement" class="ctn">

    <?php foreach ($this->data['names'] as $template): ?>

        <div class="template">
            <div class="preview"><img src="../Template/<?= $template ?>/preview.png" alt="preview"></div>
            <div id="templateTitle" class="title" onclick="saveTemplate(this)"><?= $template ?></div>
        </div>

    <?php endforeach; ?>
</div>