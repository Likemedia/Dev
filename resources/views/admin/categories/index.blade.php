@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')

    @include('admin.list-elements', [
        'actions' => [
            trans('variables.elements_list') => route('categories.index'),
            trans('variables.add_element') => route('categories.create'),
        ]
    ])
    @include('admin.alerts')


    <div class="list-content">
        <div class="part full-part min-height">
            <h6>Список категории</h6>
            <hr>
            <div id="container">
                <a class="btn-link modal-id" data-toggle="modal" data-target="#addCategory" data-id="0"><i class="fa fa-plus"></i></a>
            </div>

            <div class="dd" id="nestable-output">

                {!! SelectGoodsCatsTree(1, 0, $curr_id=null) !!}

            </div>

            <script>

                $('#nestable-output').nestable();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });

                $(document).ready(function () {
                    var updateOutput = function (e) {
                        var list = e.length ? e : $(e.target), output = list.data('output');

                        $.ajax({
                            method: "POST",
                            url: "{{ route('categories.change') }}",
                            data: {
                                list: list.nestable('serialize')
                            },
                            success:  function(data){
                                console.log(JSON.parse(data).message);
                                if (JSON.parse(data).message == false) {
                                    var response = JSON.parse(data);
                                    $('#moveModal').modal('show');
                                    $('.parent_id').val(response.parentId);
                                    $('.child_id').val(response.childId);
                                }
                                $('#nestable-output').html(JSON.parse(data).text);
                            },
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                            alert("Unable to save new list order: " + errorThrown);
                        });
                    };

                    $('#nestable-output').nestable({
                        group: 1,
                        maxDepth: 3,
                    }).on('change', updateOutput);
                });

                $('#container').on("changed.jstree", function (e, data) {
                    console.log("The selected nodes are:");
                    console.log(data.selected);
                });

            </script>
            <a href="{{ Request::url() }}" class="btn btn-primary"><i class="fa fa-refresh"></i> Salveaza</a>
        </div>
    </div>


@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>

    @include('admin.categories.modals')

@stop
