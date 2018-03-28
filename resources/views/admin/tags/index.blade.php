@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')

    @include('admin.speedbar')


    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('tags.index'),
            trans('variables.add_element') => route('tags.create'),
        ]
    ])


    @if(count($tags) or count($zeroCountTags))

        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>{{trans('variables.title_table')}}</th>
                <th>Articles Count</th>
                <th>{{trans('variables.edit_table')}}</th>
                <th>{{trans('variables.delete_table')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr id="{{ $tag->id }}">
                    <td>
                        {{ $tag->name ?? trans('variables.another_name')}}
                    </td>
                    <td>{{ $tag->count }}</td>
                    <td>
                        <a href="{{ route('tags.edit', $tag->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">
                        <form action="{{ route('tags.destroy', $tag->id) }}" method="post">
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

            @foreach($zeroCountTags as $zeroTag)
                <tr id="{{ $zeroTag->id }}">
                    <td>
                        {{ $zeroTag->name ?? trans('variables.another_name')}}
                    </td>
                    <td>0</td>
                    <td>
                        <a href="{{ route('tags.edit', $zeroTag->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">
                        <form action="{{ route('tags.destroy', $zeroTag->id) }}" method="post">
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
