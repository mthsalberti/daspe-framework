<!-- Central Modal Medium Warning -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-info" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Tem certeza?</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body">
                <div class="text-center" id="delete-modal-message">
                    <p id="modal-delete-message"></p>
                </div>
            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <a type="button" class="btn btn-info" id="delete-button" data-url="/admin/{{\Daspeweb\Framework\DaspewebHelper::slug()}}">Tenho certeza <i class="fa fa-diamond ml-1"></i></a>
                <a type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Não, cancelar exclusão.</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
