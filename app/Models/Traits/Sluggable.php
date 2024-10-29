<?php

namespace App\Models\Traits;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait Sluggable
{
    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            // ->doNotGenerateSlugsOnUpdate()
            ->generateSlugsFrom(static::$slugFromColumn ?? 'title')
            ->usingLanguage(static::$slugLocale)->saveSlugsTo('slug');
    }
}
