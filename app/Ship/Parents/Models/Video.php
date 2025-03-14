<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Video extends Model
{
    /**
     * @var string
     */
    protected $table = 'videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'bucket',
        'link',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function poster(): HasOne
    {
        return $this->hasOne(VideoPoster::class, 'video_id', 'id');
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function makePath(string $key): string
    {
        return config('filesystems.disks.s3_videos.endpoint') .
            '/' .
            config('filesystems.disks.s3_videos.bucket') .
            '/' .
            $this->user->getKey() .
            '/' .
            $this->getKey() .
            '/' . $key;
    }

    /**
     * @return ?string
     */
    public function getVideoUrlAttribute(): ?string
    {
        if ($this->attributes['link'] === null) {
            return null;
        }

        return $this->makePath($this->attributes['link']);
    }
}
