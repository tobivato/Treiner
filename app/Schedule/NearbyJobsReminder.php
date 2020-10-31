<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Treiner\Coach;
use Treiner\JobPost;
use Treiner\NewsletterSubscription;
use Treiner\Notifications\NearbyJobsReminder as NearbyJobsReminderNotification;

class NearbyJobsReminder 
{
    public static function create() {
        $coaches = Coach::all();

        foreach ($coaches as $coach) {
            if (!(NewsletterSubscription::find($coach->user->email))) {
                continue;
            }

            if (count($coach->sessions) != 0) {
                $averageLat = $coach->sessions->avg('location.latitude');
                $averageLng = $coach->session->avg('location.longitude');
            }
            else {
                $averageLat = $coach->location->latitude;
                $averageLng = $coach->location->longitude;
            }

            $jobs = JobPost::search('')
                ->aroundLatLng($averageLat, $averageLng)
                ->with(['aroundRadius' => 100000]);

            $coach->user->notify(new NearbyJobsReminderNotification($jobs));
        }
    }
}
