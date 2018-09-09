<script src="{{ asset('backend/plugins/croppic/js/croppic.min.js') }}"></script>
<script>
    $(function () {
        var img = $('#cropContainerModal').find('img');
        var croppicContainerModalOptions = {
            uploadUrl: '{{ route('backend.media.uploadImage') }}',
            cropUrl: '{{ route('backend.media.cropImage') }}',
            modal: true,
            outputUrlId: 'image-result',
            imgEyecandyOpacity: 0.7,
            loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onReset: function () {
                if (img.length) {
                    $('#cropContainerModal').prepend(img);
                }
            },
            onError: function (errormessage) {
                console.log('onError:' + errormessage)
            }
        }
        var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);
    })
</script>