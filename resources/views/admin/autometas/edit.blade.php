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

        <form class="form-reg" method="POST" action="{{ route('autometa.update', $meta->id) }}">
            {{ csrf_field() }} {{ method_field('PATCH')}}

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
                                    <input type="text" name="name" value="{{ $meta->name }}">
                                </li>

                                <li>
                                    <label>Title</label>
                                    <input type="text" name="title" value="{{ $meta->title }}">
                                </li>

                                <li>
                                    <label>Description</label>
                                    <input type="text" name="description" value="{{ $meta->description }}">
                                </li>

                                <hr>

                                <li>
                                    <label>Keywords</label>
                                    <textarea name="keywords">
                                        {{ $meta->keywords }}
                                    </textarea>
                                </li>

                                <li>
                                    <label>Var 1</label>
                                    <input name="var1"  value="{{ $meta->var1 }}"/>
                                </li>

                                <li>
                                    <label>Var 2</label>
                                    <input name="var2"  value="{{ $meta->var2 }}"/>
                                </li>

                                <li>
                                    <label>Var 3</label>
                                    <input name="var3"  value="{{ $meta->var3 }}"/>
                                </li>

                                <li>
                                    <label>Var 4</label>
                                    <input name="var4"  value="{{ $meta->var4 }}"/>
                                </li>

                                <li>
                                    <label>Var 5</label>
                                    <input name="var5"  value="{{ $meta->var5 }}"/>
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
