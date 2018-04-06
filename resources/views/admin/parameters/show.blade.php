@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')


// display item, and form to add all parameters

<!--     <div class="list-content">
        <div class="tab-area">
            @include('admin.alerts')
            <ul class="nav nav-tabs nav-tabs-bordered">
                    @foreach ($langs as $key => $lang)
                        <li class="nav-item">
                            <a href="#{{ $lang->lang }}" class="nav-link  {{ $key == 0 ? ' open active' : '' }}"
                               data-target="#{{ $lang->lang }}">{{ $lang->lang }}</a>
                        </li>
                    @endforeach
            </ul>
        </div>

        <form class="form-reg" method="POST" action="{{ route('parameters.store') }}">
            {{ csrf_field() }}


                @foreach ($langs as $lang)

                    <div class="tab-content {{ $loop->first ? ' active-content' : '' }}" id={{ $lang->lang }}>
                        <div class="part full-part">

                            <ul>
                                <li>
                                    <label>{{trans('variables.title_table')}}</label>
                                    <input type="text" name="name_{{ $lang->lang }}" class="name"
                                           data-lang="{{ $lang->lang }}">
                                </li>

                            </ul>

                        <input type="submit" value="{{trans('variables.save_it')}}">
                            
                        </div>

                        
                    </div>
                @endforeach


        </form>
    </div> -->

@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>
@stop
