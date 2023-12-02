<?php

namespace App\Http\Services;

use App\Models\Reservation;
use Carbon\CarbonPeriod;

class AnalyzeService
{
    /**
     * スタイリストの売上を取得
     *
     * @param [type] $shopId
     * @param [type] $stylistId
     * @param [type] $start
     * @param [type] $end
     * @return void
     */
    public function analyzeByStylistId($shopId, $stylistId, $start, $end)
    {
        $reservations = Reservation::with(['paymentHistories.menu', 'user'])
            ->where('shop_id', $shopId)
            ->where('stylist_id', $stylistId)
            ->whereBetween('date', [$start, $end])
            ->get();
        $amountAll = $reservations->sum(function ($reservation) {
            return $reservation->paymentHistories->sum(function ($paymentHistory) {
                return $paymentHistory->menu->price;
            });
        });
        $group = $reservations->groupBy('date');
        $period = CarbonPeriod::create($start, $end)->toArray();
        $labels = [];
        $amounts = [];
        foreach ($period as $date) {
            $labels[] = $date->format('m-d');
            $date = $date->format('Y-m-d H:i:s');
            if (isset($group[$date])) {
                $amounts[] = $group[$date]->sum(function ($reservation) {
                    return $reservation->paymentHistories->sum(function ($paymentHistory) {
                        return $paymentHistory->menu->price;
                    });
                });
            } else {
                $amounts[] = 0;
            }
        }
        return [
            $labels, $amounts, $amountAll
        ];
    }

    /**
     * ユーザーごとの売上を取得
     *
     * @param [type] $shopId
     * @param [type] $start
     * @param [type] $end
     * @return void
     */
    public function analyzeByUser($shopId, $start, $end)
    {
        $reservations = Reservation::with(['paymentHistories.menu', 'user'])
            ->where('shop_id', $shopId)
            ->whereBetween('date', [$start, $end])
            ->get();
        $labels = $reservations->pluck('user')->unique()->pluck('name')->toArray();
        $group = $reservations->groupBy('user_id');
        $amounts = [];
        $counts = [];
        foreach ($group as $reservations) {
            $amounts[] = $reservations->sum(function ($reservation) {
                return $reservation->paymentHistories->sum(function ($paymentHistory) {
                    return $paymentHistory->menu->price;
                });
            });
            $counts[] = $reservations->count();
        }

        return [
            $labels, $amounts, $counts
        ];
    }
}
