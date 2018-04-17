@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')

    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('groups.index'),
            trans('variables.add_element') => route('groups.create'),
        ]
    ])

    <div class="list-content">

        <form class="form-reg" method="POST" action="{{ route('groups.store') }}">
            {{ csrf_field() }}

            <div class="part left-full">
                <ul>
                      <li>
                          <label for="name">{{trans('variables.title_table')}}</label>
                          <input type="text" name="name" id="name" required>
                      </li>
                      <li>
                          <label for="slug">Slug</label>
                          <input type="text" name="slug" id="slug" required>
                      </li>
                      <li>
                          <br><input type="submit" value="{{trans('variables.save_it')}}"><br>
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
