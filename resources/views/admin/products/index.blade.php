@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')

    @include('admin.speedbar')


    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('products.index'),
            trans('variables.add_element') => route('products.create'),
        ]
    ])


    @if(count($products))

        <table class="el-table" id="tablelistsorter">
            <thead>
            <tr>
                <th>{{trans('variables.title_table')}}</th>
                <th>{{trans('variables.edit_table')}}</th>
                <th>{{trans('variables.delete_table')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($products as $product)
                <tr id="{{ $product->id }}">
                    <td>
                        {{ $product->translation->first()->name }}
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td class="destroy-element">
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
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
