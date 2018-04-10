<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FieldsController extends Controller
{
    protected $lookup = [

    	'text' => "<input type='text' name='{{placeholder}}' {{required}} />",
    	'file' => "<input type='file' name='{{placeholder}}' {{required}} />",
    	'files' => "<input type='file' name='{{placeholder}}[]' {{required}} />",
    	'textarea' => "<textarea name='{{placeholder}}'></textarea>"

    ];

    public function store(Request $request, $id)
    {
    	dd($request->all(), $id);
    }
}
