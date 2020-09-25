<div class="{{\Src\bread\BreadHelper::handleWidth($options)}} mb-3 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @if($read)
            @php
                $link = '#';
                dd($modelInstance, $options);
                if ($modelInstance->{$options->method} != null){
                    $link = preg_replace('/(.*)({id})/', '${1}'.$modelInstance->{$options->id}, $options->url);
                }
            @endphp
            {{--<a href="{{$link}}" class="form-control blue-text border-0" style="border-bottom: 1px solid #bdbdbd !important;">--}}
            {{--{{ $modelInstance->{$options->method} != null ?  $modelInstance->{$options->method}->{$options->label} : '-' }}--}}
            {{--</a>--}}
            {{--<label class="active label-active-force" >{{$row->display_name}}</label>--}}
        @else
            <select class="mdb-select colorful-select dropdown-primary mt-2" multiple
                    name="{{$row->field}}[]"
                    id="{{$row->field}}">
                @foreach(app($options->model)::all() as $rowOption)
                    <option value="{{ $rowOption->id }}"
                            @if((!$create && $rowOption->id == $modelInstance->{$options->show}) ||  $create && $loop->iteration == 1 ) selected @endif >@foreach($options->fieldstoshow as $fieldToShowAux){{ $rowOption->{$fieldToShowAux} }} @endforeach
                    </option>
                @endforeach
            </select>
            <label class="label-active-force">{{$row->display_name}}</label>
            @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $row->field])
        @endif
    </div>
</div>
