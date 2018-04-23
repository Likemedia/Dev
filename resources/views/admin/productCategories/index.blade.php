@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')

@section('content')

@include('admin.list-elements', [
'actions' => [
        trans('variables.elements_list') => route('menus.index'),
        trans('variables.add_element') => route('menus.create'),
    ]
])
@include('admin.alerts')

<div class="list-content">
    <div class="part full-part min-height">
        <hr>
        <div id="container">
            <a class="btn btn-primary modal-id" data-toggle="modal" data-target="#addCategory" data-id="0"><i class="fa fa-plus"></i></a>
        </div>
        <div class="dd" id="nestable-output">
            {!! SelectProductCategoriesTree(1, 0, $curr_id=null) !!}
            <div class="nestable-stop"></div>
        </div>
        <script>
            var data = localStorage.getItem("nestable");
            if (data !== null) {
                jQuery(function($){
                    $('.nestable-stop').hide();
                })

                $('#nestable-output').nestable();
            }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });

                $(document).ready(function () {
                    var updateOutput = function (e) {
                        var list = e.length ? e : $(e.target), output = list.data('output');

                        var data = localStorage.getItem("nestable");
                        if (data !== null) {

                        $.ajax({
                            method: "POST",
                            url: "{{ route('product-categories.change') }}",
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

                    }

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
    </div>
</div>

@stop
@section('footer')

<footer>
    @include('admin.footer')
</footer>

@include('admin.productCategories.modals')
<script>
    $('.modal-id').click(function () {
        $('#parent_id').val($(this).data('id'));
        $('.category-id').val($(this).data('id'));
        $('.parent_id').val($(this).data('id'));
        $('.category-name').text($(this).attr('data-name'));
    })
</script>
@stop
