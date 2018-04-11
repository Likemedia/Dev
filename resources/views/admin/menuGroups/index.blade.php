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

    @if(count($menuGroups))

        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{trans('variables.title_table')}}</th>
                <th>Slug</th>
                <th>Menus</th>
                <th>{{trans('variables.edit_table')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($menuGroups as $key => $menuGroup)
                <tr id="{{ $menuGroup->id }}">
                    <td>#{{ $key + 1 }}</td>
                    <td>   {{ $menuGroup->name }} </td>
                    <td>   [{{ $menuGroup->slug }}] </td>
                    <td>
                        <a href="{{ route('menus.group', $menuGroup->id) }}">
                            <i class="fa fa-sign-in"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('groups.edit', $menuGroup->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan=7></td>
            </tr>
            </tfoot>
        </table>
    @else
        <div class="empty-response">{{trans('variables.list_is_empty')}}</div>
    @endif

@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>
@stop
