<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class LineLoginController extends Controller
{
    public function redirectToProvider(Request $request)
    {

        $csrfToken = Str::random(32);
        $queryData = [
            'response_type' => 'code',
            'client_id' => config('services.line.client_id'),
            'redirect_uri' => config('services.line.redirect'),
            'state' => $csrfToken,
            'scope' => 'profile openid',
        ];
        $queryParams = http_build_query($queryData, '', '&');
        $redirectUri = 'https://access.line.me/oauth2/v2.1/authorize?' . $queryParams;

        return response()->json(['redirect_uri' => $redirectUri]);

    }

    public function handleProviderCallback(Request $request)
    {
        $code = $request->query('code');
        $provider = $request->provider;
        $tokenInfo = $this->fetchTokenInfo($code);
        $socialUser = $this->fetchUserInfo($tokenInfo->access_token);

        $user = User::where(function($query) use($socialUser, $provider){
            $query->where('provider_name', $provider)
                ->where('provider_id', $socialUser->userId);
        })
        ->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->displayName,
                'provider_name' => $provider,
                'provider_id' => $socialUser->userId,
            ]);
        }

        auth()->login($user);
        return redirect('/shops');
    }

    private function fetchUserInfo($accessToken)
    {
        $baseUri = ['base_uri' => 'https://api.line.me/v2/'];
        $method = 'GET';
        $path = 'profile';
        $headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ];
        $userInfo = $this->sendRequest($baseUri, $method, $path, $headers);

        return $userInfo;
    }

    private function fetchTokenInfo($code)
    {
        $baseUri = ['base_uri' => 'https://api.line.me/oauth2/v2.1/'];
        $method = 'POST';
        $path = 'token';
        $headers = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];
        $formParams = [
            'form_params' => [
                'code'          => $code,
                'client_id' => config('services.line.client_id'),
                'client_secret' => config('services.line.client_secret'),
                'redirect_uri'  => config('services.line.redirect'),
                'grant_type'    => 'authorization_code'
            ]
        ];
        $tokenInfo = $this->sendRequest($baseUri, $method, $path, $headers, $formParams);

        return $tokenInfo;
    }

    private function sendRequest($baseUri, $method, $path, $headers, $formParams = null)
    {
        try {

            $client = new Client($baseUri);

            if ($formParams) {
                $response = $client->request($method, $path, $formParams, $headers);
            } else {
                $response = $client->request($method, $path, $headers);
            }
        } catch(\Exception $e) {}

        return json_decode($response->getbody()->getcontents());
    }
}
