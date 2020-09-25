@php
    //dd($data, $options);
    //$details = json_decode($options);
        $t = '';//preg_replace('/(.*)({id})/', '${1}'.$data->id, $details->url)    ;
@endphp
@foreach($data->{$options->method} as $relatedData)
    {{--<a href="{{$t}}" class="btn-link" style="color: #4285f4 !important;">{{$relatedData->{$options->label} }}</a>--}}
    <div class="chip blue lighten-4 m-0 p-0 px-1"
         style="line-height: unset; height: unset;"
            title="{{$relatedData->{$options->label} }}">
        {{ str_limit($relatedData->{$options->label}, 20)  }}
    </div>
@endforeach