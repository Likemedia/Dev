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

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <!-- Place favicon.ico in the root directory -->
    {{--<link rel="stylesheet" href="//www.orangehilldev.com/jstree-bootstrap-theme/demo/assets/dist/themes/proton/style.css" />--}}

    <link rel="stylesheet" href="{{asset('css/normalize.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    {{--<link rel="stylesheet" href="{{asset('css/toastr.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    {{--<link rel="stylesheet" href="{{asset('css/chosen.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/dropzone.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox-buttons.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/fancybox/jquery.fancybox-thumbs.css')}}">--}}

    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/demo.css')}}">--}}
    <link rel="stylesheet" type="text/css" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

{{--    <script src="{{asset('js/jquery-2.1.4.js')}}"></script>--}}
{{--    <script src="{{asset('js/jsvalidation.js')}}"></script>--}}
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/toastr.js')}}"></script>

    {{-- name-slug --}}
    <script src="{{asset('js/jquery.tablednd_0_5.js')}}"></script>


    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
{{--    <script src="{{asset('js/chosen.jquery.js')}}"></script>--}}
{{--    <script src="{{asset('js/dropzone.js')}}"></script>--}}
{{--    <script src="{{asset('js/dropzone-config.js')}}"></script>--}}
    {{--<script src="{{asset('js/fancybox/jquery.fancybox.js')}}"></script>--}}
    {{--<script src="{{asset('js/fancybox/jquery.fancybox-buttons.js')}}"></script>--}}
    {{--<script src="{{asset('js/fancybox/jquery.fancybox-thumbs.js')}}"></script>--}}
    {{--<script src="{{asset('js/fancybox/jquery.mousewheel.js')}}"></script>--}}
    <script src="{{asset('js/jquery.mjs.nestedSortable.js')}}"></script>

    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-green.css') }}">
    <script src="{{asset('js/jquery.nestable.js')}}"></script>
    <script src="{{asset('js/validation.js')}}"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/js/lightbox.min.js"></script>--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.9.0/css/lightbox.min.css">--}}

    {{--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/themes/default/style.min.css" />--}}
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.3/jstree.min.js"></script>--}}

</head>

<body>

    <div class="main-wrapper">
        <div class="app" id="app">
            <header class="header">
                @yield('nav-bar')
            </header>

        @yield('left-menu')

        <div class="sidebar-overlay" id="sidebar-overlay"></div>
        <article class="content items-list-page">
            @yield('content')
        </article>

        @yield('footer')

        </div>
    </div>


</body>
</html>
