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
                            <a href="#{{ $lang->lang }}" class="nav-link  {{ $loop->first == 0 ? ' open active' : '' }}"
                               data-target="#{{ $lang->lang }}">{{ $lang->lang }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <form class="form-reg" method="post" action="{{ route('menus.update', $menuItem->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }} {{ method_field('PATCH') }}

            @if (!empty($langs))

                @foreach ($langs as $lang)

                    <div class="tab-content {{ $loop->first == 0 ? ' active-content' : '' }}" id={{ $lang->lang }}>
                        <div class="part full-part">

                            <ul>
                                <li>
                                    <label>{{trans('variables.title_table')}}</label>
                                    <input type="text" name="name_{{ $lang->lang }}" class="name"
                                           data-lang="{{ $lang->lang }}"

                                           @foreach($menuItem->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->name }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>

                            </ul>
                        </div>


                    </div>
                @endforeach
            @endif

            <div class="part full-part">
                <ul>
                    <li>
                      <label>Link</label>
                      <select class="form-control categorySelect" name="link" >
                          @if (!empty($pages))
                              <optgroup label="Pagini Statice">
                              @foreach ($pages as $key => $page)
                                  <option value="/page/{{ $page->translation()->first()->slug }}">{{ !is_null($page->translation()->first()) ? $page->translation()->first()->title : '' }}</option>
                              @endforeach
                              </optgroup>
                          @endif
                          @if (!empty($categories))
                          <optgroup label="Categorii">
                              @foreach ($categories as $key => $category)
                                  <option data="category" data-id="{{ $category->id }}" value="{{ !is_null($category->translation()->first()) ? $category->translation()->first()->name : '' }}">{{ $category->translation()->first()->name }}</option>
                              @endforeach
                          </optgroup>
                          @endif
                      </select>
                    </li>
                    <li>
                      <br><br>
                      <input type="submit" value="{{trans('variables.save_it')}}">
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
