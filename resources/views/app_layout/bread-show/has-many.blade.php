<div class="{{$field->width}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
            @foreach($modelInstance->{$field->method} as $relatedData)
                @if($field->relatedLink != null)
                    @php
                        $link = '';
                        if($field->relatedLink != null){
                            $link = preg_replace('/(.*)({id})/', '$1' , $field->relatedLink) . $relatedData->id;
                        }
                    @endphp
                    <div class="badge badge-info m-0 p-0 px-1"
                         style="line-height: unset; height: unset;"
                         title="{{$relatedData->{$field->displayRelated} }}">
                        <a href="{{$link}}" class="btn-link white-text" >{{str_limit($relatedData->{$field->displayRelated}, 200) }}</a>
                    </div>
                @else
                    <div class="badge badge-info m-0 p-0 px-1"
                         style="line-height: unset; height: unset;"
                         title="{{$relatedData->{$field->displayRelated} }}">
                        {{ str_limit($relatedData->{$field->displayRelated}, 20)  }}
                    </div>
                @endif
            @endforeach
        <label class="active label-active-force" for="{{$field->apiName}}" style="white-space: nowrap">{{$field->label}}</label>
    </div>
</div>


