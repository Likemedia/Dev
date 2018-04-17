
@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')

    @include('admin.speedbar')


    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('parameters.index'),
            trans('variables.add_element') => route('parameters.create'),
        ]
    ])


    @if(count($parameters))

        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>{{trans('variables.title_table')}}</th>
                <th>{{trans('variables.view_table')}}</th>
                <th>{{trans('variables.edit_table')}}</th>
                <th>{{trans('variables.delete_table')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($parameters as $parameter)
                <tr id="{{ $parameter->id }}">


                    <td>
                        {{ $parameter->translation->first()->title }}
                    </td>

                    <td>
                        <a href="{{ route('parameters.show', $parameter->id) }}">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>

                    <td>
                        <a href="{{ route('parameters.edit', $parameter->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>

                    <td class="destroy-element">
                        <form action="{{ route('parameters.destroy', $parameter->id) }}" method="post">
                            {{ csrf_field() }} {{ method_field('DELETE') }}
                            <button type="submit" class="btn-link">
                                <a>
                                    <i class="fa fa-trash"></i>
                                </a>
                            </button>
                        </form>
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