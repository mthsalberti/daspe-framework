<div class="col-12 mb-12 d-flex align-items-stretch">
    <div class="md-form form-sm w-100">
        @if($read)
            @php $teethJson = json_decode($data->{$row->field}) ;  @endphp
            <div class="col-12  d-flex  row mb-3" id="faces_control">
                @foreach($teethJson as $teeth => $faces)
                <div id="faces_control_11" class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 p-0">
                    <div class="tooth-face-area border-grey-light d-flex p-1 m-1 justify-content-around ">
                        <div class=""><i class="fas fa-tooth blue-text"></i> <span class="blue-text">11</span></div>
                        @foreach(['M', 'O-I', 'D', 'V', 'L-P'] as $face)
                        <div class="form-check m-0 pr-1 ">
                            <input @if( isset($faces->{$face})) checked @endif disabled name="dentes-faces-{{$teeth}}-{{$face}}"
                                   type="checkbox" class="form-check-input" id="{{$teeth}}-{{$face}}">
                            <label class="form-check-label pl-4 position-static" for="{{$teeth}}-{{$face}}">{{$face}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @else
            {{--<input type="{{isset($money) ? 'number' :  'text'}}"--}}
                   {{--name="{{$row->field}}"--}}
                   {{--id="{{$row->field}}"--}}
                   {{--class="form-control "--}}
                   {{--value="@if( isset($readonly)){{$data->{$row->field} }}@else{{old($row->field)}}@endif"--}}
                   {{--@if( isset($readonly)) readonly @endif>--}}
            {{--@if(! isset($readonly)) @include('daspeweb::app_layout.bread-add-edit.hasError', ['field' => $row->field]) @endif--}}
        @endif

        <label class="active label-active-force" for="{{$row->field}}" style="white-space: nowrap">{{$row->display_name}}</label>
    </div>
</div>
