<div class="list-elements">
    @if (Session::has('message'))
        <div class="alert alert-info">{!! Session::get('message') !!}</div>
    @endif
    @if (Session::has('error-message'))
        <div class="error-alert alert-info">{!! Session::get('error-message') !!}</div>
    @endif
    @if(isset($actions) && count($actions))

    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-12">
                        @foreach($actions as $action_name => $action)
                            <a href="{{$action}}" class="btn btn-primary btn-sm rounded-s {{$action == url()->current() ? 'active' : ''}}" >{{$action_name}}</a>
                        @endforeach
                    </h3>

                </div>
            </div>
        </div>
    </div>

    @endif
</div>
