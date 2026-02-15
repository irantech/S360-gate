tinymce.init({
    selector: ".setToEditor",
    theme: "modern",
    height: 200,
    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
    plugins: [
        // "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        // "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        // "save table contextmenu directionality emoticons template paste textcolor"
        "save directionality textcolor"
    ],
	// content_css : "../fun_script/editor_TinyMCE/fonts.css",
    // toolbar: "insertfile undo redo | bold italic | rtl ltr | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
    toolbar: "insertfile undo redo | bold italic | rtl ltr | alignleft aligncenter alignright alignjustify | bullist numlist | link image | print preview media fullpage | forecolor backcolor emoticons",
    style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
}); 