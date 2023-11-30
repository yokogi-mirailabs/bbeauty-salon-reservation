<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Http\Requests\Admin\Shop\StoreShopRequest;
use App\Http\Requests\Admin\Shop\UpdateShopRequest;
use App\Http\Requests\Admin\Shop\DestroyShopRequest;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::all();
        return Inertia::render('Shop/Index', compact('shops'));
    }
}
