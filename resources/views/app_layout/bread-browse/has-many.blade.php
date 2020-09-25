<div style="max-width: 240px; !important;">
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
            <a href="{{$link}}" class="btn-link white-text" >{{str_limit($relatedData->{$field->displayRelated}, 20) }}</a>
        </div>
    @else
    <div class="badge badge-info m-0 p-0 px-1"
         style="line-height: unset; height: unset;"
            title="{{$relatedData->{$field->displayRelated} }}">
        {{ str_limit($relatedData->{$field->displayRelated}, 20)  }}
    </div>
    @endif
@endforeach
</div>