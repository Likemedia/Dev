@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

@include('admin.speedbar')

@include('admin.list-elements', [
    'actions' => [
        trans('variables.elements_list') => route('languages.create'),
    ]
])

@include('admin.alerts')


<div class="list-content">
    <form class="form-reg" role="form" method="POST" action="{{ route('languages.store') }}" id="add-form">
      {{ csrf_field() }}

    <div class="part full-part">

        <ul>
            <li>
                <label for="name">{{trans('variables.title_table')}}</label>
                <input type="text" name="name" id="name" placeholder="en" value="{{ old('name')}}">
            </li>
            <li>
                <label for="description">{{ trans('variables.description') }}</label>
                <input type="text" name="description" id="description" placeholder="English" value="{{ old('description')}}">
            </li>

            <input type="submit" value="{{trans('variables.save_it')}}" data-form-id="add-form">




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
