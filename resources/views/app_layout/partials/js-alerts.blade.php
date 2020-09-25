
@if(\Session::has('modal-success'))
let modalControllerSuccess = new ModalController();
modalControllerSuccess
    .appendBody(`<div class="text-center"><i class="fa fa-check fa-4x mb-3 animated rotateIn green-text"></i></div>`)
    .appendBody("{{\Session::get('modal-success')}}").show();
@endif
@if(\Session::has('modal-error'))
toastr.error("{{\Session::get('modal-error')}}");
@endif
@if(\Session::has('error'))
toastr.error("{{\Session::get('error')}}");
@endif
@if(\Session::has('success'))
toastr.success("{{\Session::get('success')}}");
@endif
@if(\Session::has('info'))
toastr.info("{{\Session::get('info')}}");
@endif
@if(\Session::has('warning'))
toastr.warning("{{\Session::get('warning')}}");
@endif
