<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class SubscriptionController extends Controller
{
    public function show()
    {
        $ngnPrice = 10000;
        $location = Location::get(request()->ip());

        $exchangeRates = $this->getExchangeRates();

        $premium_price = number_format($ngnPrice, 2) . ' NGN';

        if ($location && $exchangeRates && $exchangeRates[$location->currencyCode]) {
            $exchangeRate = $exchangeRates[$location->currencyCode];
            $premium_price = number_format($ngnPrice * $exchangeRate, 2) . ' ' . $location->currencyCode;
        } else if ($location) {
            $premium_price = number_format($ngnPrice, 2) . ' ' . $location->currencyCode;
        }

        return view('subscription.show', ['premium_price' => $premium_price]);
    }

    private function getExchangeRates()
    {
        $cacheKey = 'exchange_rates';
        $ttl = 120;

        return Cache::remember($cacheKey, $ttl, function () {
            $url = 'https://v6.exchangerate-api.com/v6/' . env('EXCHANGE_RATES_API_KEY') . '/latest/NGN';
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                $rates = $data['conversion_rates'];

                return $rates;
            } else {
                return null;
            }
        });
    }

    public function create()
    {
        $user = Auth::user();
        $user->is_premium = true;
        $user->last_premium_subscription = Carbon::now();
        $user->save();

        return redirect()->route('subscription.show')->with('success', 'You have successfully subscribed to the premium plan.');
    }

    public function cancel()
    {
        $user = Auth::user();
        $user->is_premium = false;
        $user->save();

        return redirect()->route('subscription.show')->with('success', 'You have successfully unsubscribed from the premium plan.');
    }
}
