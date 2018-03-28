@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')
    {{--@include('list-elements', [--}}
    {{--'actions' => [--}}
    {{--trans('variables.elements_list') => urlForFunctionLanguage($lang, ''),--}}
    {{--trans('variables.add_element') => urlForFunctionLanguage($lang, 'item/create'),--}}
    {{--]--}}
    {{--])--}}


    <div class="list-content">
        <div class="tab-area">
            @include('admin.alerts')
            <ul class="nav nav-tabs nav-tabs-bordered">
                @if (!empty($langs))
                    @foreach ($langs as $key => $lang)
                        <li class="nav-item">
                            <a href="#{{ $lang->lang }}" class="nav-link  {{ $key == 0 ? ' open active' : '' }}"
                               data-target="#{{ $lang->lang }}">{{ $lang->lang }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <form class="form-reg" method="POST" action="{{ route('tags.store') }}">
            {{ csrf_field() }}

            @if (!empty($langs))


                @foreach ($langs as $lang)

                    <div class="tab-content {{ $loop->first ? ' active-content' : '' }}" id={{ $lang->lang }}>
                        <div class="part full-part">

                            <ul>

                                <li>
                                    <label>{{trans('variables.title_table')}}</label>
                                    <input type="text" name="name_{{ $lang->lang }}">
                                </li>

                                <li>
                                    <input type="submit" value="{{trans('variables.save_it')}}">
                                </li>

                            </ul>
                        </div>


                    </div>
                @endforeach
            @endif

        </form>
    </div>

@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>
@stop
