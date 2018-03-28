@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')

    @include('admin.speedbar')


    <div class="list-content">

        <form class="form-reg" role="form" method="POST" action="{{ route('reviews.update') }}">
            {{ csrf_field() }} {{ method_field('PATCH') }}

            <ul>

                <div style="display: flex; flex-wrap: wrap">

                    <li style="flex: 1; margin: 5px">
                        <label>Votes from</label>
                        <input type="text" name="votes_from" value="{{ $rating->votes_from ?? '' }}">
                    </li>

                    <li style="flex: 1; margin: 5px;">
                        <label>Votes to</label>
                        <input type="text" name="votes_to" value="{{ $rating->votes_to ?? '' }}">
                    </li>
                </div>

                <div style="display: flex; flex-wrap: wrap">

                    <li style="flex: 1; margin: 5px">
                        <label>Rating from</label>
                        <input type="text" name="rating_from" value="{{ $rating->rating_from ?? '' }}">
                    </li>

                    <li style="flex: 1; margin: 5px;">
                        <label>Rating to</label>
                        <input type="text" name="rating_to" value="{{ $rating->rating_to ?? '' }}">
                    </li>
                </div>
            </ul>

            <input type="submit" value="Submit">
        </form>
    </div>

@stop

@section('footer')
    <footer>
        @include('admin.footer')
    </footer>
@stop
