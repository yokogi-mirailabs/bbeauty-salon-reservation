<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\PointCard;
use App\Models\Shop;

class PointCardController extends Controller
{
    public function index(Request $request, Shop $shop)
    {
        $pointCard = PointCard::where('user_id', $request->user()->id)
            ->where('shop_id', $shop->id)
            ->first();

        return Inertia::render('Shop/PointCard/Index', compact('pointCard'));
    }
}
