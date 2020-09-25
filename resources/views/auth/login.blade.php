<!DOCTYPE html>
<html lang="en" class="full-height">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{config('app.name')}} Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" href="/daspeweb_assets/mdb/css/bootstrap.min.css">
    <link rel="stylesheet" href="/daspeweb_assets/mdb/css/mdb.min.css">

    <style>
        /*input:-webkit-autofill,*/
        /*input:-webkit-autofill:hover,*/
        /*input:-webkit-autofill:focus*/
        /*textarea:-webkit-autofill,*/
        /*textarea:-webkit-autofill:hover*/
        /*textarea:-webkit-autofill:focus,*/
        /*select:-webkit-autofill,*/
        /*select:-webkit-autofill:hover,*/
        /*select:-webkit-autofill:focus {*/
            /*border: 1px solid green;*/
            /*-webkit-text-fill-color: green;*/
            /*transition: background-color 5000s ease-in-out 0s;*/
        /*}*/
        .intro-2 {
            background-color: #058e8a;
        }
        .top-nav-collapse {
            background-color: #3f51b5 !important;
        }
        .navbar:not(.top-nav-collapse) {
            background: transparent !important;
        }
        @media (max-width: 768px) {
            .navbar:not(.top-nav-collapse) {
                background: #3f51b5 !important;
            }
        }
        .card {
            background-color: rgba(229, 228, 255, 0.2);
        }

        .md-form .prefix {
            font-size: 1.5rem;
            margin-top: 1rem;
        }
        .md-form label {
            color: #ffffff;
        }
        h6 {
            line-height: 1.7;
        }
        @media (max-width: 740px) {
            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view {
                height: 750px;
            }
        }
        @media (min-width: 741px) and (max-height: 638px) {
            .full-height,
            .full-height body,
            .full-height header,
            .full-height header .view {
                height: 750px;
            }
        }

        .card {
            margin-top: 30px;
            /*margin-bottom: -45px;*/

        }

        .md-form input[type=text]:focus:not([readonly]),
        .md-form input[type=password]:focus:not([readonly]) {
            border-bottom: 1px solid #8EDEF8;
            box-shadow: 0 1px 0 0 #8EDEF8;
        }
        .md-form input[type=text]:focus:not([readonly])+label,
        .md-form input[type=password]:focus:not([readonly])+label {
            color: #8EDEF8;
        }
        .white-skin .dropdown-content li:not(.disabled) span, .white-skin .md-form .prefix.active, .white-skin input[type=email]:focus:not([readonly])+label, .white-skin input[type=text]:focus:not([readonly])+label, .white-skin input[type=password]:focus:not([readonly])+label, .white-skin textarea.md-textarea:focus:not([readonly])+label {
            color: #fff;
        }

        .md-form .form-control {
            color: #fff;
        }
        .label-active-force{
            -webkit-transform: translateY(-140%) !important;
            -ms-transform: translateY(-140%)!important;
            transform: translateY(-140%) !important;
            font-size: 0.9rem !important;
            position: absolute !important;
            color: #8EDEF8;
        }

        input{
            border-bottom: 1px solid #fff !important;
            box-shadow: 0 1px 0 0 #fff !important;
        }
        .bg-main{
            background: -webkit-linear-gradient(45deg, rgba(51, 33, 234, 0.6),rgba(10,23,187,.6) 100%);
        }
        .bg-main-2{
            background-image: linear-gradient(to top, #a3bded 0%, #6991c7 100%);
        }
        .text-main{
            color: #3e35ea !important;
        }
        .text-main-2{
            color: #0A17BB !important;
        }

    </style>

</head>


<body class="fixed-sn white-skin" style="background-image: url('/daspeweb_assets/img/login.jpg')">


<section class="h-100 " >
    <div class="full-bg-img ">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5 mt-5">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card wow fadeIn" data-wow-delay="0.3s">
                        <div class="card-body">
                            <form action="/login" method="post">
                                @csrf
                                <div class="form-header bg-main">
                                    <h3><i class="fa fa-user mt-2 mb-2"></i>Login</h3>
                                </div>


                                <div class="md-form">
                                    <i class="fa fa-envelope prefix white-text"></i>
                                    <input type="text" id="email" name="email" class="form-control" value="{{old('email')}}">
                                    <label for="email" class="label-active-force">E-mail</label>
                                </div>

                                <div class="md-form">
                                    <i class="fa fa-lock prefix white-text"></i>
                                    <input type="password" id="password" class="form-control" name="password">
                                    <label for="password" class="label-active-force">Senha</label>
                                </div>


                                <div class="text-center">

                                    <button class="btn btn-block bg-main btn-lg p-0 py-2">Entrar</button>
                                    <a href="/register" class="btn btn-block bg-main btn-lg p-0 py-2">Me cadastrar</a>
                                    <hr>
                                    <div class="w-100 d-grid d-md-flex ">
                                        @if(config('daspeweb.auth.facebook'))
                                        <a href="/login/facebook"
                                           class="btn btn-outline-primary waves-effect btn-outline-white btn-block mx-0 mr-md-1 p-0 py-2 ">
                                            <i class="fab fa-facebook-square pr-2 "></i>Entrar com Facebook</a>
                                        @endif
                                        @if(config('daspeweb.auth.google'))
                                            <a href="/login/google"
                                            class="btn btn-outline-primary waves-effect btn-outline-white mx-0 mr-md-1 p-0 py-2  col-12 col-md-6">
                                            <i class="fab fa-google pr-2"></i>Login com Google</a>
                                        @endif
                                    </div>
                                    <hr>
                                    <div class="text-right">
                                        <small ><a href="/password/reset" class="white-text text-right">Esqueceu sua senha?</a> </small>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="/daspeweb_assets/mdb/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/mdb/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/daspeweb_assets/mdb/js/mdb.min.js"></script>
<script>
    new WOW().init();
</script>
</body>
</html>
