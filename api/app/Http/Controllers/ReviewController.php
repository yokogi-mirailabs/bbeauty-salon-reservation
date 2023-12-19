<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function index(Request $request, Shop $shop)
    {
        $reviews = Review::where('shop_id', $shop->id)
            ->orderByDesc('created_at')
            ->get();
        return Inertia::render('Shop/Review/Index', compact('reviews'));
    }

    public function create(Request $request, Shop $shop)
    {
        return Inertia::render('Shop/Review/Create', compact('shop'));
    }

    public function store(Request $request, Shop $shop)
    {
        return DB::transaction(function () use ($request, $shop) {
            $review = Review::create([
                'user_id' => $request->user()->id,
                'shop_id' => $shop->id,
                'good_flag' => $request->good_flag,
                'evaluation' => $request->evaluation,
                'body' => $request->body,
            ]);
            return redirect()->route('reviews.index', ['shop' => $shop]);
        });
    }

    public function edit(Request $request, Shop $shop, Review $review)
    {
        return Inertia::render('Shop/Review/Edit', compact('shop', 'review'));
    }

    public function update(Request $request, Shop $shop, Review $review)
    {
        return DB::transaction(function () use ($request, $shop, $review) {
            $review->update([
                'good_flag' => $request->good_flag,
                'evaluation' => $request->evaluation,
                'body' => $request->body,
            ]);
            return redirect()->route('reviews.index', ['shop' => $shop]);
        });
    }

    public function destroy(Request $request, Shop $shop, Review $review)
    {
        return DB::transaction(function () use ($request, $shop, $review) {
            $review->delete();
            return redirect()->route('reviews.index', ['shop' => $shop]);
        });
    }
}
