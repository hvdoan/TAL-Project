<section class="page">
    <div id="editorjs"></div>
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

    <?php if(isset($this->data["data"])) { ?>
        data = JSON.parse(<?=json_encode($this->data["data"])?>);
    <?php } ?>

    console.log(data);

    let editor = new EditorJS({
        // autofocus: true,
        readOnly: true,
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
</script>