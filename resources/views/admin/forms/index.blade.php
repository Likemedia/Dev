@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')
    @include('admin.speedbar')

    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('forms.index'),
            trans('variables.add_element') => route('forms.create'),
        ]
    ])
    @include('admin.alerts')

    @if(!$forms->isEmpty())
        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>{{trans('variables.title_table')}}</th>
                <th>Short Code</th>
                <th>Date</th>
                <th>{{trans('variables.edit_table')}}</th>
                <th>{{trans('variables.delete_table')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($forms as $form)

                <tr id="{{$form->id}}">
                    <td>{{ $form->translation()->first()->title ?? trans('variables.another_name')}}</td>
                    <td>{{ $form->short_code }}</td>
                    <td>{{ $form->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('forms.edit', $form->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">
                        <form action="{{ route('forms.destroy', $form->id) }}" method="post">
                            {{ csrf_field() }} {{ method_field('DELETE') }}
                            <button class="btn-link">
                                <a href="">
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
