<li>
    <a class="collapsible-header waves-effect arrow-r">
    <i class="sv-slim-icon {{$icon}}"></i>{{$label}}<i class="fas fa-angle-down rotate-icon"></i></a>
    <div class="collapsible-body">
        <ul>
            @foreach($children as $child)
                {!! $child !!}
            @endforeach
        </ul>
    </div>
</li>
