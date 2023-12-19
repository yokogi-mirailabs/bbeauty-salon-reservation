<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Models\Reservation;
// use App\Http\Requests\Admin\Shop\StoreShopRequest;
// use App\Http\Requests\Admin\Shop\UpdateShopRequest;
// use App\Http\Requests\Admin\Shop\DestroyShopRequest;
use App\Models\Stylist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Enums\ReservationTimeType;

class ReservationController extends Controller
{
    public function index(Request $request, Shop $shop, Stylist $stylist)
    {
        // $this->authorize('viewAny', Reservation::class);
        // 自分の予約一覧を表示(一日前だったら削除可能)
        // ホットペッパーに寄せるならキャンセルしてから再予約させる（updateなし）
        $reservations = $request->user()->reservations()
            ->with(['paymentHistories.menu', 'user', 'shop'])
            ->orderByDesc('created_at')
            ->get();
        return Inertia::render('Shop/Reservation/Index', compact('reservations'));
    }

    public function calendar(Request $request, Shop $shop)
    {
        $stylists = Stylist::with('menus')
            ->where('shop_id', $shop->id)->get();
        // $reservations = collect([]);
        // if ($shop && $request->has('stylist')) {
        //     $stylist = Stylist::find($request->query('stylist'));
        //     $reservations = Reservation::with(['paymentHistories.menu', 'user'])
        //         ->where('shop_id', $shop->id)
        //         ->where('stylist_id', $stylist->id)
        //         ->get();
        // }
        return Inertia::render('Shop/Reservation/Calendar', compact('stylists'));
    }

    public function store(Request $request, Shop $shop)
    {
        return DB::transaction(function () use ($request, $shop) {
            $date = Carbon::parse($request->event['date'])->format('Y-m-d');
            \Log::debug("message: {$date}");
            $startTimeType = collect(ReservationTimeType::cases())->map(function ($timeType) use ($request) {
                \Log::debug("message: {$timeType->value}");
                \Log::debug('startTime', [$request->event['startTime']]);
                if (ReservationTimeType::from($timeType->value)->getLabel() == $request->event['startTime']) {
                    \Log::debug("goal: {$timeType->value}");
                    \Log::debug('goalstartTime', [$request->event['startTime']]);
                    return $timeType->value;
                }
            });
            $start = $startTimeType->first(function ($timeType) {
                return $timeType !== null;
            });
            \Log::debug("message: {$start}");
            $reservation = Reservation::create([
                'user_id' => $request->user()->id,
                'shop_id' => $shop->id,
                'stylist_id' => $request->stylist['id'],
                'date' => $date,
                'start_time_type' => $start,
            ]);
            if (count($request->menus) > 0) {
                foreach ($request->menus as $menu) {
                    $reservation->paymentHistories()->create([
                        'menu_id' => $menu['id'],
                        'price' => $menu['price'],
                        'count' => 1
                    ]);
                }
            }
            if ($request->user()->pointCards->isEmpty()) {
                $shop->pointCards()->create([
                    'user_id' => $request->user()->id,
                    'point' => 1
                ]);
            } else {
                // $pointCard = $shop->pointCards()->where('user_id', $request->user()->id)->first();
                $shop->pointCards()->where('user_id', $request->user()->id)->increment('point', 1);
            }
            return redirect()->route('reservations.thanks', ['shop' => $shop->getKey()]);
        });
    }

    public function cancel(Request $request, Shop $shop, eservation $reservation)
    {
        return DB::transaction(function () use ($request, $reservation) {
            $reservation->paymentHistories->each(function ($paymentHistory) {
                $paymentHistory->delete();
            });
            $reservation->delete();
            return redirect()->route('admin.reservations.index', ['shop' => $shop->getKey()]);
        });
    }

    public function thanks(Request $request)
    {
        // thanksページを表示しながら、通知でポイント付与
        return Inertia::render('Shop/Reservation/Thanks');
    }
}
