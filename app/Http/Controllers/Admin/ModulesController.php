<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Module;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DB;

class ModulesController extends Controller
{
    public function index()
    {
        $modules = Module::with('translations')->orderBy('position', 'asc')->get();

        return view('admin.modules.index', compact('modules'));
    }

    public function changePosition()
    {
        $neworder = Input::get('neworder');
        $i = 1;
        $neworder = explode("&", $neworder);

        foreach ($neworder as $k => $v) {
            $id = str_replace("tablelistsorter[]=", "", $v);
            if (!empty($id)) {
                Module::where('id', $id)->update(['position' => $i]);
                $i++;
            }
        }
    }

    public function create()
    {
        return view('admin.modules.create');
    }

    public function edit($id)
    {
        $module = Module::with('translations')->findOrFail($id);

        return view('admin.modules.edit', compact('module'));
    }

    public function store(Request $request)
    {
        $module = new Module();
        $module->src = $request->src;
        $module->controller = $request->controller;
        $module->position = 1;
        $module->table_name = $request->table_name;
        $module->icon = $request->icon;
        $module->save();

        foreach ($this->langs as $lang) :
            $module->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'description' => request('description_' . $lang->lang)
            ]);
        endforeach;

        Session::flash('message', 'New item has been created!');

        return redirect()->route('modules.index');
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $module->src = $request->src;
        $module->controller = $request->controller;
        $module->position = 1;
        $module->table_name = $request->table_name;
        $module->icon = $request->icon;
        $module->save();

        $module->translations()->delete();


        foreach ($this->langs as $lang) :
            $module->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'description' => request('description_' . $lang->lang)
            ]);
        endforeach;

        Session::flash('message', 'New item has been created!');

        return redirect()->route('modules.index');
    }


    public function destroy($id)
    {

        Module::findOrFail($id)->delete();

        Session::flash('message', 'Item was successful deleted! ');

        return redirect()->route('modules.index');
    }

    public function getTableCols($table)
    {
        $colums = [];
        $tables = ['tablename'];

        foreach ($tables as $table) {
            $table_info_columns = \DB::select(DB::raw('SHOW COLUMNS FROM' . $table));

            foreach ($table_info_columns as $key => $column) {
                if (($column->Field !== 'id') && ($column->Field !== 'created_at') && ($column->Field !== 'updated_at')) {
                    $colums[$key][] = $column->Field;
                    $colums[$key][] = $column->Type;
                }
            }
        }
        return $colums;
    }

}
