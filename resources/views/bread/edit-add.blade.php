@extends('daspeweb::master_daspe')

@section('content')
    @include('daspeweb::app_layout.bread-add-edit.partials.main-content')
@stop

@section('javascript')
    @parent
    @include('daspeweb::app_layout.bread-add-edit.partials.main-javascript')
@stop
