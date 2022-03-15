<style>
    .simple-image
    {
        padding: 20px 0;
    }

    .simple-image input
    {
        width: 100%;
        padding: 10px;
        border: 1px solid #e4e4e4;
        border-radius: 3px;
        outline: none;
        font-size: 14px;
    }

    .simple-image img
    {
        max-width: 100%;
        margin-bottom: 15px;
    }

    .simple-image.withBorder img
    {
        border: 1px solid #e8e8eb;
    }

    .simple-image.withBackground
    {
        background: #eff2f5;
        padding: 10px;
    }

    .simple-image.withBackground img
    {
        display: block;
        max-width: 60%;
        margin: 0 auto 15px;
    }

    h1
    {
        color: #0c0c0c !important;
    }
</style>

<?php
    echo "<pre>";
    var_dump($this->data["page"]);
    echo "</pre>";
?>

<section class="ctn">
    <div id="editorjs"></div>

    <button id="save-button" class="btn" onclick="save('<?=$this->data["page"]->getId()?>')">Save</button>
    <pre id="output"></pre>
</section>

<script src="../CSS/dist/crudPage.js"></script>
<script src="/API/EditorJS/editor.js"></script>
<script src="/API/EditorJS/Paragraph/bundle.js"></script>
<script src="/API/EditorJS/Header/bundle.js"></script>
<script src="/API/EditorJS/List/bundle.js"></script>
<script src="/API/EditorJS/List/nested-list.js"></script>
<script src="/API/EditorJS/Image/bundle.js"></script>
<script type="text/javascript">
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
                    // endpoints: {
                    //     byFile: '/uploadFile', // Your backend file uploader endpoint
                    //     byUrl: '/fetchUrl', // Your endpoint that provides uploading by Url
                    // },
                    uploader: {
                        uploadByFile(file) {
                            // your own uploading logic here
                            return MyAjax.upload(file).then(() => {
                                return {
                                    success: 1,
                                    file: {
                                        url: file,
                                        // any other image data you want to store, such as width, height, color, extension, etc
                                    }
                                };
                            });
                        },
                        uploadByUrl(url) {
                            // your ajax request for uploading
                            return MyAjax.upload(file).then(() => {
                                return {
                                    success: 1,
                                    file: {
                                        url: url,
                                    // any other image data you want to store, such as width, height, color, extension, etc
                                    }
                                };
                            });
                        }
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
            // nestedList: {
            //     class: NestedList,
            //     inlineToolbar: true,
            // },
        },
        defaultBlock: 'paragraph',
        data:{}
    });

    editor.data = JSON.parse('{"time": 1647351453761, "blocks": [{"id": "LPnQobMxKH", "type": "list", "data": {"style": "unordered", "items": ["test", "test"]}}, {"id": "IsSB0EbNqR", "type": "header", "data": {"text": "titre", "level": 1}}, {"id": "Gup_FkDm9K", "type": "paragraph", "data": {"text": "Un peu de texte.", "alignment": "left"}], "version": "2.23.2"}');

    const saveButton = document.getElementById('save-button');

    function save(idPage)
    {
        let data = "";

        editor.save().then( savedData => {
            data = JSON.stringify(savedData, null, 4);
        })

        $('#output').html(data);

        if(idPage)
        updateRole()
    }
</script>
