<script>
  var urlExcel = "{{ route('backend.downloadExcel.organize') }}";
  function downloadExcel(){
    window.open(urlExcel);
  }
  $(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = "{{ route('backend.import.organize') }}";
    $('#fileupload').fileupload({
      url: url,
      acceptFileTypes: /(\.|\/)(xls|xlsx|xlsm)$/i,
      dataType: 'json',
      messages: {
        acceptFileTypes: "{{ __('validation.organize.input_excel') }}" ,
        maxFileSize:  'yourText',
        minFileSize:  'yourText'
      },
      always: function(e , data){
        if(data.result.status == "success"){
          jAlert("{{ __('label.organize.import_success') }}", 'Thông báo');
        }else{
          jAlert("{{ __('label.organize.import_fail') }}", 'Thông báo');
        }
      },
      progressall: function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
          'width',
          progress + '%'
        );
      }
    })
      .on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
          file = data.files[index],
          node = $("#myModal .modal-body .error-upload");
        node.empty();
        if (file.error) {
          node
            .append('<br>')
            .append($('<span class="text-danger"/>').text(file.error));
        }

      })
      .prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
  });
</script>