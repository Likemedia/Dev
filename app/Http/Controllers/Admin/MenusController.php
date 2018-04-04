<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Post;
use App\Models\Category;
use App\Models\Page;
use App\Models\MenuTranslation;
use App\Models\PageTranslation;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class MenusController extends Controller
{
    public function __construct()
    {

        parent::__construct();

        $menus = Menu::all();
        foreach ($menus as $menu):

            $c = Menu::where('parent_id', $menu->id)->first();

            if (is_null($c)) {
                Menu::find($menu->id)->update([
                    'level' => 1,
                ]);
            } else {
                Menu::find($menu->id)->update([
                    'level' => 0,
                ]);
            }
        endforeach;
    }

    public function index()
    {
        $menus = Menu::where('level', 1)->get();
        $categories = Category::where('parent_id', 0)->get();
        $pages = Page::with('translation')->where('active', 1)->get();

        return view('admin.menus.index', compact('menus', 'categories', 'pages'));
    }

    public function create()
    {
        $menus = Menu::with('translation')->get();

        return view('admin.menus.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $name = time() . '-' . $request->image->getClientOriginalName();
        $request->image->move('images/menus', $name);

        $menu = new menu();
        $menu->parent_id = $request->parent_id;
        $menu->image = $name;
        $menu->save();

        foreach ($this->langs as $lang):
            $menu->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'description' => request('description_' . $lang->lang),
                'slug' => request('slug_' . $lang->lang),
                'meta_title' => request('meta_title_' . $lang->lang),
                'meta_keywords' => request('meta_keywords_' . $lang->lang),
                'meta_description' => request('meta_description_' . $lang->lang),
                'alt_attribute' => request('alt_text_' . $lang->lang),
                'image_title' => request('title_' . $lang->lang)
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->route('menus.index');
    }

    public function edit($id)
    {
        $menuItem = Menu::with('translations')->findOrFail($id);

        return view('admin.menus.edit', compact('menuItem'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        if ($request->image != null) {
            if (file_exists('/images/menus/' . $menu->image)) {
                unlink('/images/menus/' . $menu->image);
            }
            $name = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move('images/menus', $name);

            $menu->image = $name;
        }

        $menu->translations()->delete();

        foreach ($this->langs as $lang):
            $menu->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'description' => request('description_' . $lang->lang),
                'slug' => request('slug_' . $lang->lang),
                'meta_title' => request('meta_title_' . $lang->lang),
                'meta_keywords' => request('meta_keywords_' . $lang->lang),
                'meta_description' => request('meta_description_' . $lang->lang),
                'alt_attribute' => request('alt_text_' . $lang->lang),
                'image_title' => request('title_' . $lang->lang)
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->route('menus.index');

        dd($id);
    }

    public function destroy(Request $request, $id)
    {
        if($id == 0){
            $id = $request->parent_id;
        }

        $menu = Menu::findOrFail($id);

        $menus = Menu::all();

        foreach ($menus as $cat):
            if ($menu->id == $cat->parent_id) {
                session()->flash('message', 'Can\'t delete this item, because it has children.');

                return redirect()->route('menus.index');
            }
        endforeach;

        if (file_exists('/images/menus/' . $menu->image)) {
            unlink('/images/menus/' . $menu->image);
        }

        $menu->delete();

        return redirect()->back();
    }

    public function partialSave(Request $request)
    {
        if ($request->get('type') == 'category') {
            if ($request->get('subcategories') == 'on') {
                $parentId = $request->get('parent_id') ?? 0;
                return $this->assignmentCategory($request->get('categoryId'), $parentId);
            }
        }

        $menu = new menu();
        $menu->parent_id = $request->parent_id;
        $menu->save();

        foreach ($this->langs as $lang):
            $menu->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'url' => request('link'),
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->route('menus.index');
    }

    public function assignmentCategory($id, $parentId)
    {
        // level 1
        $category = Category::find($id);
        if (!is_null($category)) {
            $parent = $this->addOneMenuItem($category, (int)$parentId);
            // level 2
            $subCategories1 = Category::where('parent_id', $id)->get();
            if (!empty($subCategories1)) {
                foreach ($subCategories1 as $subcategory1) {
                    $parent = $this->addOneMenuItem($subcategory1, $parent);
                    // level 3
                    $subCategories2 = Category::where('parent_id', $subcategory1->id)->get();
                    if (!empty($subCategories2)) {
                        foreach ($subCategories2 as $key => $subCategory2->id) {
                            $parent = $this->addOneMenuItem($subcategory2, $parent);
                            // level 3
                            $subCategories3 = Category::where('parent_id', $subcategory2->id)->get();
                            if (!empty($subCategories3)) {
                                foreach ($subCategories3 as $key => $subCategory3) {
                                    $parent = $this->addOneMenuItem($subcategory3, $parent);
                                    // level 4
                                    $subCategories = Category::where('parent_id', $subcategory->id)->get();
                                    if (!empty($subCategories)) {
                                        foreach ($subCategories as $key => $subCategory) {
                                            $parent = $this->addOneMenuItem($subcategory, $parent);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        session()->flash('message', 'New item has been created!');

        return redirect()->route('menus.index');
    }

    public function addOneMenuItem($category, $parent)
    {
        $url = '';
        $parentId = $parent;
        $parentId = !is_int($parent) ? $parent->id : $parent;

        $menu = new menu();
        $menu->parent_id = $parentId;
        $menu->save();

        foreach ($this->langs as $lang):
            $url = !is_int($parent) ? $parent->translationByLanguage($lang->id)->first()->url : '';
            $menu->translations()->create([
                'lang_id' => $lang->id,
                'name' => $category->translationByLanguage($lang->id)->first()->name,
                'url' => '/'.$category->translationByLanguage($lang->id)->first()->slug,
            ]);
        endforeach;

        return Menu::find($menu->id);
    }

    public function change()
    {
        $list = Input::get('list');
        $positon = 1;
        $response = true;
        $parentId = 0;
        $childId = 0;

        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $positon++;
                Menu::where('id', $value['id'])->update(['parent_id' => 0, 'position' => $positon]);
                if (array_key_exists('children', $value)) {
                    foreach ($value['children'] as $key1 => $value1) {
                        if (!checkPosts($value['id'])) {
                            $positon++;
                            Menu::where('id', $value1['id'])->update(['parent_id' => $value['id'], 'position' => $positon]);
                        }else{
                            $response = false;
                            $parentId = $value['id'];
                            $childId = $value1['id'];
                        }
                        if (array_key_exists('children', $value1)) {
                            foreach ($value1['children'] as $key2 => $value2) {
                                if (!checkPosts($value1['id'])) {
                                    $positon++;
                                    Menu::where('id', $value2['id'])->update(['parent_id' => $value1['id'], 'position' => $positon]);
                                }else{
                                    $response = false;
                                    $parentId = $value1['id'];
                                    $childId = $value2['id'];
                                }
                                if (array_key_exists('children', $value2)) {
                                    foreach ($value2['children'] as $key3 => $value3) {
                                        if (!checkPosts($value2['id'])) {
                                            $positon++;
                                            Menu::where('id', $value3['id'])->update(['parent_id' => $value2['id'], 'position' => $positon]);
                                        }else{
                                            $response = false;
                                            $parentId = $value2['id'];
                                            $childId = $value3['id'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return  json_encode (['text' => SelectMenusTree(1, 0, $curr_id=null), 'message' => $response, 'parentId' =>  $parentId, 'childId' => $childId]);
    }

    public function movePosts(Request $request)
    {
        $menu = new menu();
        $menu->parent_id = $request->parent_id;
        $menu->save();

        foreach ($this->langs as $lang):
            $menu->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'slug' => request('slug_' . $lang->lang),
            ]);
        endforeach;

        $posts = Post::where('menu_id', $request->parent_id)->get();

        $addToId = $menu->id;

        if ($request->add != 0) {
            $addToId = $request->add;
        }

        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                Post::where('id', $post->id)->update([
                    'menu_id' => $addToId,
                ]);
            }
        }

        session()->flash('message', 'New item has been created!');

        return redirect()->route('menus.index');
    }

    public function movePosts_(Request $request)
    {
        $posts = Post::where('menu_id', $request->parent_id)->get();

        $addToId = $request->add;

        if (!empty($posts)) {
            foreach ($posts as $key => $post) {
                Post::where('id', $post->id)->update([
                    'menu_id' => $addToId,
                ]);
            }
        }

        Menu::where('id', $request->child_id)->update([
            'parent_id' =>  $request->parent_id,
        ]);

        session()->flash('message', 'New item has been created!');

        return redirect()->route('menus.index');
    }

    public function cleanMenus()
    {
        $menus = MenuTranslation::get();
        if (!empty($menus)) {
            foreach ($menus as $key => $menu) {
                $page = PageTranslation::where('slug', str_replace('/page/', '', $menu->url))->first();
                $category = CategoryTranslation::where('slug', str_replace('/', '', $menu->url))->first();

                if ((is_null($page)) && (is_null($category))) {
                    $menuItem = Menu::find($menu->menu_id);
                    if (!is_null($menuItem)) {
                        $menusToDelete = MenuTranslation::where('menu_id', $menuItem->id)->get();
                        if (!empty($menusToDelete)) {
                            foreach ($menusToDelete as $key => $menuToDelete) {
                                MenuTranslation::where('id', $menuToDelete->id)->delete();
                            }
                        }
                    }
                }
            }
        }
        session()->flash('message', 'Menus  cleaned');

        return redirect()->route('menus.index');
    }
}
