<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugObserver
{
    public function creating(Model $model): void
    {
        if (!empty($model->slug)) {
            return;
        }

        $model->slug = $this->generateUniqueSlug($model);
    }

    private function generateUniqueSlug(Model $model): string
    {
        $baseSlug = Str::slug($model->name);
        $slug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($slug, $model)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists(string $slug, Model $model): bool
    {
        return $model->newQuery()
            ->where('slug', $slug)
            ->exists();
    }
}
