

<div  class="header-block">
    @foreach($langs as $lang)
        <a href="{{ route('set.language', $lang->lang) }}"
        @if ( session('applocale') == $lang->lang ) {{ "class=active-link" }} @endif
        >
            {{ $lang->lang }}
        </a>
    @endforeach
</div>


@foreach($posts as $post)
    <article>
        <img  style="max-height: 200px; max-width: 200px;" src="/images/posts/{{ $post->image }}" alt="">
        <h1>{{ $post->translation->first()->title }}</h1>
    </article>
@endforeach

