@extends('daspeweb::app_layout.master')

@section('page_header')
@stop

@section('content')
<div class="container-fluid">
    <section class="section team-section">
        <div class="row">
            <div class="col-md-4 ">

                <!--Card-->
                <div class="card">

                    <div class="card-body pt-0 mt-0">
                        @foreach($model->rows as $field)
                            @if($field->field == 'id')
                                @continue
                            @elseif($loop->iteration == 2)
                                <div class="text-center">
                                    <h3 class="mb-3 font-bold text-left blue-text"><strong>{{$data->{$field->field} }}</strong></h3>
                                </div>
                            @else
                                @if($loop->iteration == 3)
                                    <ul class="striped list-unstyled">
                                @endif
                                    @if($field->read)
                                        <li>
                                            @if($field->type == 'relationship')
                                                @php $details = json_decode($field->details); @endphp
                                                <strong class="blue-grey-text">{{$details->mainlabel}}</strong><br>
                                            @else
                                                <strong class="blue-grey-text">{{$field->display_name}}</strong><br>
                                            @endif
                                            @if($field->type == 'text') @include('daspeweb::app_layout.show.text')
                                            @elseif($field->type == 'date') @include('daspeweb::app_layout.show.date')
                                            @elseif($field->type == 'timestamp') @include('daspeweb::app_layout.show.timestamp')
                                            @elseif($field->type == 'relationship')
                                                @include('daspeweb::app_layout.show.relationship', ['field' => $field, 'data' => $data])
                                            @else !!!!definir tipo do dado
                                            @endif
                                        </li>
                                    @endif
                                @if($loop->last)
                                    </ul>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row mb-1">
                    <div class="col-md-9">
                        <h4 class="h4-responsive mt-1">Your Clients</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="md-form">
                            <input placeholder="Search..." type="text" id="form5" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <!-- Tabs -->
                        <!-- Nav tabs -->
                        <div class="tabs-wrapper">
                            <ul class="nav classic-tabs tabs-primary primary-color" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link waves-light active waves-effect waves-light" data-toggle="tab" href="#panel83" role="tab">Personal Clients</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link waves-light waves-effect waves-light" data-toggle="tab" href="#panel84" role="tab">Corporate Clients</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Tab panels -->
                        <div class="tab-content card">
                            <!--Panel 1-->
                            <div class="tab-pane fade show active" id="panel83" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Abby</td>
                                            <td>Barrett</td>
                                            <td>@abbeme</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Danny</td>
                                            <td>Collins</td>
                                            <td>@dennis</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Clara</td>
                                            <td>Ericson</td>
                                            <td>@claris</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Jessie</td>
                                            <td>Doe</td>
                                            <td>@jessiedoeofficial</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>Saul</td>
                                            <td>Hudson</td>
                                            <td>@slash</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.Panel 1-->
                            <!--Panel 2-->
                            <div class="tab-pane fade" id="panel84" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Company Name</th>
                                            <th>Username</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>PiedPiper</td>
                                            <td>@piedpiper</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Github, Inc</td>
                                            <td>@github</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Twitter, Inc</td>
                                            <td>@twitter</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td>Alphabet, Inc</td>
                                            <td>@alphabet</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td>Adobe Corporation</td>
                                            <td>@adobe</td>
                                            <td>
                                                <a class="blue-text" data-toggle="tooltip" data-placement="top" title="See results"><i class="fa fa-user"></i></a>
                                                <a class="teal-text" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a class="red-text" data-toggle="tooltip" data-placement="top" title="Remove"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/.Panel 2-->
                        </div>
                        <!-- /.Tabs -->
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@stop

@section('css')
@stop


@section('javascript')

@stop
