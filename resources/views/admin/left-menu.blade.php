@section('left-menu')

    <aside class="sidebar">
        <div class="sidebar-container">
            <div class="sidebar-header">
                <div class="brand">
                    <div class="logo"><span class="l l1"></span> <span class="l l2"></span> <span class="l l3"></span>
                        <span class="l l4"></span> <span class="l l5"></span></div>
                    Like Media Admin
                </div>
            </div>
            <nav class="menu">

                @if(!is_null($menu))
                    <ul class="nav metismenu" id="sidebar-menu">

                        <li>
                            <a href="/back">
                                <i class="fa fa-dashboard"></i>Control Panel
                            </a>
                        </li>

                        @foreach($menu as $m)
                            @if ($m->src ==  'posts')
                                @include('admin.partials.menuCategories')
                            @else
                                <li class="{{ request()->segment(2) == $m->src  ? 'active' : ''}}" >

                                    <a class="{{ count($m->submenu) > 0 ? 'drop-down' : '' }}"
                                       href="/back/{{ $m->src }}">
                                        <i class="fa {{ $m->icon }}"></i>

                                        {{ $m->translation->first()->name ?? '' }} {!! count($m->submenu) > 0 ? '<i class="fa arrow"></i></a>' : '' !!}
                                    </a>

                                    @if(count($m->submenu) > 0)
                                        <ul class="drop-hd">
                                            @foreach($m->submenu as $mod_sub)
                                                <li>
                                                    <a href="/back/{{ $mod_sub->src }}">
                                                        {{ $mod_sub->translation->first()->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </nav>
        </div>
    </aside>

@stop
