@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')

    <div class="list-content">
        <div class="tab-area">
            @include('admin.alerts')
            <ul class="nav nav-tabs nav-tabs-bordered">
                @if (!empty($langs))
                    @foreach ($langs as $key => $lang)
                        <li class="nav-item">
                            <a href="#{{ $lang->lang }}" class="nav-link  {{ $key == 0 ? ' open active' : '' }}"
                               data-target="#{{ $lang->lang }}">{{ $lang->descr }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <form class="form-reg" method="post" action="{{ route('categories.update', $menuItem->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }} {{ method_field('PATCH') }}

            @if (!empty($langs))


                @foreach ($langs as $lang)

                    <div class="tab-content {{ $loop->first == 0 ? ' active-content' : '' }}" id={{ $lang->lang }}>
                        <div class="part left-part">

                            <ul>
                                <li>
                                    <label>{{trans('variables.title_table')}}</label>
                                    <input type="text" name="name_{{ $lang->lang }}" class="name"
                                           data-lang="{{ $lang->lang }}"

                                           @foreach($menuItem->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->name }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>

                            </ul>
                        </div>

                        <div class="part right-part">
                            <ul>
                                <input type="submit" value="{{trans('variables.save_it')}}">
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
