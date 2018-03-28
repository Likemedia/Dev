<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostRating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsRatingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rating = PostRating::first();

        return view('admin.rating.index', compact('rating'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'votes_from' => 'required|numeric',
            'votes_to' => 'required|numeric',
            'rating_from' => 'required|numeric|min:1|max:5',
            'rating_to' => 'required|numeric|min:1|max:5',
        ]);

        $rates = PostRating::first() ?? new PostRating();
        $rates->votes_from = $request->votes_from;
        $rates->votes_to = $request->votes_to;
        $rates->rating_from = $request->rating_from;
        $rates->rating_to = $request->rating_to;
        $rates->save();

        session()->flash('message', 'Successful update');

        return redirect()->route('reviews.index');
    }
}


