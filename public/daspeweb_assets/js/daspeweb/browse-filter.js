class FilterBrowseControl{
    constructor(slug, dwModelId, userId){
        this.slug = slug;
        this.dw_model_id = dwModelId;
        this.user_id = userId;
        this.loadFilterBrowse();
        this.listenToFilterBrowseButton();
    }
    listenToFilterBrowseButton(){
        let self = this;
        $('#modal-filter-ready').off('click').on('click', function () {
            //recarregar a página
        });
        $('.modal-filter').off('click').on('click', function () {
            $.ajax({
                type: 'GET',
                url: '/admin/filter-control/get-options/'+self.slug,
                success: function (data) {
                    $('#modal-filter-field-choice').empty();
                    $('#modal-filter-field-choice').append(`
                        <div>
                            <select id="modal-filter-field-choice-select" class="mdb-select md-form colorful-select dropdown-primary">
                                <option selected disabled>campos</option>
                            </select>
                            <label>Escolha um campo</label>
                        </div>`);
                    let selectEle = $('#modal-filter-field-choice-select');
                    $.each(data, function (index, item) {
                        selectEle.append(`<option data-field-options='${JSON.stringify(item.options)}' data-field-type="${item.internalName}" value="${item.apiName}">${item.label}</option>`);
                    });
                    listenToFormFieldsFuncionalities();//função global
                    self.listenToFilterBrowseButton();
                },
                error: function (data) {
                    console.error(data);
                }
            });
            self.loadFilterBrowse();
        });
        $('#modal-filter-field-choice-select').off('change').on('change', function () {

            $('#modal-filter-field-choice-date-criteria-type').empty();
            $('#modal-filter-field-choice-value').empty();
            $('#modal-filter-field-choice-criteria').empty();
            let fieldType = $('#modal-filter-field-choice-select option:selected').attr("data-field-type");
            //internalName

            if ($.inArray(fieldType, ['id', 'text', 'email', 'cpf', 'cnpj', 'rg', 'cep', 'phone', 'belongsTo']) > -1) {
                $('#modal-filter-field-choice-criteria').append(`
                    <select id="modal-filter-field-choice-criteria-select" class="mdb-select md-form colorful-select dropdown-primary">
                        <option selected disabled>critérios</option>
                        <option value="=">igual</option>
                        <option value="<>">não igual</option>
                        <option value="like">contém</option>
                        <option value="not like">não contém</option>
                        <option value="starts with">começa com</option>
                        <option value="ends with">termina com</option>
                    </select>
                `);
            }
            if ($.inArray(fieldType, ['integer', 'money', 'number']) > -1) {
                $('#modal-filter-field-choice-criteria').append(`
                    <select id="modal-filter-field-choice-criteria-select" class="mdb-select md-form colorful-select dropdown-primary">
                        <option selected disabled>critérios</option>
                        <option value=">">maior</option>
                        <option value=">=">maior ou igual</option>
                        <option value="<">menor</option>
                        <option value="<=">menor ou igual</option>
                        <option value="=">igual</option>
                        <option value="<>">diferente</option>
                    </select>`);
            }
            if ($.inArray(fieldType, ['date', 'timestamp']) > -1) {
                $('#modal-filter-field-choice-criteria').append(`
                    <select id="modal-filter-field-choice-criteria-select" class="mdb-select md-form colorful-select dropdown-primary">
                        <option selected disabled>critérios</option>
                        <option value="=">igual</option>
                        <option value=">">maior</option>
                        <option value=">=">maior ou igual</option>
                        <option value="<">menor</option>
                        <option value="<=">menor ou igual</option>
                    </select>`);
                $('#modal-filter-field-choice-date-criteria-type').append(`
                    <select id="modal-filter-field-choice-date-criteria-type-value" class="mdb-select md-form colorful-select dropdown-primary">
                        <option selected value="fixed">fixa</option>
                        <option value="relative">relativa</option>
                    </select>
                `);
            }
            if ($.inArray(fieldType, ['selectdropdown', 'checkbox']) > -1) {
                $('#modal-filter-field-choice-criteria').append(`
                    <select id="modal-filter-field-choice-criteria-select" class="mdb-select md-form colorful-select dropdown-primary">
                        <option selected disabled>critérios</option>
                        <option value="=">igual</option>
                        <option value="<>">diferente</option>
                    </select>
                    <label>Escolha um campo</label>
                `);
            }
            listenToFormFieldsFuncionalities();//função global
            self.listenToFilterBrowseButton();
        });

        $('#modal-filter-field-choice-criteria-select').off('change').on('change', function () {
            let fieldType = $('#modal-filter-field-choice-select option:selected').attr("data-field-type");
            $('#modal-filter-field-choice-value').empty();
            if($.inArray(fieldType, ['checkbox']) > -1){
                self.appendFilterForcheckboxValue();
            }
            else if($.inArray(fieldType, ['selectdropdown']) > -1){
                self.appendFilterForSelectValue();
            }
            else if($.inArray(fieldType, ['date', 'timestamp']) > -1){
                self.appendFilterForDateValue();
                listenToFormFieldsFuncionalities();
            }
            else{
                self.appendFilterAnyValue();
            }
            self.listenToFilterBrowseButton();
        });

        $('#modal-filter-field-choice-date-criteria-type-value').off('change').on('change', function (e) {
            self.appendFilterForDateValue();
            listenToFormFieldsFuncionalities();//função global
        });

        $('#modal-filter-save').off('click').on('click', function () {
            let label = $('#modal-filter-save').text();
            if(label == 'confirmar'){
                let spinnerC = new SpinnerController();
                $.ajax({
                    url: '/admin/api/list_views/raw',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method: "post",
                    data: {
                        name: $('#new-view-list-name').val(),
                        is_only_for_me: $('[id=only-for-this-list-view]:checked').length,
                        user_id: self.user_id,
                        dw_model_id: self.dw_model_id
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr["error"]("Algo deu errado. :( ");
                        spinnerC.disable();
                    },
                    success: function (output, status, xhr) {
                        let currentFilters = JSON.parse(localStorage.getItem("filter-"+self.slug));
                        let spinnerC = new SpinnerController();
                        $.each(currentFilters, function (index, item) {

                            $.ajax({
                                url: '/admin/api/list_view_criterias/raw',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                method: "post",
                                data: {
                                    list_view_id: output.id,
                                    field_type: item.fieldType,
                                    field_api: item.fieldApi,
                                    field_label: item.criteriaLabel,
                                    criteria_api: item.criteriaApi ,
                                    criteria_label: item.criteriaLabel,
                                    value: item.value,
                                    value_api: item.valueApi == "undefined" ? item.value : item.valueApi,
                                },
                                success: function (outputChild, status, xhr) {                                        ;
                                    history.replaceState({}, {},updateQueryStringParameter(location.href, 'view_id', output.id));
                                    location.reload();
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    toastr["error"]("Algo deu errado. :( ");
                                    spinnerC.disable();
                                },
                            });
                        });
                        localStorage.setItem("filter-"+self.slug, []);
                    }
                });
            }else{
                let ele = `
                    <div class="bottom md-form w-100  white" >
                      <input type="text" id="new-view-list-name" class="form-control">
                      <label for="new-view-list-name" class="">Digite o nome aqui...</label>
                    </div>
                    <div class="form-check pl-0">
                        <input type="checkbox" class="form-check-input" id="only-for-this-list-view" value="1">
                        <label class="form-check-label" for="only-for-this-list-view">Somente para mim</label>
                    </div>`;
                $("#modal-filter").find('.modal-body').append(ele);
                $('#new-view-list-name').focus();
                $('#modal-filter-save').text('confirmar');
            }
        });

        $('#modal-filter-apply').off('click').on('click', function () {
            let fieldType = $('#modal-filter-field-choice-select option:selected').attr("data-field-type")
            let val = $('[name="modal-filter-field-choice-value-input"]:checked').val();
            let valApi = val;
            if(fieldType === 'checkbox'){
                val = valApi == "0" ? "falso" : "verdadeiro";
            }
            if(val == undefined){
                val = $('[name="modal-filter-field-choice-value-input"]').val();
            }
            if (valApi == undefined) valApi = val;
            self.appendFilterBrowse({
                fieldType: fieldType,
                fieldLabel: $('#modal-filter-field-choice-select option:selected').text(),
                fieldApi: $('#modal-filter-field-choice-select option:selected').attr('value'),
                criteriaLabel: $('#modal-filter-field-choice-criteria-select option:selected').text(),
                criteriaApi: $('#modal-filter-field-choice-criteria-select option:selected').attr('value'),
                value: val,
                valueApi: valApi,
            });
            self.saveFilterLocalStorage();
            self.listenToFilterBrowseButton();
        });
        $('.delete-modal-filter-item').on('click', function () {$(this).closest('li').remove();self.saveFilterLocalStorage();});
    }
    appendFilterBrowse(objAux){
        $('#modal-filter-already-set-fields ul').append(`
                <li class="list-group-item">
                    <input type="hidden" name="temporary-filter-field-type[]" value="${objAux.fieldType}"/>
                    <input type="hidden" name="temporary-filter-field-label[]" value="${objAux.fieldLabel}"/>
                    <input type="hidden" name="temporary-filter-field-apiName[]" value="${objAux.fieldApi}"/>
                    <input type="hidden" name="temporary-filter-criteria-label[]" value="${objAux.criteriaLabel}"/>
                    <input type="hidden" name="temporary-filter-criteria-apiName[]" value="${objAux.criteriaApi}"/>
                    <input type="hidden" name="temporary-filter-value[]" value="${objAux.value}"/>
                    <input type="hidden" name="temporary-filter-valueApi[]" value="${objAux.valueApi}"/>
                    <span class="filter-item-field">${objAux.fieldLabel}</span>
                    <span class="filter-item-criteria">${objAux.criteriaLabel}</span>
                    <span class="filter-item-value">
                        ${objAux.value}</span>
                    <span class="float-right delete-modal-filter-item position-absolute" style="top: 13px; right: 9px"><i class="far fa-times-circle red-text"></i></span>
                </li>
            `);
    }

    appendFilterAnyValue(){
        $('#modal-filter-field-choice-value').append(`
            <div class="md-form mb-2">
              <input type="text" id="modal-filter-field-choice-value-input"
                    name="modal-filter-field-choice-value-input"
                    autocomplete="off"
                    class="form-control">
              <label for="modal-filter-field-choice-value-input">Valor para filtrar</label>
            </div>
        `);
    }

    appendFilterForcheckboxValue(){
        $('#modal-filter-field-choice-value').append(`
            <div class="form-check form-check-inline">
                <input type="radio" id="modal-filter-field-choice-value-input1"
                    class="form-check-input" value="1"
                     name="modal-filter-field-choice-value-input" checked>
                <label class="form-check-label" for="modal-filter-field-choice-value-input1">Verdadeiro</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" id="modal-filter-field-choice-value-input2" class="form-check-input" value="0"
                    name="modal-filter-field-choice-value-input" >
                <label class="form-check-label" for="modal-filter-field-choice-value-input2">Falso</label>
            </div>`);
    }
    appendFilterForSelectValue(){
        let options = JSON.parse($('#modal-filter-field-choice-select option:selected').attr("data-field-options"));
        $('#modal-filter-field-choice-value').append(`
                       <select id="modal-filter-field-choice-value-select-options"
                            name="modal-filter-field-choice-value-input"
                            class="mdb-select md-form colorful-select dropdown-primary" multiple>
                        <option selected disabled>opções</option>
                    </select>
                `);
        let selectEle = $('#modal-filter-field-choice-value-select-options');
        $.each(options, function (index, item) {
            selectEle.append(`<option value="${index}">${item}</option>`);
        });
        listenToFormFieldsFuncionalities();//função global
    }
    appendFilterForDateValue(){
        let fieldType = $('#modal-filter-field-choice-select option:selected').attr("data-field-type");
        let filterType = $('#modal-filter-field-choice-date-criteria-type-value').val();
        $('#modal-filter-field-choice-value').empty();
        $('#modal-filter-field-choice-value').append(`
            <div class="md-form mb-2">
              <input type="text" id="modal-filter-field-choice-value-input"
                    name="modal-filter-field-choice-value-input"
                    autocomplete="off"
                    class="form-control ${filterType == 'fixed' ? fieldType == 'date' ? 'datepicker' : 'input-date-time' : ''}">
              <label for="modal-filter-field-choice-value-input">Digite a data</label>
            </div>`);
    }
    loadFilterBrowse(){
        let self = this;
        let currentRaw = localStorage.getItem("filter-"+self.slug);
        if(currentRaw != null && currentRaw != '') {
            let currentFilters = JSON.parse(currentRaw);
            $('#modal-filter-already-set-fields ul').empty();

            $.each(currentFilters, function (index, item) {
                self.appendFilterBrowse(item);
            });
        }

    }
    saveFilterLocalStorage(){
        let slug = this.slug;
        let objAux = [];
        let inputFieldTypeEle = $('input[name="temporary-filter-field-type[]"]');
        let inputFieldEle = $('input[name="temporary-filter-field-label[]"]');
        let inputFieldApiEle = $('input[name="temporary-filter-field-apiName[]"]');
        let inputFieldCriteriaEle = $('input[name="temporary-filter-criteria-label[]"]');
        let inputFieldCriteriaApiEle = $('input[name="temporary-filter-criteria-apiName[]"]');
        let inputFieldValueEle = $('input[name="temporary-filter-value[]"]');
        let inputFieldValueApiEle = $('input[name="temporary-filter-valueApi[]"]');
        inputFieldEle.each(function (index, item) {
            objAux.push({
                fieldType: inputFieldTypeEle.eq(index).val(),
                fieldLabel: inputFieldEle.eq(index).val(),
                fieldApi: inputFieldApiEle.eq(index).val(),
                criteriaLabel: inputFieldCriteriaEle.eq(index).val(),
                criteriaApi: inputFieldCriteriaApiEle.eq(index).val(),
                value: inputFieldValueEle.eq(index).val(),
                valueApi: inputFieldValueApiEle.eq(index).val(),
            });
        });
        localStorage.setItem("filter-"+slug, JSON.stringify(objAux));
    }
}
