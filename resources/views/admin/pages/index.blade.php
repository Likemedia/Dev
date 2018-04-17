@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')
    @include('admin.speedbar')

    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('pages.index'),
            trans('variables.add_element') =>  route('pages.create')
        ]
    ])
    @include('admin.alerts')

    @if(!$pages->isEmpty())
        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>{{trans('variables.title_table')}}</th>
                <th>{{trans('variables.position_table')}}</th>
                <th>{{trans('variables.active_table')}}</th>
                <th>{{trans('variables.edit_table')}}</th>
                <th>{{trans('variables.delete_table')}}</th>
                <th>Creat</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)

                <tr id="{{ $page->id }}">
                    <td>
                        {{ $page->translation()->first()->title ?? trans('variables.another_name') }}
                    </td>
                    <td class="dragHandle" nowrap style="cursor: move;">
                        <a class="top-pos" href=""></a>
                        <a class="bottom-pos" href=""></a>
                    </td>
                    <td>
                        <form action="{{ route('pages.change.status', $page->id) }}" method="post">
                            {{ csrf_field() }} {{ method_field('PATCH') }}
                            <button type="submit" class="btn-link">
                                <a href="" class="change-active {{ $page->active == 1 ? '' : 'negative' }}">
                                    {{ $page->active == 1 ? '+' : '-' }}
                                </a>
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('pages.edit', $page->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">
                        <form action="{{ route('pages.destroy', $page->id) }}" method="post">
                            {{ csrf_field() }} {{ method_field('DELETE') }}
                            <button type="submit" class="btn-link">
                                <a href="">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </button>
                        </form>
                    </td>
                    <td>{{ $page->created_at->format('d/m/Y') }}</td>
                    
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
