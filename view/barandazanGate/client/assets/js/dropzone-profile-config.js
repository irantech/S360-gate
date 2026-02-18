$(document).ready(function () {
// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = $("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parent().html();
    previewNode.parent().find('#template').remove();

    var myDropzone = new Dropzone("#attachments", { // Make the whole body a dropzone
        url: amadeusPath + "user_ajax.php", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        addRemoveLinks: true,
        dictRemoveFileConfirmation: true,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#attachments", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    });

    myDropzone.on("addedfile", function (file) {
        // Hookup the start button
        $("#actions .start").removeClass('d-none');
        $("#actions .cancel").removeClass('d-none');
        $(file.previewElement).find(".start").on('click', function () {
            myDropzone.enqueueFile(file);
        });
    });

// Update the total progress bar
    myDropzone.on("totaluploadprogress", function (progress) {
        $("#total-progress .progress-bar").css({'width': progress + "%"});
    });

    myDropzone.on("sending", function (file, xhr, formData) {
        formData.append('flag', 'agencyUploadAttachments');
        console.log(formData);
        // Show the total progress bar when upload starts
        // document.querySelector("#total-progress").style.opacity = "1";
        $("#total-progress").css({'opacity': '1'});
        // And disable the start button
        $(file.previewElement).find(".start").attr("disabled", "disabled");

    });

// Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function (progress) {
        $("#total-progress").css({'opacity': '0'});
    });

// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
    $("#actions .start").on('click', function (e) {
        e.preventDefault();
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    });
    document.querySelector("#actions .cancel").onclick = function () {
        myDropzone.removeAllFiles(true);
    };
    myDropzone.on("success", function (file, response) {
        var JsonData = JSON.parse(response);
        if(JsonData.status == 'success'){
            $(file.previewTemplate).append('<div class="server_file alert alert-success d-block" data-id="'+JsonData.data +'">' + JsonData.message + '</div>');
        }else {
            $(file.previewTemplate).append('<div class="server_file alert alert-warning d-block" data-id="'+JsonData.data+'">' + JsonData.message + '</div>');
        }
    });
// document.querySelector("#actions .delete").onclick = function () {
//     console.log(JsonData);
// };
    myDropzone.on("removedfile", function (file) {
        let file_id = $(file.previewTemplate).children('.server_file').data('id');

        removeAgencyAttachment(file_id);


    });

});