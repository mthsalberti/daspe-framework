<script>
    let modalT = new ModalController();
    $("a:contains('criar')").on('click', function () {
        modalT.appendBody(`
        <form method="post" class="md-form" id="my-form" action="/admin/custom/import/import-model" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="file" id="file" name="file" >
        </form>
        `);
        modalT.appendButton(`<button id="confirm" class="btn btn-primary btn-outline-primary btn-sm" type="submit">Enviar</button>`);
        modalT.show();
        confirm();
    });

    function confirm() {
        $('#confirm').on('click', function () {
            alert('ok');
            $('#my-form').submit();
        })
    }
</script>