@php $iconFinal = $menu->icon == null ? 'fas fa-atom' : $menu->icon; @endphp
<li>
    <a href="{{$menu->slug}}" class="waves-effect" title="{{$menu->plural_name}}">
        <span class="sv-slim"> <i class="{{$iconFinal}}"></i> </span>
        <span class="sv-normal"><i class="{{$iconFinal}} pr-1"></i>{{$menu->plural_name}}</span>
    </a>
</li>
