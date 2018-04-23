@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')

    <div class="list-content">
        <div class="tab-area">
            @include('admin.alerts')
            <ul class="nav nav-tabs nav-tabs-bordered">
                @if (!empty($langs))
                    @foreach ($langs as $key => $lang)
                        <li class="nav-item">
                            <a href="#{{ $lang->lang }}" class="nav-link  {{ $key == 0 ? ' open active' : '' }}"
                               data-target="#{{ $lang->lang }}">{{ $lang->lang }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <form class="form-reg" method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            @if (!empty($langs))


                @foreach ($langs as $lang)

                    <div class="tab-content {{ $loop->first ? ' active-content' : '' }}" id={{ $lang->lang }}>
                        <div class="part left-part">

                            <ul>
                                <li>
                                    <label>{{trans('variables.title_table')}}</label>
                                    <input type="text" name="name_{{ $lang->lang }}" class="name"
                                           data-lang="{{ $lang->lang }}">
                                </li>

                                <li class="ckeditor">
                                    <label>{{trans('variables.body')}}</label>
                                    <textarea name="description_{{ $lang->lang }}"></textarea>
                                    <script>
                                        CKEDITOR.replace('description_{{ $lang->lang }}', {
                                            language: '{{$lang}}',
                                        });
                                    </script>
                                </li>

                                <li>
                                    <label>Image Alt text</label>
                                    <input type="text" name="alt_text_{{ $lang->lang }}">
                                </li>

                                <li>
                                    <label>Image Title</label>
                                    <input type="text" name="title_{{ $lang->lang }}">
                                </li>
                            </ul>
                        </div>

                        <div class="part right-part">
                            <ul>
                                <li>
                                    <label>Slug</label>
                                    <input type="text" name="slug_{{ $lang->lang }}" class="slug"
                                           id="slug-{{ $lang->lang }}">
                                </li>

                                <input type="submit" value="{{trans('variables.save_it')}}">

                                <hr>
                                <h6>Seo тексты</h6>
                                <li>
                                    <label>{{trans('variables.meta_title_page')}}</label>
                                    <input type="text" name="meta_title_{{ $lang->lang }}">
                                </li>
                                <li>
                                    <label>{{trans('variables.meta_keywords_page')}}</label>
                                    <input type="text" name="meta_keywords_{{ $lang->lang }}">
                                </li>
                                <li>
                                    <label>{{trans('variables.meta_description_page')}}</label>
                                    <input type="text" name="meta_description_{{ $lang->lang }}">
                                </li>
                            </ul>

                        </div>
                    </div>
                @endforeach
            @endif

            <div>
                <ul>
                    <li>
                        <select name="parent_id">
                            <option value="0">- - -</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->translation()->first()->name }}</option>
                            @endforeach
                        </select>
                    </li>
                    <li>
                        <label>{{trans('variables.img')}}</label>
                        <input style="padding: 0; border: none" type="file" name="image"/>
                    </li>
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
