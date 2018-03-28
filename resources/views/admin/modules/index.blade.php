@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')

    @include('admin.speedbar')


    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('modules.index'),
            trans('variables.add_element') => route('modules.create'),
            'Adauga un submodul' => route('submodules.create')
        ]
    ])

    @if(!empty($modules))

        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{trans('variables.title_table')}}</th>
                <th>{{trans('variables.position_table')}}</th>
                <th>{{trans('variables.edit_table')}}</th>
                <th>{{trans('variables.delete_table')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($modules as $key => $module)
                <tr id="{{ $module->id }}">
                    <td>#{{ $key + 1 }}</td>
                    <td>
                        {{ $module->translations->first()->name ?? trans('variables.another_name')}}
                    </td>
                    <td class="dragHandle" nowrap style="cursor: move;">
                        <a class="top-pos" href=""></a>
                        <a class="bottom-pos" href=""></a>
                    </td>
                    <td>
                        <a href="{{ route('modules.edit', $module->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">


                        <form action="{{ route('modules.destroy', $module->id) }}" method="post">
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
