<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugObserver
{
    public function creating(Model $model): void
    {
        if ($model->getAttribute('slug')) {
            return;
        }

        $model->setAttribute('slug', $this->generateUniqueSlug($model));
    }

    private function generateUniqueSlug(Model $model): string
    {
        $name = $model->getAttribute('name') ?? $model->getAttribute('title');
        $baseSlug = Str::slug($name);

        if(!$baseSlug) {
            $baseSlug = 'item';
        }

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
        $query = $model->newQuery()
            ->where('slug', $slug);

        if($model instanceof \App\Models\Lesson) {
            $query->where('chapter_id', $model->getAttribute('chapter_id'));
        }


        return $query->exists();
    }
}
