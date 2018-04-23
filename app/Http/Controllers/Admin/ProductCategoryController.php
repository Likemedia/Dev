<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ProductCategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $menus = ProductCategory::where('level', 1)->get();

        return view('admin.productCategories.index', compact('menus'));
    }

    public function create()
    {
        $menus = ProductCategory::with('translation')->get();

        return view('admin.menus.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $name = time() . '-' . $request->image->getClientOriginalName();
        $request->image->move('images/menus', $name);

        $menu = new menu();
        $menu->parent_id = $request->parent_id;
        $menu->image = $name;
        $menu->group_id = $request->groupId;
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

        return redirect()->back();
    }

    public function edit($id)
    {
        $menuItem = ProductCategory::with('translations')->findOrFail($id);
        $categories = Category::where('parent_id', 0)->get();
        $pages = Page::with('translation')->where('active', 1)->get();

        return view('admin.menus.edit', compact('menuItem', 'categories', 'pages'));
    }

    public function update(Request $request, $id)
    {
        $menu = ProductCategory::findOrFail($id);

        foreach ($this->langs as $lang):
            $menu->translations()->where('menu_id', $id)->where('lang_id', $lang->id)->update([
                'url' => request('link'),
                'name' => request('name_' . $lang->lang),
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->back();

    }

    public function destroy(Request $request, $id)
    {
        if($id == 0){ $id = $request->parent_id; }

        $menu = ProductCategory::findOrFail($id);

        if ($request->get('with_children') == 'on') {
          // level 1
          if (!is_null($menu)) {
              $parent = $this->deleteOneMenuItem($menu, (int)$id);
              // level 2
              $submenus1 = Category::where('parent_id', $id)->get();
              if (!empty($submenus1)) {
                  foreach ($submenus1 as $submenu1) {
                      $parent = $this->deleteOneMenuItem($submenu1, $parent);
                      // level 3
                      $submenus2 = Category::where('parent_id', $submenu1->id)->get();
                      if (!empty($submenus2)) {
                          foreach ($submenus2 as $key => $submenus2->id) {
                              $parent = $this->deleteOneMenuItem($submenu2, $parent);
                              // level 3
                              $submenus3 = Category::where('parent_id', $submenu2->id)->get();
                              if (!empty($submenus3)) {
                                  foreach ($submenus3 as $key => $submenus3) {
                                      $parent = $this->deleteOneMenuItem($submenu3, $parent);
                                      // level 4
                                      $submenus = Category::where('parent_id', $submenu->id)->get();
                                      if (!empty($submenus)) {
                                          foreach ($submenus as $key => $submenus) {
                                              $parent = $this->deleteOneMenuItem($submenu, $parent);
                                          }
                                      }
                                  }
                              }
                          }
                      }
                  }
              }
          }

        }

        $menu->delete();

        return redirect()->back();
    }


    public function deleteOneMenuItem($menu, $id)
    {
        $menu = ProductCategory::findOrFail($id);
        $menu->delete();
        return $menu;
    }

    public function partialSave(Request $request)
    {
        $category = new ProductCategory();
        $category->parent_id = $request->parent_id;
        $category->save();

        foreach ($this->langs as $lang):
            $category->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'slug' => request('slug_' . $lang->lang),
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->route('categories.index');
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
                ProductCategory::where('id', $value['id'])->update(['parent_id' => 0, 'position' => $positon]);
                if (array_key_exists('children', $value)) {
                    foreach ($value['children'] as $key1 => $value1) {
                        if (!checkPosts($value['id'])) {
                            $positon++;
                            ProductCategory::where('id', $value1['id'])->update(['parent_id' => $value['id'], 'position' => $positon]);
                        }else{
                            $response = false;
                            $parentId = $value['id'];
                            $childId = $value1['id'];
                        }
                        if (array_key_exists('children', $value1)) {
                            foreach ($value1['children'] as $key2 => $value2) {
                                if (!checkPosts($value1['id'])) {
                                    $positon++;
                                    ProductCategory::where('id', $value2['id'])->update(['parent_id' => $value1['id'], 'position' => $positon]);
                                }else{
                                    $response = false;
                                    $parentId = $value1['id'];
                                    $childId = $value2['id'];
                                }
                                if (array_key_exists('children', $value2)) {
                                    foreach ($value2['children'] as $key3 => $value3) {
                                        if (!checkPosts($value2['id'])) {
                                            $positon++;
                                            ProductCategory::where('id', $value3['id'])->update(['parent_id' => $value2['id'], 'position' => $positon]);
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

        return  json_encode (['text' => SelectProductCategoriesTree(1, 0, $curr_id=null), 'message' => $response, 'parentId' =>  $parentId, 'childId' => $childId]);
    }

    public function cleanMenus()
    {
        $menus = MenuTranslation::get();
        if (!empty($menus)) {
            foreach ($menus as $key => $menu) {
                $page = PageTranslation::where('slug', str_replace('/page/', '', $menu->url))->first();
                $category = CategoryTranslation::where('slug', str_replace('/', '', $menu->url))->first();

                if ((is_null($page)) && (is_null($category))) {
                    $menuItem = ProductCategory::find($menu->menu_id);
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
