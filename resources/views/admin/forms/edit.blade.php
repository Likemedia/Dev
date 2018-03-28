@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>

    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('forms.index'),
            trans('variables.add_element') => route('forms.create'),
        ]
    ])

    <form class="form-reg" role="form" method="POST" action="{{ route('forms.update', $form->id) }}" id="add-form">
        {{ csrf_field() }} {{ method_field('PATCH') }}

        <div class="form-group">
            <label>Short code</label>
            <input class="form-control" type="text" name="short_code" value="{{ $form->short_code }}">
        </div>

        <div class="list-content">

            <div class="tab-area">
                @include('admin.alerts')
                <ul class="nav nav-tabs nav-tabs-bordered">
                    @if (!empty($langs))
                        @foreach ($langs as $key => $lang)
                            <li class="nav-item">
                                <a href="#{{ $lang->lang }}" class="nav-link  {{ $key == 0 ? ' open active' : '' }}"
                                   data-toggle="tab" data-target="#{{ $lang->lang }}">{{ $lang->descr }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>


            @if (!empty($langs))
                @foreach ($langs as $lang)
                    <div class="tab-content {{ $loop->first ?: ' active-content' }}" id={{ $lang->lang }}>

                        <div class="part full-part">
                            <ul>
                                <li>
                                    <label>{{trans('variables.title_table')}}</label>
                                    <input
                                            class="form-control"
                                            type="text"
                                            name="title_{{ $lang->lang }}"
                                            @foreach($form->translation as $translation)
                                            @if($translation->lang_id == $lang->id)
                                            value="{{ $translation->title }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>
                                <li class="ckeditor">
                                    <label for="body-{{ $lang->lang }}">{{trans('variables.body')}}</label>
                                    <textarea name="body_{{ $lang->lang }}" id="body-{{ $lang->lang }}"
                                              data-type="ckeditor">
                                        @foreach($form->translation as $translation)
                                            @if($translation->lang_id == $lang->id)
                                                {!! $translation->description !!}
                                            @endif
                                        @endforeach
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('body-{{ $lang->lang }}', {
                                            language: '{{$lang}}'
                                        });
                                    </script>
                                </li>

                                <li>
                                    <div id="build-wrap-{{ $lang->lang }}" class="build-wrap"></div>

                                    <input type="hidden" class="build_wrap_{{ $lang->lang }}"
                                           name="build_wrap_{{ $lang->lang }}" value="value">

                                    <script>
                                        jQuery(function ($) {

                                            var fbEditor = document.getElementById("build-wrap-{{ $lang->lang }}");

                                            @foreach($form->translation as $translation)
                                            @if($translation->lang_id == $lang->id)
                                                var data = '{!! $translation->code !!}';
                                                console.log(data);
                                            @endif
                                            @endforeach

                                            var formBuilder = $(fbEditor).formBuilder();

                                            window.addEventListener('load', function () {
                                                formBuilder.actions.setData(data);
                                            });

                                            $("#submit").on('click', function () {
                                                $("input.build_wrap_{{ $lang->lang }}").val(formBuilder.actions.getData('json'));
                                            });

                                        });
                                    </script>

                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endif

            <button id="submit" type="submit">Submit</button>


        </div>
    </form>









    <script>
        jQuery(function ($) {

            var langs = [];
            var ids = [];

            {{--var fbEditor = document.getElementById("build-wrap-{{ $lang->lang }}");--}}
            {{--var formBuilder = $(fbEditor).formBuilder();--}}

            {{--// document.getElementById("json-build-wrap-{{ $lang->lang }}").addEventListener('click', function () {--}}
            {{--// retrun formBuilder.actions.getData('json');--}}
            {{--// console.log(formBuilder.actions.getData('json'));--}}

            {{--// var a = $("input.build-wrap-{{ $lang->lang }}").val(formBuilder.actions.getData('json'));--}}

            {{--// console.log(a);--}}
            // });

            @foreach($langs as $lang)
            langs.push("build-wrap-{{ $lang->lang }}");
            ids.push("json-build-wrap-{{ $lang->lang }}");
            @endforeach


            // $.each(langs, function (index, element) {
            //     var fbEditor = document.getElementById(element);
            //     var formBuilder = $(fbEditor).formBuilder();
            // });

            // console.log($('#build-wrap-ru').formBuilder().actions.getData('json'));
        });
    </script>

@stop

@section('footer')
    <footer>
        @include('admin.footer')

        {{--<script src="{{  asset('js/formBuilder/vendor.js') }}"></script>--}}
        {{--<script src="{{  asset('js/formBuilder/form-builder.min.js') }}"></script>--}}
        {{--<script src="{{  asset('js/formBuilder/form-render.min.js') }}"></script>--}}
        {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.1/jquery.rateyo.min.js"></script>--}}
        {{--<script src="{{  asset('js/formBuilder/demo.js') }}"></script>--}}
    </footer>
@stop
