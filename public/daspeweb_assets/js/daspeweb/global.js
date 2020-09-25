toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    // "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": 2000,
    "hideDuration": 300,
    "timeOut": 3000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

listenToFormFieldsFuncionalities();
browseBreadListeners();
listenDeleteButtons();

function listenDeleteButtons(){
    console.log('calling listenDeleteButtons');
    $('.delete-modal').on('click', function () {
        $('#delete_modal').modal();
        $('#modal-delete-message').text("Você está prestes a excluir um registro.");
        $('#delete-button').attr('data-ids',  $(this).data('id'));
        $('#delete-button').attr('data-url',  $(this).data('url'));
        $('#delete-button').attr('data-is-from-related-list', $(this).hasClass('is-related-list'));
    });
    $('#bulk_delete_btn').off('click').on('click', function () {
        let ids = [];
        $.each($('.checkbox_line:checked'), function (index, val) {
            ids.push($(val).data('id'));
        });
        if(ids.length == 0){
            toastr["info"]("Nenhum registro selecionado.");
            return;
        }
        $('#delete_modal').modal();
        let message = ids.length == 1
            ? 'um registro.'
            : (ids.length + ' registros.');
        $('#modal-delete-message').text("Você está prestes a excluir " + message);
        $('#delete-button').attr('data-ids',  ids);
    });

    //esse é o listener do botão excluir da modal
    $('#delete-button').on('click', function () {
        let url = $(this).data('url');
        let isFromRelatedList = $(this).data('isFromRelatedList');
        let ids = String($(this).data('ids'));
        var idsJson = ids.split(",");
        deleteRecordArray(url, idsJson, isFromRelatedList);
        $('#delete_modal').modal('hide');
    });
}

function deleteRecordArray(url, ids, isFromRelatedList) {
    $.ajax({
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data : {
            _method : 'DELETE',
            ids: JSON.stringify(ids)
        },
        url: url,
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error('Algo deu errado');
        },
        success: function (response, ajaxOptions, thrownError) {
            if(isFromRelatedList){
                location.reload();
            }else{
                window.location.href = response.redirect;
            }
        }
    });
}

function listenToFormFieldsFuncionalities(){
    $(document).ready(function() {
        $('.mdb-select').materialSelect('destroy');
        $('.mdb-select').materialSelect();
        $('.search.form-control.w-100.d-block').on('click', function (e) {
            e.stopPropagation();
        });
        $('.mdb-select').on('click', function (e) {
            e.stopPropagation();
            $(this).find('.select-dropdown').addClass('active');
        });

        $('.file-upload').file_upload({
            maxFileSize: '1MB',
            messages: {
                default: 'Clique aqui ou arraste sua foto',
                replace: 'Clique aqui ou arraste sua foto para substituir',
                remove: 'Remover',
                error: 'Algo deu errado.'
            }
        }).on("file_upload.afterClear", function (event, myName, myValue) {
            $(myName.element).closest('.file-upload-wrapper').find('.aux').val("1");
        });

        $('.datepicker').datetimepicker({
            format: "dd/mm/yyyy",
            language: 'pt-BR',
            minView: 'month',
            autoclose: true,
            fontAwesome: true,
            icons: {
                time: 'fas fa-clock-o',
                date: 'fas fa-calendar',
                up: 'fas fa-arrow-circle-up',
                down: 'fas fa-arrow-circle-down',
                leftArrow: 'fas fa-arrow-circle-left',
                next: 'fas fa-arrow-circle-right',
                today: 'fas fa-calendar-check-o',
                clear: 'fas fa-trash-o',
                close: 'fas fa-close'
            }
        });

        $(".input-date-time").datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            language: 'pt-BR',
            autoclose: true,
            fontAwesome: true,
            icons: {
                time: 'fas fa-clock-o',
                date: 'fas fa-calendar',
                up: 'fas fa-arrow-circle-up',
                down: 'fas fa-arrow-circle-down',
                leftArrow: 'fas fa-arrow-circle-left',
                next: 'fas fa-arrow-circle-right',
                today: 'fas fa-calendar-check-o',
                clear: 'fas fa-trash-o',
                close: 'fas fa-close'
            }
        });

        $('.rich-editor').tinymce({
            content_css: [
                'https://use.fontawesome.com/releases/v5.7.2/css/all.css',
                '/daspeweb_assets/mdb/css/bootstrap.min.css',
                '/daspeweb_assets/mdb/css/mdb.min.css',
            ],
            valid_elements: '*[*]',
            extended_valid_elements: "*[*]",
            valid_children: "+*[*]",
            verify_html: false,
            height: 300,
            allow_script_urls: true,
            theme: 'modern',
            forced_root_block: "",
            entity_encoding: "raw",
            plugins: 'importcss code print preview searchreplace autolink directionality visualblocks  ' +
                'visualchars fullscreen image imagetools link media template codesample table charmap hr pagebreak nonbreaking anchor toc ' +
                'insertdatetime advlist lists textcolor wordcount contextmenu colorpicker textpattern  pagebreak',
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image print preview media | forecolor backcolor emoticons',
            paste_data_images: true,
            image_advtab: true,
        });

        $(".relationship").on("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })
            .autocomplete({
            appendTo: ".container-fluid",
            source: function (request, response) {
                var input = this.element;
                let fieldToSearch = input.data('fieldstosearch');
                let fieldToSearchFixed = input.data('fixedfilter');
                let fieldToLoad = input.data('fieldstoload');
                let filterArr = input.data('filterbeforesearch');
                let lookup = input.data('lookup');
                let filterQuery = [];
                $.each(filterArr, function (index, filter) {
                    filterQuery.push({
                        field: filter['field-to-search'],
                        criteria: filter['criteria'],
                        value: $(`#${filter['field-to-get']}`).val(),
                    });
                });
                $.each(fieldToSearchFixed, function (index, filter) {
                    filterQuery.push({
                        field: filter['field-to-search'],
                        criteria: filter['criteria'],
                        value: filter['value'],
                    });
                });

                $.getJSON("/admin/lookup/" + lookup, {
                    term: request.term,
                    'fields-to-search': fieldToSearch.join(','),
                    'fields-to-show': fieldToLoad.join(','),
                    'filter': JSON.stringify(filterQuery)
                }, response);
            },
            response: function (event, ui) {
                $(event.target).closest('.md-form').find('.progress').hide();
                var input = $(event.target);
                let fieldToShow = input.data('fieldstoshow');
                $.each(ui.content, function (index, val) {
                    let string = '';
                    $.each(fieldToShow, function (index, field) {
                        if (index == 0) {
                            string += val[field];
                            stringInput = val[field];
                        } else {
                            if (val[field] != null) {
                                string += ' | ' + val[field];
                            }
                        }
                    });
                    val.label = string;
                    val.value = stringInput;
                });
            },
            select: function (event, ui) {
                console.log({event, ui});
                let isHasMAny = $(event.target).hasClass('has-many-relationship');
                let inputName = $(event.target).attr('name').replace('_autocomplete', '');
                if (isHasMAny) {
                    let a = $(event.target).closest('.relationship-wrapper');
                    let field = $(event.target).data('maininputid');
                    $(event.target).closest('.relationship-wrapper').find('.chip-area')
                        .append(`<div class="chip p-0 px-1 m-0">${ui.item.value} <input name="${field}[]" type="hidden" value="${ui.item.id}"> <i class="close fa fa-times"></i></div>`);
                    event.stopPropagation();
                } else {
                    let maininputid = $(event.target).data('maininputid');
                    fixAutoCompleteController[inputName] = 'liberado';
                    $('#' + maininputid).val(ui.item.id);
                }
                $(event.target).trigger('change');
                $('#' + inputName).trigger('change');
                try {
                    window[$(event.target).attr('id') + "SelectCallback"](ui.item);
                } catch (e) {

                }
            },
            search: function (event, ui) {
                $(event.target).closest('.md-form').find('.progress').show();
            }
        });
        //função criada para dar suporte a um novo item no autocomplete, quando se trocava o item, o id anterior permanecia
        fixAutoCompleteController = [];
        $(document).ready(function () {
            $('.ui-autocomplete-input').on('keyup', function () {
                let inputName = $(this).attr('name').replace('_autocomplete', '');
                if (fixAutoCompleteController[inputName] != 'liberado') {
                    $('input[name=' + inputName + ']').val("");
                }
                fixAutoCompleteController[inputName] = 'não liberado';
            });
        });
        $('.has-mask').each(function (index, inputEle) {
            var options = {
                onKeyPress: function (value, event, input, options) {
                    if ($(input).hasClass('is-phone')) {
                        var masks = ['00 0000 00009', '00 0 0000 0000'];
                        var mask = ($(input).val().length > 12) ? masks[1] : masks[0];
                        $(input).mask(mask, options);
                    }
                }
            };
            $(inputEle).mask($(inputEle).data('mask-daspe'), options);
        });
        $('.is-cep').on('keyup', function () {
            let length = $(this).val().length;
            let cep = $(this).val();
            if (length === 9) {
                cep = cep.replace('-', '');
                $.ajax({
                    type: 'GET',
                    url: '/admin/consulta-cep/' + cep,
                    success: function (data) {
                        let r = JSON.parse(data);
                        $('#street').val(r.logradouro);
                        $('#neighbourhood').val(r.bairro);
                        $('#city').val(r.localidade);
                        $('#state').val(r.uf);
                        $(`select[name="state"] li:contains("${r.uf}")`).trigger('click');
                        $('select[name="state"]').closest('.select-wrapper')
                            .find('li:contains("' + r.uf + '")').trigger('click');
                    },
                    error: function (data) {
                        console.error(data);
                    }
                });
            }
        });
    });
}

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
        return uri + separator + key + "=" + value;
    }
}

function listenToEditRelatedItemButtons(){
    $('a.edit.is-related-list').on('click', function () {
        loadRelateRecordForm($(this).attr('href'), event);
    });
}

function loadRelateRecordForm(href, event){
    event.preventDefault();
    let newRecordModalController = new ModalController();
    newRecordModalController.setModalName('modal-default-create-record');
    $.ajax({
        url: href,
        method: "get",
        data: {'use_modal_form': 1},
        dataType: "html",
        error: function (xhr, ajaxOptions, thrownError) {},
        success: function (output, status, xhr) {
            newRecordModalController.appendBody(output).show();
        }
    });
}

function loadMode(that){
    $('#modal-neutral-body').empty();
    $('#modal-neutral-header').children().show();
    $('#modalLoginAvatarDemo').modal();
    let varCtl = {
        slug : $(that).data('slug'),
        field : $(that).data('field'),
        id : $(that).data('id')
    }
    $.ajax({
        url: `/admin/${varCtl.slug}/${varCtl.id}/get-field/${varCtl.field}`,
        method: "get",
        dataType: "html",
        error: function (xhr, ajaxOptions, thrownError) {
        },
        success: function (output, status, xhr) {
            if(output == '') output = '<h1>Conteúdo vazio<h1>';
            $('#modal-neutral-header').children().fadeOut();
            $('#modal-neutral-body').append(output);
        }
    }).done(function(data, b, c, d) {
        loadPageListeners();
    });
}

$(function () {
    $("#mdb-lightbox-ui").load("/mdb/mdb-addons/mdb-lightbox-ui.html");
});

$(".button-collapse").sideNav();
$(".button-collapse").on('click', function () {
    if($('#slide-out').hasClass('slim'))$('#toggle').trigger('click');
});
$('.side-nav').on('mouseleave', function(){
    if(!$('#slide-out').hasClass('slim'))$('#toggle').trigger('click');
});
$('.side-nav').on('mouseenter', function(){
    if($('#slide-out').hasClass('slim'))$('#toggle').trigger('click');
});

$('a[data-toggle=tab]').on('click', function(){
    let url = new URL(location.href);
    let params = new URLSearchParams(url.search.slice(1));
    let tab = $(this).attr('data-tab-name');
    tab = tab == undefined ? '' : tab;
    let uri = updateQueryStringParameter(location.href, 'tab', tab);
    history.replaceState({}, {},uri);
});

$('.is_modal').on('click', function (event) {
    loadRelateRecordForm($(this).attr('href'), event);
});

/*pagination*/
function browseBreadListeners(){
    try{listenDeleteButtons();listenToEditRelatedItemButtons();}catch(e){}

    $('#search-form-submit').off('click').on('click', function (e) {
        e.preventDefault();
        $('#paginator').val('1');
        $('#search-form').submit();
    });
    $('#search-form').off('submit').on('submit', function (e) {
        e.preventDefault();
        $('#paginator').val('1');
        $('.daspe-transparent').each(function (index, val) {$(val).removeClass('daspe-transparent');});
        renderPagination();
    });
    $('.page-link').off('click').on('click', function (e) {
        e.preventDefault();
        $('.daspe-transparent').each(function (index, val) {$(val).removeClass('daspe-transparent');});
        let hrefLink = $(this).attr('href');
        var url = new URL(hrefLink);
        $('#paginator').val(url.searchParams.get("page"));
        renderPagination();
    });
    $('.order-field').off('click').on('click', function (index, val) {
        $('.daspe-transparent').each(function (index, val) {$(val).removeClass('daspe-transparent');});
        $("#sort-by").val($(this).data('field'));
        let currentOrder = $('#sort-by-order').val();
        if(currentOrder == ''){
            $('#sort-by-order').val('asc');
        }else if(currentOrder == 'asc'){
            $('#sort-by-order').val('desc');
        }else if(currentOrder == 'desc'){
            $('#sort-by-order').val('');
            $('#sort-by').val('');
        }
        renderPagination();
    });
    initPhotoSwipeFromDOM('.mdb-lightbox');
}

function renderPagination() {
    var el = $('#search-form');
    let action = el.attr('action') + (el.attr('action').endsWith('?') ? '' : '?');
    let query = el.serialize();
    let finalUrl = action + query;
    history.pushState({}, null, finalUrl);
    $.ajax({
        url: finalUrl,
        method: "get",
        dataType: "html",
        data : {'render-ajax' : 'true',},
        error: function (xhr, ajaxOptions, thrownError) {},
        success: function (output, status, xhr) {
            $('#for-ajax-only-render-this-section-content').remove();
            $('#for-ajax-only-render-this-section').append(output);

        }
    }).done(function(data, b, c, d) {
        browseBreadListeners();

    });
}
/*fim pagination*/
