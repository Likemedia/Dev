<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->save();

        foreach ($this->langs as $lang):
            $product->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'body' => request('body_' . $lang->lang),
                'alias' => request('slug_' . $lang->lang),
                'meta_h1' => request('meta_h1_' . $lang->lang),
                'meta_title' => request('meta_title_' . $lang->lang),
                'meta_keywords' => request('meta_keywords_' . $lang->lang),
                'meta_description' => request('meta_description_' . $lang->lang),
            ]);
        endforeach;

        session()->flash('message', 'New item has been created!');

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with(['translations'])->findOrFail($id);

        $categories = ProductCategory::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Product::findOrFail($id);
        $post->category_id = $request->category_id;
        $post->save();

        $post->translations()->delete();

        foreach ($this->langs as $lang):
            $post->translations()->create([
                'lang_id' => $lang->id,
                'name' => request('name_' . $lang->lang),
                'body' => request('body_' . $lang->lang),
                'alias' => request('slug_' . $lang->lang),
                'meta_h1' => request('meta_h1_' . $lang->lang),
                'meta_title' => request('meta_title_' . $lang->lang),
                'meta_keywords' => request('meta_keywords_' . $lang->lang),
                'meta_description' => request('meta_description_' . $lang->lang),
            ]);



        endforeach;


        session()->flash('message', 'Item has been edited!');

        return redirect()->route('posts.category', $request->category_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
