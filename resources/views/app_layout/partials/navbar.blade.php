<nav class="main-padding-left-control py-0 navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
    <div class="float-left">
        <a href="#" data-activates="slide-out" class="button-collapse">
            <i class="fas fa-bars"></i>
        </a>
    </div>
    <div class="mr-auto">
        <ol class="breadcrumb clearfix d-none d-md-inline-flex pt-0">
            <?php $breadcrumb_url = url(''); ?>
            @foreach(Request::segments() as $seg)
                @if(isset($getOut)) @continue @endif
                @if($loop->iteration == 1)
                    <li>{{ config('app.name') }}</li>
                @elseif($loop->iteration == 2)
                    @php
                        $modelInfo = \Daspeweb\Framework\DaspewebHelper::info(\Daspeweb\Framework\DaspewebHelper::slug());
                        $pluralName = $modelInfo <> null ? $modelInfo->plural_name : '';
                    @endphp
                    @if($pluralName <> '')
                        <li><i class="fa fa-angle-double-right mx-2 " aria-hidden="true"></i> <a class="text-lowercase blue-text btn-link" href="/admin/{{$seg}}">ver {{$pluralName }}</a> </li>
                    @endif
                    @php if($pluralName == '') $getOut = true; @endphp
                @elseif($seg == "edit")
                    <li><i class="fa fa-angle-double-right mx-2 " aria-hidden="true"></i>Edição</li>
                @elseif($seg == "create")
                    <li><i class="fa fa-angle-double-right mx-2 " aria-hidden="true"></i>Criação</li>
                @elseif(is_numeric($seg))
                @endif
            @endforeach
        </ol>
    </div>
    <ul class="navbar-nav ml-auto nav-flex-icons">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i>{{\Illuminate\Support\Facades\Auth::user()->name}}
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-unique" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item waves-effect waves-light" href="/admin/profiles/{{\Illuminate\Support\Facades\Auth::user()->id}}"><i class="far fa-user-circle"></i> Perfil</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item waves-effect waves-light">
                        <i class="fas fa-sign-out-alt"></i>
                        Sair
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
