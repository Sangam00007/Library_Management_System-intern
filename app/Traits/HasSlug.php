<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait and hook into Eloquent events.
     */
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            $model->generateSlug();
        });
    }

    /**
     * Get the attribute to build the slug from.
     */
    protected function getSlugSourceAttribute(): string
    {
        return 'name';
    }

    /**
     * Generate and set the slug.
     */
    public function generateSlug(): void
    {
        $sourceAttribute = $this->getSlugSourceAttribute();

        // Only generate if slug is empty or source attribute has changed
        if (empty($this->slug) || $this->isDirty($sourceAttribute)) {
            $originalSlug = Str::slug($this->{$sourceAttribute});
            $slug = $originalSlug;
            $counter = 1;

            // Loop to check for uniqueness
            while ($this->slugExists($slug)) {
                $slug = $originalSlug.'-'.$counter;
                $counter++;
            }

            $this->slug = $slug;
        }
    }

    /**
     * Check if the slug exists in the database.
     */
    protected function slugExists(string $slug): bool
    {
        $query = static::where('slug', $slug);

        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        return $query->exists();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
