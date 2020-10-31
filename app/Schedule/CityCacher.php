<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Cache;
use Treiner\Coach;

class CityCacher
{
    public static function create()
    {
        Cache::put('coaches.cities', CityCacher::findAvailableCities());
    }

    public static function findAvailableCities()
    {
        $availableCities = [];

        foreach (array_keys(config('treiner.cities')) as $city) {
            $cityData = config('treiner.cities.'.$city);
            $coachesCount = Coach::search()
                ->orderBy('popularity', 'desc')
                ->aroundLatLng($cityData['latitude'], $cityData['longitude'])
                ->with(['aroundRadius' => 50000])
                ->count();
            if ($coachesCount != 0) {
                $availableCities[$city] = $coachesCount;
            }
        }
        arsort($availableCities);
        return $availableCities;
    }
}
