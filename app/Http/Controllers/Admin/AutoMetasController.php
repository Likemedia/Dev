<?php

namespace App\Http\Controllers\Admin;

use App\Models\AutoMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutoMetasController extends Controller
{
    public function index()
    {
    	$metas = AutoMeta::all();

    	$var1 = explode('#', $metas->first()->var1);
    	$var2 = explode('#', $metas->first()->var2);
    	$var3 = explode('#', $metas->first()->var3);
    	$var4 = explode('#', $metas->first()->var4);
    	$var5 = explode('#', $metas->first()->var5);

    	$description = $metas->first()->description;

    	$description = str_replace('{{1}}', $var1[array_rand($var1)], $description);
    	$description = str_replace('{{2}}', $var2[array_rand($var2)], $description);
    	$description = str_replace('{{3}}', $var3[array_rand($var3)], $description);
    	$description = str_replace('{{4}}', $var4[array_rand($var4)], $description);
    	$description = str_replace('{{5}}', $var5[array_rand($var5)], $description);
    	$description = str_replace('{{', '', $description);
    	$description = str_replace('}}', '', $description);
    	$description = trim($description);

    	// dd($description);


    	return view('admin.autometas.index', compact('metas'));
    }

    public function create()
    {
    	return view('admin.autometas.create');
    }


    public function store(Request $request)
    {
    	$meta = new AutoMeta();
    	$meta->lang_id = $request->lang_id;
    	$meta->name = $request->name;
    	$meta->title = $request->title;
    	$meta->description = $request->description;
    	$meta->keywords = $request->keywords;
    	$meta->var1 = $request->var1;
    	$meta->var2 = $request->var2;
    	$meta->var3 = $request->var3;
    	$meta->var4 = $request->var4;
    	$meta->var5 = $request->var5;
    	$meta->save();

    	session()->flash('message', 'New item has been created!');

    	return redirect()->route('autometa.index');
    }

    public function edit($id)
    {
    	$meta = AutoMeta::findOrFail($id);

    	return view('admin.autometas.edit', compact('meta'));
    }

    public function update(Request $request, $id)
    {
    	$meta = AutoMeta::findOrFail($id);
    	$meta->lang_id = $request->lang_id;
    	$meta->name = $request->name;
    	$meta->title = $request->title;
    	$meta->description = $request->description;
    	$meta->keywords = $request->keywords;
    	$meta->var1 = $request->var1;
    	$meta->var2 = $request->var2;
    	$meta->var3 = $request->var3;
    	$meta->var4 = $request->var4;
    	$meta->var5 = $request->var5;
    	$meta->save();

    	session()->flash('message', 'Item has been updated!');

    	return redirect()->route('autometa.index');
    }

    public function destroy($id)
    {
    	AutoMeta::findOrFail($id)->delete();

    	session()->flash('message', 'Item has been deleted!');

    	return redirect()->route('autometa.index');
    }
}
