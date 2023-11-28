<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Http\Requests\Admin\Shop\StoreShopRequest;
use App\Http\Requests\Admin\Shop\UpdateShopRequest;
use App\Http\Requests\Admin\Shop\DestroyShopRequest;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        return Inertia::render('Admin/Shop/Index', compact('shops'));
    }

    public function create()
    {
        $this->authorize('create', Shop::class);
        return Inertia::render('Admin/Shop/Create');
    }

    public function store(StoreShopRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $shop = $request->user()->shops()->create($request->validated());
            return redirect()->route('admin.shops.index');
        });
    }

    public function edit(Shop $shop)
    {
        return Inertia::render('Admin/Shop/Edit', compact('shop'));
    }

    public function update(UpdateShopRequest $request, Shop $shop)
    {
        return DB::transaction(function () use ($request, $shop) {
            $shop->update($request->validated());
            return redirect()->route('admin.shops.index');
        });
    }

    public function destroy(DestroyShopRequest $request, Shop $shop)
    {
        return DB::transaction(function () use ($request, $shop) {
            $shop->delete();
            return redirect()->route('admin.shops.index');
        });
    }
}
