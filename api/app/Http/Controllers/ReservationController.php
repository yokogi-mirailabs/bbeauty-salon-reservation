<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Shop;
use App\Models\Reservation;
use App\Http\Requests\Reservation\StoreReservationRequest;
use App\Models\Stylist;
use App\Models\Settlement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Enums\ReservationTimeType;
use App\Notifications\PaymentNotification;
use Payjp\Card;
use Payjp\Payjp;
use Payjp\Customer;
use Payjp\Charge;
use Payjp\Statement;
use Payjp\StatementUrl;
use Payjp\Token;

class ReservationController extends Controller
{
    public function index(Request $request, Shop $shop, Stylist $stylist)
    {
        // $this->authorize('viewAny', Reservation::class);
        // 自分の予約一覧を表示(一日前だったら削除可能)
        // ホットペッパーに寄せるならキャンセルしてから再予約させる（updateなし）
        $reservations = $request->user()->reservations()
            ->with(['paymentHistories.menu', 'user', 'shop', 'stylist'])
            ->orderByDesc('created_at')
            ->get();
        return Inertia::render('Shop/Reservation/Index', compact('reservations'));
    }

    public function calendar(Request $request, Shop $shop)
    {
        $payjpPublicKey = config('payjp.pay_jp_key');
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
        return Inertia::render('Shop/Reservation/Calendar', compact('stylists', 'payjpPublicKey'));
    }

    public function store(StoreReservationRequest $request, Shop $shop)
    {
        return DB::transaction(function () use ($request, $shop) {
            $date = Carbon::parse($request->event['date'])->format('Y-m-d');
            // 要リファクタリング
            $startTimeType = collect(ReservationTimeType::cases())->map(function ($timeType) use ($request) {
                if (ReservationTimeType::from($timeType->value)->getLabel() == $request->event['startTime']) {
                    return $timeType->value;
                }
            });
            $start = $startTimeType->first(function ($timeType) {
                return $timeType !== null;
            });
            $reservation = Reservation::create([
                'user_id' => $request->user()->id,
                'shop_id' => $shop->id,
                'stylist_id' => $request->stylist['id'],
                'date' => $date,
                'start_time_type' => $start,
            ]);
            $price = 0;
            if (count($request->menus) > 0) {
                foreach ($request->menus as $menu) {
                    $price += $menu['price'];
                    $reservation->paymentHistories()->create([
                        'menu_id' => $menu['id'],
                        'price' => $menu['price'],
                        'count' => 1
                    ]);
                }
            }
            // ここでserviceを呼ぶ
            try {
                Payjp::setApiKey(config('payjp.pay_jp_secret'));
                $token = $request->payjp_token;

                // $customer = Customer::create([
                //     'email' => $request->user()->email,
                //     'description' => $request->user()->name,
                //     'card' => $token,
                // ]);
                \Log::debug($token);
                // Customer::retrieve($customer->id)->cards->create(array(
                //         "card" => $token,
                // ));
                // $request->user()->update([
                //     'payjp_customer_id' => $customer->id,
                // ]);

                $result = Charge::create([
                    'card' => $token,
                    "amount" => $price,
                    "currency" => "jpy",
                    "capture" => true,
                ]);
            } catch (\Payjp\Error\Card $e) {
                \Log::error($e->getMessage());
                return redirect()->back()->withErrors(['error' => 'カード情報が正しくありません']);
                throw $e;
            } catch (\Payjp\Error\InvalidRequest $e) {
                \Log::error($e->getMessage());
                return redirect()->back()->withErrors(['error' => 'カード情報が正しくありません']);
                throw $e;
            } catch (\Throwable $e) {
                \Log::error($e->getMessage());
                return redirect()->back()->withErrors(['error' => 'カード情報が正しくありません']);
                throw $e;
            }

            if ($request->user()->pointCards->isEmpty()) {
                $shop->pointCards()->create([
                    'user_id' => $request->user()->id,
                    'point' => 1
                ]);
            } else {
                $shop->pointCards()->where('user_id', $request->user()->id)->increment('point', 1);
            }
            $admin = $shop->admin;
            $admin->notify(new PaymentNotification($request->user()));
            return redirect()->route('reservations.thanks', ['shop' => $shop->getKey()]);
        });
    }

    public function cancel(Request $request, Shop $shop, Reservation $reservation)
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
