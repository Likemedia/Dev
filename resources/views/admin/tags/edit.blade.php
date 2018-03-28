@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')

    <div class="list-content">
        <div class="tab-area">
            @include('admin.alerts')
        </div>

        <form class="form-reg" method="POST" action="{{ route('tags.update', $tag->id) }}">
            {{ csrf_field() }} {{ method_field('PATCH') }}

                <div class="part full-part" style="padding: 15px;">

                    <ul>
                        <li>
                            <label>{{trans('variables.title_table')}}</label>
                            <input type="text" name="name" value="{{ $tag->name }}" />
                        </li>

                        <li>
                            <input type="submit" value="{{trans('variables.save_it')}}">
                        </li>

                    </ul>
                </div>

        </form>
    </div>

@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>
@stop
