<section class="ctn">
    <h1>Modification de page</h1>

    <div>
        <label>URL : https://<?=WEBSITENAME?>.fr/</label>

        <?php if($this->data["page"]->getId()) { ?>
            <input id="input-uri" type="text" name="uri" value="<?=str_replace("/", "", $this->data["page"]->getUri())?>">
        <?php } else { ?>
            <input id="input-uri" type="text" name="uri">
        <?php } ?>
    </div>

    <div>
        <label>Description de la page</label>

        <?php if($this->data["page"]->getId()) { ?>
            <input id="input-description" type="text" name="description" value="<?=$this->data["page"]->getDescription()?>">
        <?php } else { ?>
            <input id="input-description" type="text" name="description">
        <?php } ?>
    </div>

    <!--    CSRF-->
    <input id="tokenForm" type="hidden" name="tokenForm" value="<?=$this->data["tokenForm"]?>">
</section>

<section class="ctn">
    <div id="editorjs"></div>
    <?php if($this->data["page"]->getId()) { ?>
        <button id="save-button" class="btn btn-edit" onclick="save('<?=$this->data["page"]->getId()?>')">Sauvegarder</button>
        <pre id="output"></pre>
    <?php } else { ?>
        <button class="btn btn-validate" onclick="save()">Créer</button>
    <?php } ?>
</section>

<script src="../SASS/JS/crudPage.js"></script>
<script src="/API/EditorJS/editor.js"></script>
<script src="/API/EditorJS/Paragraph/bundle.js"></script>
<script src="/API/EditorJS/Header/bundle.js"></script>
<script src="/API/EditorJS/List/bundle.js"></script>
<script src="/API/EditorJS/List/nested-list.js"></script>
<script src="/API/EditorJS/Image/bundle.js"></script>
<script src="/API/EditorJS/Alignment/bundle.js"></script>
<script type="text/javascript">
    let data;

    <?php if(isset($this->data["page"])) { ?>
        data = JSON.parse(<?=json_encode($this->data["page"]->getContent())?>);
    <?php } ?>

    let editor = new EditorJS({
        // autofocus: true,
        tools: {
            paragraph: {
                class: Paragraph,
                inlineToolbar: true
            },
            header: {
                class: Header,
                config: {
                    placeholder: 'Enter a header',
                    levels: [1, 2, 3, 4, 5, 6],
                    defaultLevel: 1
                }
            },
            image: {
                class: ImageTool,
                config: {
                    endpoints: {
                        byFile: '/Resources/uploadFile/test.php', // Your backend file uploader endpoint
                        byUrl: '/Resources/fetchUrl/test.php' // Your endpoint that provides uploading by Url
                    }
                }
            },
            list: {
                class: List,
                inlineToolbar: true,
                config: {
                    defaultStyle: 'unordered'
                }
            },
            alignment: {
                class:AlignmentBlockTune,
                config:{
                    default: "right",
                    blocks: {
                        header: 'center',
                        list: 'right'
                    }
                },
            }
            // nestedList: {
            //     class: NestedList,
            //     inlineToolbar: true,
            // },
        },
        defaultBlock: 'paragraph',
        data: data
    });

    function save(pageId = "")
    {
        editor.save().then( savedData => {
            let data = JSON.stringify(savedData, null, 4);
            $('#output').html(data);

            if(pageId !== "")
                updatePage(pageId, data);
            else
                insertPage(data);
        })
    }
</script>
