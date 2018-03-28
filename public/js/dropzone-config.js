//Gallery
Dropzone.options.imageUpload = {
    paramName: "file",
    maxFilesize: 5,
    parallelUploads: 2,
    uploadMultiple: true,
    acceptedFiles: 'image/*',
    init: function() {
        this.on('sending', function (file, xhr, formData) {
            formData.append('gallery-id', $('#image-upload').attr('element-id'));
        });
        this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                window.location.reload()
            }
        });
    }
};
