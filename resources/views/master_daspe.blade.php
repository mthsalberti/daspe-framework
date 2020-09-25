<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="height: 100%">
<head>
    <title>@yield('page_title', config('app.name'))</title>
    <link rel="icon" type="image/png" href="{{config('daspeweb.favicon_path')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="api-token" content="{{ \Auth::user()->api_token }}"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css">
    <link rel="stylesheet" href="/daspeweb_assets/mdb/css/bootstrap.min.css">
    <link rel="stylesheet" href="/daspeweb_assets/mdb/css/mdb.min.css">
    <link rel="stylesheet" href="/daspeweb_assets/js/MDB_File_Upload/css/addons/mdbFileUpload.min.css">
    <link rel="stylesheet" href="/daspeweb_assets/js/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/daspeweb_assets/css/daspeweb/daspeweb.min.css">
    <link rel="stylesheet" href="/daspeweb_assets/css/card/card.css">

    {{--@include('daspeweb::style.style')--}}

    @yield('css')
    @yield('head')
</head>

<body class="fixed-sn white-skin" style="overflow: visible !important; ">


<header style="height: 0">
    @include('app_layout.partials.sidebar')
    @include('app_layout.partials.navbar')
</header>

<main class="main-padding-left-control"  style="height: 100%; padding-top: 42px;">
    <div id="mdb-lightbox-ui"></div>
    <div class="container-fluid p-0">
        @yield('content')
    </div>
</main>

@include('daspeweb::app_layout.partials.delete-modal')
@include('daspeweb::app_layout.partials.modal-neutral')

<script type="text/javascript" src="/daspeweb_assets/mdb/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/mdb/js/popper.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/mdb/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/mdb/js/mdb.min.js"></script>

<script type="text/javascript" src="/daspeweb_assets/js/momentjs/moment.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/momentjs//moment-with-locales.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/jquery-number-master/jquery.number.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/MDB_File_Upload/js/addons/mdbFileUpload.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/daspeweb/browse-filter.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/daspeweb/modal-controler.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/daspeweb/spinner.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/daspeweb/global.js"></script>
<script type="text/javascript" src="/daspeweb_assets/js/card/jquery.card.js"></script>


<script>
    let filterController = new FilterBrowseControl(
        "{{\Daspeweb\Framework\DaspewebHelper::slug()}}",
        "{{@\Daspeweb\Framework\DaspewebHelper::info()->id}}",
        "{{\Auth::user()->id}}"
    );
    @include('daspeweb::app_layout.partials.js-alerts')
</script>

@include('daspeweb::app_layout.partials.delete-modal-js')
@if(view()->exists('global-assets.js'))
    @include('global-assets.js')
@endif
@yield('javascript')
</body>
</html>
