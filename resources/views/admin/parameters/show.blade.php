@extends('admin.app')
@include('admin.nav-bar')
@include('admin.left-menu')
@section('content')
<div class="table-content">
    <div class="part part-left">
        <div class="tab-area">
            <h6>
               
            </h6>
        </div>
    </div>
</div>


<div class="list-content">
    <div class="tab-area">
        <ul class="nav nav-tabs nav-tabs-bordered">
        </ul>
    </div>
    <div class="tab-content active-content">
        <div class="part left-part">
            <h6> {{ $parameter->translation->first()->title }}</h6>
            <ul>
                @foreach($parameter->fields as $field)
                <li>
                    {{ $field->id }}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="part right-part">
            <h6>Add new field</h6>
            <form method="post" action="{{ route('fields.store', $parameter->id) }}">
                {{ csrf_field() }} 
                <label>Type</label>
                <select class="form-control">
                    <option>Text</option>
                    <option>Select</option>
                    <option>Textarea</option>
                </select>

                <hr>

                <label>Required</label> <br>
                <input type="radio" name="required" value="yes"> Yes
                <input type="radio" name="required" value="no"> No

                <hr>

                <label>Name</label>
                <input type="text" name="name" class="form-control">

                <hr>

                <label>Field Name</label>
                <input type="text" name="field_name" class="form-control">

                <hr>

                <label>Select (separate options with a coma)</label>
                <input type="text" name="pattern" class="form-control">

                <hr>

                <input type="submit" name="Submit" class="btn btn-primary">

            </form>
        </div>
    </div>
</div>
@stop

@section('footer')
<footer>
    @include('admin.footer')
</footer>
@stop
