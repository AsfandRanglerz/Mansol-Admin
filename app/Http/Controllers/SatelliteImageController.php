<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SatelliteImageController extends Controller
{
    public function fetchImage()
    {
        $latitude = 31.582045;
        $longitude = 74.329376;
        $width = 5;
        $height = 15;

        $url = "https://api-connect.eos.com/api/render/S2/point/latest/$width/$height/$latitude/$longitude?CALIBRATE=1";

       $response = Http::withoutVerifying()
    ->withHeaders([
        'x-api-key' => 'apk.ec114200944764f1f5162bf2efc7cd4ccb9afb90efaa35594cf3058b0244d6da',
    ])
    ->get($url);


        if ($response->successful()) {
            $imageContent = $response->body();

            $filename = 'satellite_image_' . now()->timestamp . '.png';
            Storage::disk('public')->put($filename, $imageContent);

            return response()->download(storage_path("app/public/{$filename}"));
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Image fetch failed',
                'status' => $response->status(),
                'error' => $response->body(),
            ]);
        }
    }
}
