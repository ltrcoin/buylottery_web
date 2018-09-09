<script>
    $(".mark-as-read").click(function() {
        var listId = "";
        $(".checkItem").each(function() {
            if($(this).is(":checked")) {
                if(listId.length == 0) {
                    listId = $(this).val();
                } else {
                    listId += ","+$(this).val();
                }
            }
        });
        var href = $("#markReadUrl").val();
        if(listId == "") {
            jAlert('{{ __('label.notification.no_checked_item') }}', '{{ __('label.notification.list_title') }}');
            return false;
        } else {
            location.href = href+'/'+listId;
        }
    });
</script>