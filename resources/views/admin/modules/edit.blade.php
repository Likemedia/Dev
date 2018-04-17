@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')
    @include('admin.list-elements', [
        'actions' => [
<<<<<<< HEAD
            trans('variables.elements_list') => route('modules.index'),
            trans('variables.add_element') => route('modules.create'),
=======
            trans('variables.elements_list') => url($lang, ''),
            trans('variables.add_element') => url($lang, 'item/create'),
>>>>>>> menus
        ]
    ])

    <div class="list-content">
        <form class="form-reg" method="POST" action="{{ route('modules.update', $module->id) }}">
            {{ csrf_field() }} {{ method_field('PATCH') }}

            <div class="part left-part">
                <ul>

                    @foreach($langs as $lang)
                        <li>
                            <label for="name">{{trans('variables.title_table')}} {{ $lang->lang }}</label>
                            <input type="text" name="name_{{ $lang->lang }}"
                                   @foreach($module->translations as $translation)
                                   @if ($translation->lang_id == $lang->id)
                                   value="{{ $translation->name }}"
                                    @endif
                                    @endforeach
                            />
                        </li>
                        <li>
                        <label>{{trans('variables.description')}} {{ $lang->lang }}</label>
                        <textarea name="description_{{ $lang->lang }}">
                             @foreach($module->translations as $translation)
                                @if ($translation->lang_id == $lang->id)
                                    {!!  $translation->description  !!}
                                @endif
                            @endforeach
                        </textarea>
                        </li>
                    @endforeach


                </ul>
            </div>

            {{-- required staic fields --}}
            <div class="part right-part">
                <ul>
                    <li>
                        <label for="src">Link</label>
                        <input type="text" name="src" id="src" value="{{ $module->src }}">
                    </li>
                    <li>
                        <label for="src">Controller</label>
                        <input type="controller" name="controller" id="controller" value="{{ $module->controller }}">
                    </li>
                    <li>
                        <label for="table_name">Table name</label>
                        <input type="text" name="table_name" id="table_name" value="{{ $module->table_name }}">
                    </li>
                    <li>
                        <label for="icon">Icon</label>
                        <input type="text" name="icon" id="icon" value="{{ $module->icon }}">
                    </li>
                    <div class="text-center alert alert-warning">
                        <a target="_blank" class="pull-center" href="http://fontawesome.io/icons/">Font awesome</a>
                    </div>

                    <input type="submit" value="{{trans('variables.save_it')}}" onclick="saveForm(this)"
                           data-form-id="add-form">
                </ul>
            </div>
        </form>
    </div>
@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>
@stop
