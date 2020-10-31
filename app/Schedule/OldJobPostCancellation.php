<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Carbon\Carbon;
use Log;
use Treiner\JobPost;
use Treiner\Notifications\OldJobPostNotification;

class OldJobPostCancellation
{
    public static function create()
    {
        $now = Carbon::now();
        
        $jobPosts = JobPost::withTrashed()->whereDate('starts', '<', $now)->get();

        foreach ($jobPosts as $jobPost) {
            $jobPost->player->user->notify(new OldJobPostNotification());

            $jobPost->jobOffers()->delete();
            $jobPost->invitations()->delete();
            $jobPost->forceDelete();
        }
        
        return $jobPosts;
    }
}
