

<script>
    jQuery(function() {
        var formData = '{{ $json }}',
            formRenderOpts = {
                dataType: 'json',
                formData: formData
            };

        var renderedForm = $('<div>');
        renderedForm.formRender(formRenderOpts);

        console.log(renderedForm.html());
    });
</script>