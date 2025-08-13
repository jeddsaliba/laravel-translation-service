<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'locale_id',
        'tags',
        'value'
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    /**
     * The locale that this translation belongs to.
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'translation_tags')->withPivot('tag_id');
    }
}
