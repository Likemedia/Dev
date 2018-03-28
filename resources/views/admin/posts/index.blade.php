@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')

    @include('admin.speedbar')


    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('posts.index'),
            trans('variables.add_element') => route('posts.create'),
        ]
    ])

    @if(!$posts->isEmpty())

        <style>
            table * {
                font-size: 14px !important;
                line-height: 1.2;
            }

            table tr td {
                padding: 15px;
            }

            table p {
                margin-bottom: 0;
            }
        </style>

        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>{{trans('variables.title_table')}}</th>
                <th>{{trans('variables.body')}}</th>
                <th>Slug</th>
                <th>URL</th>
                <th>Tags</th>
                <th>Votes</th>
                <th>Rating</th>
                <th>{{trans('variables.edit_table')}}</th>
                <th>{{trans('variables.delete_table')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)

                <tr>
                    <td>
                        <p>{{ str_limit($post->translation->first()->title, 20) }}</p>
                    </td>
                    <td>
                        {!! str_limit($post->translation->first()->body, 100) !!}
                    </td>
                    <td>
                        {{ $post->translation->first()->slug }}
                    </td>
                    <td>
                        <p>{{ $post->translation->first()->url }}</p>
                    </td>
                    <td>
                        <p>
                            @foreach($post->tags as $tag)
                                {{ $tag->name }}@if(!$loop->last),
                                @endif
                            @endforeach
                        </p>
                    </td>
                    <td>
                        {{ $post->votes }}
                    </td>
                    <td>
                        {{ $post->rating }}
                    </td>
                    <td>
                        <a href="{{ route('posts.edit', $post->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">
                        <form action="{{ route('posts.destroy', $post->id) }}" method="post">
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
                <td colspan=9>
                    {{ $posts->links() }}
                </td>
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
