<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use DB;


class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::with('translation')->orderBy('position', 'asc')->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $page = new Page();
        $page->alias = $request->alias;
        $page->active = $request->active;
        $page->position = $request->active;
        $page->save();

        foreach ($this->langs as $lang):
            $page->translations()->create([
                'lang_id' => $lang->id,
                'slug' => request('slug_' . $lang->lang),
                'title' => request('title_' . $lang->lang),
                'body' => request('body_' . $lang->lang),
                'image' => 'tmp',
                'meta_title' => request('meta_title_' . $lang->lang),
                'meta_keywords' => request('meta_keywords_' . $lang->lang),
                'meta_description' => request('meta_description_' . $lang->lang)
            ]);
        endforeach;

        Session::flash('message', 'New item has been created!');

        return redirect()->route('pages.index');
    }

    public function edit($id)
    {
        $page = Page::with('translations')->findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->alias = $request->alias;
        $page->active = $request->active;
        $page->position = $request->active;
        $page->save();

        $page->translations()->delete();

        foreach ($this->langs as $lang):
            $page->translations()->create([
                'lang_id' => $lang->id,
                'slug' => request('slug_' . $lang->lang),
                'title' => request('title_' . $lang->lang),
                'body' => request('body_' . $lang->lang),
                'image' => 'tmp',
                'meta_title' => request('meta_title_' . $lang->lang),
                'meta_keywords' => request('meta_keywords_' . $lang->lang),
                'meta_description' => request('meta_description_' . $lang->lang)
            ]);

//            if (request('image_' . $lang->lang) != null) {
//                if ($page::where('lang_id', $lang->id))
//            }

        endforeach;
    }


    public function changePosition()
    {
        $neworder = Input::get('neworder');
        $i = 1;
        $neworder = explode("&", $neworder);

        foreach ($neworder as $k => $v) {
            $id = str_replace("tablelistsorter[]=", "", $v);
            if (!empty($id)) {
                $this->model::where('id', $id)->update(['position' => $i]);
                $i++;
            }
        }
    }

    public function status($id)
    {
        $page = Page::findOrFail($id);

        if ($page->active == 1) {
            $page->active = 0;
        } else {
            $page->active = 1;
        }

        $page->save();

        return redirect()->route('pages.index');
    }


    public function delete($id)
    {
        $itemId = $this->model::findOrFail($id);
        if (!is_null($itemId)) {
            $items = $this->modelTrans::where($this->foreignKey, $itemId->id)->get();
            if (!empty($items)) {
                foreach ($items as $key => $item) {
                    if (File::exists('upfiles/' . $this->menu()['modules_name']->src . '/s/' . $item->img))
                        File::delete('upfiles/' . $this->menu()['modules_name']->src . '/s/' . $item->img);

                    if (File::exists('upfiles/' . $this->menu()['modules_name']->src . '/m/' . $item->img))
                        File::delete('upfiles/' . $this->menu()['modules_name']->src . '/m/' . $item->img);

                    if (File::exists('upfiles/' . $this->menu()['modules_name']->src . '/' . $item->img))
                        File::delete('upfiles/' . $this->menu()['modules_name']->src . '/' . $item->img);

                    $this->modelTrans::where('id', $item->id)->delete();
                }
                $this->model::where('id', $id)->delete();
                Session::flash('success', 'Элемент "' . $item->title . '" удален!');
            }
        }

        return redirect()->back();
    }

}
