@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    {{--@include('list-elements', [--}}
    {{--'actions' => [--}}
    {{--trans('variables.elements_list') => urlForFunctionLanguage($lang, ''),--}}
    {{--trans('variables.add_element') => urlForFunctionLanguage($lang, 'item/create'),--}}
    {{--]--}}
    {{--])--}}


    <div class="list-content">
        <div class="tab-area">
            @include('admin.alerts')
        </div>

        <form class="form-reg" method="POST" action="{{ route('autometa.store') }}">
            {{ csrf_field() }}

                    <div class="tab-content active-content" >
                        <div class="part full-part">

                            <ul>

                                <h6>Auto Meta</h6>

                                <li>
                                    <select name="lang_id">
                                        @foreach($langs as $lang)
                                            <option value="{{ $lang->id }}">{{ $lang->lang }}</option>
                                        @endforeach
                                    </select>
                                </li>

                                <li>
                                    <label>Name</label>
                                    <input type="text" name="name">
                                </li>

                                <li>
                                    <label>Title</label>
                                    <input type="text" name="title">
                                </li>

                                <li>
                                    <label>Description</label>
                                    <input type="text" name="description">
                                </li>

                                <hr>

                                <li>
                                    <label>Keywords</label>
                                    <textarea name="keywords"></textarea>
                                </li>

                                <li>
                                    <label>Var 1</label>
                                    <input name="var1" />
                                </li>

                                <li>
                                    <label>Var 2</label>
                                    <input name="var2" />
                                </li>

                                <li>
                                    <label>Var 3</label>
                                    <input name="var3" />
                                </li>

                                <li>
                                    <label>Var 4</label>
                                    <input name="var4" />
                                </li>

                                <li>
                                    <label>Var 5</label>
                                    <input name="var5" />
                                </li>

                              
                            </ul>

                            <input type="submit" value="{{trans('variables.save_it')}}">
                        </div>
                    </div>

        </form>
    </div>


@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>
@stop
