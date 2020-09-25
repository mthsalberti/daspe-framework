@php
    $fieldToSelectOriginal = [];
    $loadAll = false;
    if (request()->has('fields_to_select')){
        $fieldToSelectOriginal = json_decode(request()->input('fields_to_select'));
    }
    if(count($fieldToSelectOriginal) == 1){
        $loadAll = true;
    }

    $fieldListToLoad = $is_related_list || $loadAll
        ? \Daspeweb\Framework\DaspewebHelper::getModelBySlug($slug)::fields()
        : \Daspeweb\Framework\DaspewebHelper::getModelBySlug($slug)::fieldsForBrowseView();
    if(!$loadAll && $is_related_list){
        $fieldListToLoad = $fieldListToLoad->filter(function ($item) use ($fieldToSelectOriginal){
            return in_array($item->apiName, $fieldToSelectOriginal);
        });
    }
@endphp
<thead>
<tr class="p-1">
    @if(!$is_related_list)
        <th class="m-0 p-0"></th>
    @endif

    @if (isset($is_async))
        @foreach($relatedData->dataTypeRelated->rows as $row)
            @if(in_array($row->field, $fields))
                <th class="m-0 p-1 order-field" data-field="{{ $row->field }}" >
                    <span>{{$row->display_name}}</span>
                </th>
            @endif
        @endforeach
    @else
        @foreach($fieldListToLoad as $field)
            {{--@if($is_related_list && !in_array($field->apiName, $fieldToSelectOriginal)) @continue @endif--}}
            <th class="m-0 p-1 order-field" data-field="{{$field->apiName}}">
                @if(in_array(get_class($field), [
                'Daspeweb\Framework\Field\Money',
                'Daspeweb\Framework\Field\Percentual',
                'Daspeweb\Framework\Field\Integer']))
                    <span class="float-right">{{$field->label}}</span>
                @else
                    <span>{{$field->label}}</span>
                @endif
                @if(request()->input('sort-by') == $field->apiName)
                    @if(request()->input('sort-by-order') == 'asc')
                        <i class="fas fa-sort-amount-up"></i>
                    @else
                        <i class="fas fa-sort-amount-down"></i>
                    @endif
                @endif
            </th>
        @endforeach
        @if(!$is_related_list)
            <th class="m-0 p-1 justify-content-end text-right">
                <span>Ações</span>
            </th>
        @endif
    @endif
</tr>
</thead>
<tbody>
@if(!isset($is_async))
    @foreach($dataTypeContent as $data)@php $modelInstance = $data;@endphp
    <tr data-id="{{$data->id}}">
        @if(!$is_related_list)
            <td class="mt-0 p-1" style="min-width: 18px;vertical-align: middle !important;">
                <div class="form-check form-check-inline">
                    <input type="checkbox" id="checkbox_{{ $data->getKey() }}" class="form-check-input checkbox_line" data-id="{{$data->id}}">
                    <label for="checkbox_{{ $data->getKey() }}" class="label-table"></label>
                </div>

            </td>
        @endif
        @foreach($fieldListToLoad as $field)
            {{--@if($is_related_list && !in_array($field->apiName, $fieldToSelectOriginal)) @continue @endif--}}
            {{--@if(!$is_related_list && !$row->browse) @continue @endif--}}
            <td class="mt-0 p-2 " style="vertical-align: middle !important;">
                {!! $field->renderBrowseView($data)  !!}
            </td>
        @endforeach
        <th class="mt-0 p-0" style="    vertical-align: middle;">
            <div class="btn-group btn-group-sm p-0 m-0 pull-right" role="group" aria-label="Basic example" style="float: right;">
                @if(method_exists($modelInstance, 'extraActions'))
                    @foreach($modelInstance->extraActions() as $action)
                        @if($action->onBrowseView && $action->checkCriteria($modelInstance))
                            <a href="{{$action->makeLink($modelInstance)}}"
                               target="{{$action->target}}"
                               style="white-space: nowrap;text-transform: unset !important; padding: 2px 8px 2px 8px !important;" title="{{$action->name}}"
                               data-id="{{$modelInstance->id}}"
                               class="btn btn-primary pull-right d-flex edit
                                {{$action->makeCssClass()}} {{$action->extraClass}}">
                                <span class="pr-1">{!! $action->icon !!}</span> {{$action->name}}
                            </a>
                        @endif
                    @endforeach
                @endif

                @if($canRead)
                    <a href="/admin/{{$slug}}/{{$data->id}}" title="Ver" class="btn btn-outline-white pull-right "
                       style="padding: 2px 8px 2px 8px !important;">
                        <i class="fas fa-eye blue-text"></i>
                    </a>
                @endif
                @if($canEdit)
                    <a href="/admin/{{$slug}}/{{$data->id}}/edit" title="Editar" class="btn btn-outline-white pull-right edit is-related-list {{$is_related_list ? 'is-related-list' : '' }}"
                       style="padding: 2px 8px 2px 8px !important;">
                        <i class="fas fa-edit blue-text"></i>
                    </a>
                @endif
                @if($canDelete)
                    <a href="javascript:;" title="Excluir" class="btn btn-outline-white delete-modal {{$is_related_list ? 'is-related-list' : '' }}" data-id="{{ $data->id }}" data-url="/admin/{{$slug}}"
                       style="padding: 2px 8px 2px 8px !important;">
                        <i class="fas fa-trash text-danger"></i>
                    </a>
                @endif
            </div>
        </th>
    </tr>
    @endforeach
@endif
</tbody>
