<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>{{trans('variables.title_page')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->
     <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/chosen.css')}}">
    <link rel="stylesheet" href="{{asset('css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox-buttons.css')}}">
    <link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox-thumbs.css')}}">
    <script src="{{asset('js/jquery-2.1.4.js')}}"></script>
    <script src="{{asset('js/jsvalidation.js')}}"></script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/toastr.js')}}"></script>
    <script src="{{asset('js/jquery.tablednd_0_5.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/chosen.jquery.js')}}"></script>
    <script src="{{asset('js/dropzone.js')}}"></script>
    <script src="{{asset('js/dropzone-config.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.fancybox-buttons.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.fancybox-thumbs.js')}}"></script>
    <script src="{{asset('js/fancybox/jquery.mousewheel.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-green.css') }}">
   
</head>
    </head>

    <body>
        <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
                            <div class="logo"> <span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span> <span class="l l4"></span> <span class="l l5"></span> </div> Like Media Admin </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-xs-center">{{ trans('variables.login') }}</p>

                     	<form class="login-form" role="form" method="POST" action="{{ url('/auth/login') }}" id="login-form">
							
                                <div class="form-group">
                                	<label for="username">{{ trans('variables.login_text') }}</label>
                                	<input type="text" class="form-control underlined" name="login" id="username" placeholder="{{ trans('variables.your_login') }}" required>
                                </div>
                            
                                <div class="form-group">
                                	<label for="password">{{ trans('variables.password_text') }}</label> 
                                	<input type="password" class="form-control underlined" name="password" id="password" placeholder="{{ trans('variables.your_password') }}" required> 
                                </div>

                            <input type="submit" class="btn btn-block btn-primary" onclick="saveForm(this)" data-form-id="login-form" value="{{ trans('variables.sing_in') }}"/> 
                           
                            
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            
                        </form>

                    </div>
                </div>
                <div class="text-xs-center">
                    <a href="{{ url('/') }}" class="btn btn-secondary rounded btn-sm"> <i class="fa fa-arrow-left"></i> {{ trans('variables.go_to_the_site') }} </a>
                </div>
            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
       
{{--        <!-- <script src="{{ asset('js/vendor.js') }}"></script> -->--}}
        {{--<!-- <script src="{{ asset('js/app.js') }}"></script> -->--}}
    </body>

</html>


@section('footer')
	<footer>
		@include('admin.footer')
	</footer>
@stop

