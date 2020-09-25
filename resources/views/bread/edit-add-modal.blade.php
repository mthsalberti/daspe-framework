@php $formId = uniqid ('form'); @endphp
@include('daspeweb::app_layout.bread-add-edit.partials.main-content', ['formId' => $formId])
@include('daspeweb::app_layout.bread-add-edit.partials.main-javascript')

<script>
    $('#'+'{{$formId}}').off('submit').on('submit', function (event) {
        event.preventDefault();
        $('span.error-info').remove();
        let formEle = $(this);
        $.ajax({
            url: '/admin/api/'+formEle.data('slug'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "post",
            dataType: "json",
            data: new FormData( this ),
            processData: false,
            contentType: false,
            error: function (xhr, ajaxOptions, thrownError) {
                if(xhr.status === 422){
                    $.each(xhr.responseJSON.errors, function (key, item) {
                        $('#'+key).closest('.md-form')
                            .append(`<span title="erro" class="error-info">${item[0]}</span>`);
                    });
                }else{
                    toastr["error"](xhr.responseJSON.message);
                }
            },
            success: function (output, status, xhr) {
                toastr["success"]("Registro salvo.");
                location.reload();
            }
        });
    });
</script>
