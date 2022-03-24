<style>
    h1
    {
        color: #0c0c0c !important;
    }
</style>

<?php
    if($this->data["page"]->getId())
    {
        echo "<pre>";
        var_dump($this->data["page"]->getContent());
        echo "</pre>";
    }
?>

<section class="ctn">
    <div id="editorjs"></div>
    <?php
        if($this->data["page"]->getId() )
    ?>
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
                        byFile: 'http://localhost:81/Resources/uploadFile/castlestory_1.jpg', // Your backend file uploader endpoint
                        byUrl: 'http://localhost:81/Resources/fetchUrl/castlestory_1.jpg' // Your endpoint that provides uploading by Url
                    }
                    // uploader: {
                    //     uploadByFile(file) {
                    //         console.log(file)
                    //         // your own uploading logic here
                    //         return MyAjax.upload(file).then(() => {
                    //             console.log(file)
                    //             return {
                    //                 success: 1,
                    //                 file: {
                    //                     url: 'http://localhost:81/test.png',
                    //                     // any other image data you want to store, such as width, height, color, extension, etc
                    //                 }
                    //             };
                    //         });
                    //     },
                    //     uploadByUrl(url) {
                    //         // your ajax request for uploading
                    //         return MyAjax.upload(file).then(() => {
                    //             return {
                    //                 success: 1,
                    //                 file: {
                    //                     url: 'http://localhost:81/test.png',
                    //                 // any other image data you want to store, such as width, height, color, extension, etc
                    //                 }
                    //             };
                    //         });
                    //     }
                    // }
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
        data: data
    });

    function save(pageId)
    {
        editor.save().then( savedData => {
            let data = JSON.stringify(savedData, null, 4);
            $('#output').html(data);

            // if(pageId)
            //     updateRole(pageId, data);
        })
    }
</script>
