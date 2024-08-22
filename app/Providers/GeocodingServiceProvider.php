<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\StatefulGeocoder;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;

class GeocodingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(StatefulGeocoder::class, function () {
            $client = new GuzzleAdapter();
            $geocoder = new GoogleMaps($client, env('AIzaSyBTou7SZEbSRKX37-awgtPfz48wSnlWUp0'));
            return new StatefulGeocoder($geocoder, 'en');
        });
    }
}
