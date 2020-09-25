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
            background-color: white;
        }
        .top-nav-collapse {
            background-color: white !important;
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
            color: #ffac44;
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

<body class="fixed-sn white-skin" style="    background-color: #058e8a;">
<header>
    <section class="view ">
        <div class="full-bg-img ">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5 mt-5">
                        <div class="card wow fadeIn" data-wow-delay="0.3s">
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                                    @csrf
                                    <div class="form-header bg-main mb-2">
                                        <h3><i class="fa fa-user mt-2 mb-2"></i>Redefinir senha</h3>
                                    </div>
                                    <div class="md-form mt-5">
                                        <i class="fa fa-lock prefix white-text"></i>
                                        <input type="email" id="email" class="form-control mb-1" name="email" value="{{ old('email') }}" required>
                                        <label for="email" class="label-active-force">Seu e-email</label>
                                        <div class="position-absolute pl-5">
                                            @if($errors->has('email')) <small class="red-text white px-1">{{$errors->first('email')}}</small> @endif
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-block bg-main btn-lg p-0 py-2">Criar nova senha</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</header>
<script src="/js/jquery-3.2.1.min.js"></script>
</body>
</html>
