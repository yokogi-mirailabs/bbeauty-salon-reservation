<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Models\Stylist;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\PaymentHistory;
use App\Models\User;
use App\Http\Requests\Admin\Stylist\StoreStylistRequest;
use App\Http\Requests\Admin\Stylist\UpdateStylistRequest;
use App\Http\Requests\Admin\Stylist\DestroyStylistRequest;
use Illuminate\Support\Facades\DB;

class StylistController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Stylist::class);
        $stylists = Stylist::query()
            ->where('shop_id', $request->shop)
            ->orderByDesc('created_at')
            ->get();
        return Inertia::render('Admin/Shop/Stylist/Index', compact('stylists'));
    }

    public function show(Request $request, Shop $shop, Stylist $stylist)
    {
        $this->authorize('view', [$stylist, $shop]);
        $reservations = Reservation::with(['paymentHistories.menu', 'user'])
            ->where('stylist_id', $stylist->id)
            ->get();
        return Inertia::render('Admin/Shop/Stylist/Show', compact('stylist', 'reservations'));
    }

    public function create(Request $request, Shop $shop)
    {
        $this->authorize('create', Stylist::class);
        $menus = Menu::where('shop_id', $shop->id)->get();
        return Inertia::render('Admin/Shop/Stylist/Create', compact('menus'));
    }

    public function store(StoreStylistRequest $request, Shop $shop)
    {
        return DB::transaction(function () use ($request, $shop) {
            $stylist = Stylist::create(array_merge($request->validated(), ['shop_id' => $shop->id]));
            if (count($request->menus) > 0) {
                $stylist->menus()->detach($request->menus);
                $stylist->menus()->attach($request->menus);
            }
            return redirect()->route('admin.stylists.index', ['shop' => $shop->getKey()]);
        });
    }

    public function edit(Shop $shop, Stylist $stylist)
    {
        $this->authorize('update', [$stylist, $shop]);
        $menus = Menu::where('shop_id', $shop->id)->get();
        return Inertia::render('Admin/Shop/Stylist/Edit', compact('stylist', 'menus'));
    }

    public function update(UpdateStylistRequest $request, Shop $shop, Stylist $stylist)
    {
        return DB::transaction(function () use ($request, $stylist, $shop) {
            $stylist->update($request->validated());
            $stylist->refresh();
            if (count($request->menus) > 0) {
                $stylist->menus()->detach($request->menus);
                $stylist->menus()->attach($request->menus);
            }
            return redirect()->route('admin.stylists.index', ['shop' => $shop->getKey()]);
        });
    }

    public function destroy(DestroyStylistRequest $request, Shop $shop, Stylist $stylist)
    {
        return DB::transaction(function () use ($request, $stylist, $shop) {
            $stylist->delete();
            return redirect()->route('admin.stylists.index', ['shop' => $shop->getKey()]);
        });
    }
}
