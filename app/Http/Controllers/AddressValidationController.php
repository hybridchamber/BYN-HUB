<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AddressValidationController extends Controller
{
    public function getRegions()
    {
        try {
            $response = Http::get('https://psgc.gitlab.io/api/island-groups/luzon/regions/');
            return response()->json($response->json());
        } catch (\Exception $e) {
            Log::error('Error fetching regions: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch regions'], 500);
        }
    }

    public function getProvinces($regionCode)
    {
        try {
            $response = Http::get("https://psgc.gitlab.io/api/regions/{$regionCode}/provinces/");
            return response()->json($response->json());
        } catch (\Exception $e) {
            Log::error('Error fetching provinces: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch provinces'], 500);
        }
    }

    public function getMunicipalities($provinceCode)
    {
        try {
            $response = Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities/");
            return response()->json($response->json());
        } catch (\Exception $e) {
            Log::error('Error fetching municipalities: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch municipalities'], 500);
        }
    }

    public function getBarangays($municipalityCode)
    {
        try {
            $response = Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$municipalityCode}/barangays/");
            return response()->json($response->json());
        } catch (\Exception $e) {
            Log::error('Error fetching barangays: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch barangays'], 500);
        }
    }
}