<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Models\Menu;
use App\Http\Requests\Admin\Menu\StoreMenuRequest;
use App\Http\Requests\Admin\Menu\UpdateMenuRequest;
use App\Http\Requests\Admin\Menu\DestroyMenuRequest;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::all();
        return Inertia::render('Admin/Shop/Menu/Index', compact('menus'));
    }

    public function create()
    {
        $this->authorize('create', Menu::class);
        return Inertia::render('Admin/Shop/Menu/Create');
    }

    public function store(StoreMenuRequest $request, Shop $shop)
    {
        return DB::transaction(function () use ($request, $shop) {
            $shop->menus()->create($request->validated());
            return redirect()->route('admin.menus.index', ['shop' => $shop->getKey()]);
        });
    }

    public function edit(Shop $shop, Menu $menu)
    {
        $this->authorize('update', [$menu, $shop]);
        return Inertia::render('Admin/Shop/Menu/Edit', compact('menu'));
    }

    public function update(UpdateMenuRequest $request, Shop $shop, Menu $menu)
    {
        return DB::transaction(function () use ($request, $menu, $shop) {
            $menu->update($request->validated());
            return redirect()->route('admin.menus.index', ['shop' => $shop->getKey()]);
        });
    }

    public function destroy(DestroyMenuRequest $request, Shop $shop, Menu $menu)
    {
        return DB::transaction(function () use ($request, $menu, $shop) {
            $menu->delete();
            return redirect()->route('admin.menus.index', ['shop' => $shop->getKey()]);
        });
    }
}
