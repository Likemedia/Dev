<?php

namespace App\Http\Controllers\Admin;

use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParametersController extends Controller
{
    public function index()
    {
    	$parameters = Parameter::with('translation')->get();

    	return view('admin.parameters.index', compact('parameters'));
    }

    public function create()
    {
    	return view('admin.parameters.create');
    }

    public function store(Request $request)
    {
        $parameter = new Parameter();
        $parameter->save();

        foreach ($this->langs as $lang):
            $parameter->translations()->create([
                'lang_id' => $lang->id,
                'title' => request('name_' . $lang->lang),
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->route('parameters.index');
    }

    public function show($id)
    {
        $parameter = Parameter::with('translation')->findOrFail($id);

        return view('admin.parameters.show', compact('parameter'));
    }

    public function edit($id)
    {
        $parameter = Parameter::with('translations')->findOrFail($id);

        return view('admin.parameters.edit', compact('parameter'));
    }

    public function update(Request $request, $id)
    {
        $parameter = Parameter::findOrFail($id);

        $parameter->translations()->delete();

        foreach ($this->langs as $lang):
            $parameter->translations()->create([
                'lang_id' => $lang->id,
                'title' => request('name_' . $lang->lang),
            ]);
        endforeach;

        session()->flash('message', 'Item has been deleted!');

        return redirect()->route('parameters.index');
    }

    public function destroy($id)
    {
        Parameter::findOrFail($id)->delete();

        session()->flash('message', 'Item has been deleted!');

        return redirect()->route('parameters.index');
    }
}
