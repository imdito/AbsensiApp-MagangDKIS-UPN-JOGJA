<?php
namespace App\Http\Services;

use App\Models\User;

class LocationService
{
    public function getDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    /**
     * Mengecek apakah user berada di dalam radius
     */
    public function isWithinRadius($userLat, $userLon, $user_id, $radius = 50): bool
    {
        $user = User::with('bidang.skpd')->find($user_id);
        if (!$user || !$user->bidang->skpd->Latitude || !$user->bidang->skpd->Longitude) {
            return false;
        }
        $targetLat = $user->bidang->skpd->Latitude;
        $targetLon = $user->bidang->skpd->Longitude;
        return $this->getDistance($userLat, $userLon, $targetLat, $targetLon) <= $radius;
    }
}
