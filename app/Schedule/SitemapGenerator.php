<?php
declare(strict_types=1);

namespace Treiner\Schedule;

use Carbon\Carbon;
use Spatie\Sitemap\SitemapGenerator as SpatieSitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Treiner\Coach;

class SitemapGenerator
{
    public static function create()
    {
        $generator = SpatieSitemapGenerator::create(route('welcome'))->getSitemap();

        $generator->writeToFile(public_path('sitemap.xml'));
    }
}
