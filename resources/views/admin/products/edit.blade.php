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

    @include('admin.alerts')


    <div class="list-content">

        <form class="form-reg" method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }} {{ method_field('PATCH') }}

            <div class="part full-part" style="padding: 25px 8px;">

                <label>Category</label>
                <select class="form-control" name="category_id">
                    <option disabled>- - -</option>
                    @foreach($categories as $category)
                        <option {{ $category->id == $product->categry_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->translation()->first()->name }}</option>
                    @endforeach
                </select>

            </div>


            @if (!empty($langs))

                <div class="tab-area" style="margin-top: 25px;">
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


                @foreach ($langs as $lang)

                    <div class="tab-content {{ $loop->first ? ' active-content' : '' }}" id={{ $lang->lang }}>
                        <div class="part left-part">

                            <ul style="padding: 25px 0;">

                                <li>
                                    <label>{{trans('variables.title_table')}}</label>
                                    <input type="text" name="name_{{ $lang->lang }}" class="name" data-lang="{{ $lang->lang }}" required
                                           @foreach($product->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->name }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>

                                <li>
                                    <label for="">{{trans('variables.body')}}</label>
                                    <textarea name="body_{{ $lang->lang }}" id="body-{{ $lang->lang }}"
                                              data-type="ckeditor">
                                         @foreach($product->translations as $translation)
                                            @if ($translation->lang_id == $lang->id)
                                                {!! $translation->body !!}
                                            @endif
                                        @endforeach
                                    </textarea>
                                    <script>
                                        CKEDITOR.replace('body-{{ $lang->lang }}', {
                                            language: '{{$lang->lang}}',
                                        });
                                    </script>
                                </li>

                            </ul>
                        </div>


                        <div class="part right-part">
                            <ul>
                                <li>
                                    <label>Slug</label>
                                    <input type="text" name="slug_{{ $lang->lang }}"
                                           class="slug form-control"
                                           id="slug-{{ $lang->lang }}"
                                           @foreach($product->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->url }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>




                                <li>
                                    <label>{{trans('variables.h1_title_page')}}</label>
                                    <input type="text" name="meta_title_{{ $lang->lang }}"
                                           @foreach($product->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->meta_h1 }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>


                                <li>
                                    <label>{{trans('variables.meta_title_page')}}</label>
                                    <input type="text" name="meta_title_{{ $lang->lang }}"
                                           @foreach($product->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->meta_title }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>

                                <li>
                                    <label>{{trans('variables.meta_keywords_page')}}</label>
                                    <input type="text" name="meta_keywords_{{ $lang->lang }}"
                                           @foreach($product->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->meta_keywords }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>

                                <li>
                                    <label>{{trans('variables.meta_description_page')}}</label>
                                    <input type="text" name="meta_description_{{ $lang->lang }}"
                                           @foreach($product->translations as $translation)
                                           @if ($translation->lang_id == $lang->id)
                                           value="{{ $translation->meta_description }}"
                                            @endif
                                            @endforeach
                                    >
                                </li>
                            </ul>
                        </div>

                    </div>
                @endforeach
            @endif

            <input type="submit" value="{{trans('variables.save_it')}}">


        </form>
    </div>

@stop

@section('footer')
    <footer>
        @include('admin.footer')

        <script>

            $('button.tag').click(function(e) {
                e.preventDefault();

                $input = $(this).siblings().last().clone().val('');
                $(this).parent().append($input);
            });

        </script>
    </footer>
@stop
