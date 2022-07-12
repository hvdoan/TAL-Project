<div id="page_creation">
    <section class="ctn form">
        <div class="field-row">
            <div class="field">
                <h1>Paramétrage de la page</h1>
            </div>
        </div>

        <div class="field-row">
            <hr>
        </div>

        <div class="field-row">
            <div class="field url-ctn">
                <label>URL : </label>

                <div class="input-ctn">
                    <span>https://<?=WEBSITENAME?>.fr/</span>
                    <?php if($this->data["page"]->getId()) { ?>
                        <input id="input-uri" class="input" type="text" name="uri" value="<?=str_replace("/", "", $this->data["page"]->getUri())?>">
                    <?php } else { ?>
                        <input id="input-uri" class="input" type="text" name="uri">
                    <?php } ?>
                </div>
            </div>
            <div class="field url-ctn">
                <label for="colorPicker">Couleur de fond : </label>
                <div class="input-ctn">
                    <input type="color" value="#1DB8CE" id="colorPicker">
                </div>
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label>Description de la page</label>

                <?php if($this->data["page"]->getId()) { ?>
                    <input id="input-description" class="input" type="text" name="description" value="<?=$this->data["page"]->getDescription()?>">
                <?php } else { ?>
                    <input id="input-description" class="input" type="text" name="description">
                <?php } ?>
            </div>
        </div>

        <!--    CSRF-->
        <input id="tokenForm" type="hidden" name="tokenForm" value="<?=$this->data["tokenForm"]?>">
    </section>

    <section class="ctn ctn-editorJS">
        <div id="editorjs" class="editorjs"></div>
        <div class="ctn-cta">
            <?php if($this->data["page"]->getId()) { ?>
                <button id="save-button" class="btn-form btn-form-validate" onclick="save('<?=$this->data["page"]->getId()?>')">Sauvegarder</button>
            <?php } else { ?>
                <button class="btn-form btn-form-validate" onclick="save()">Créer</button>
            <?php } ?>
        </div>
    </section>
</div>

<script src="../SASS/JS/crudPage.js"></script>
<script src="/API/EditorJS/editor.js"></script>
<script src="/API/EditorJS/Paragraph/bundle.js"></script>
<script src="/API/EditorJS/Header/bundle.js"></script>
<script src="/API/EditorJS/List/bundle.js"></script>
<script src="/API/EditorJS/List/nested-list.js"></script>
<script src="/API/EditorJS/Image/bundle.js"></script>
<script src="/API/EditorJS/Alignment/bundle.js"></script>
<script src="/API/EditorJS/StyleEditor/index.js"></script>
<script src="/API/EditorJS/Hyperlink/bundle.js"></script>
<script type="text/javascript">
    let data;

    if(<?=isset($this->data["page"])?>)
    {
        data = JSON.parse(<?=json_encode($this->data["page"]->getContent())?>);
    }

    let editor = new EditorJS({
        // autofocus: true,
        tools: {
            style: EditorJSStyle.StyleInlineTool,
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

            if(pageId !== "")
                updatePage(pageId, data);
            else
                insertPage(data);
        })
    }
</script>
