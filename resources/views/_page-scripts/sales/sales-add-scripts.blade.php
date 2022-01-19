<script>

$(document).on('submit','form[id="add-sales-form"]',function(el){
    el.preventDefault();

    var action = $(this).attr('action');
    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: action,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            swal.fire('Sale','Successfully added!','success');
            $('#salesFormModal').modal('hide');
            datatable.reload();
        },
        error: function (xhr, status, error)
        {
            $.each(xhr.responseJSON.errors, function (key,item){
                alert(item);
            });
        }
    });
});


</script>
