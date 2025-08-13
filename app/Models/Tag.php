<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Tags can have multiple translations.
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function translations(): BelongsToMany
    {
        return $this->belongsToMany(Translation::class, 'translation_tags')->withPivot('tag_id');
    }
}
