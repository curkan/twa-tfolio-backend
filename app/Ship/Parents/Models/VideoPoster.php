<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoPoster extends Model
{
    /**
     * @var string
     */
    protected $table = 'video_posters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'video_id',
        'bucket',
        'original',
        'md',
        'sm',
        'xs',
    ];

    /**
     * @return BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return ?string
     */
    public function getPictureOriginalAttribute(): ?string
    {
        if ($this->attributes['original'] === null) {
            return null;
        }

        return $this->makePath($this->attributes['original']);
    }

    /**
     * @return ?string
     */
    public function getPictureMdAttribute(): ?string
    {
        if ($this->attributes['md'] === null) {
            return null;
        }

        return $this->makePath($this->attributes['md']);
    }

    /**
     * @return ?string
     */
    public function getPictureSmAttribute(): ?string
    {
        if ($this->attributes['sm'] === null) {
            return null;
        }

        return $this->makePath($this->attributes['sm']);
    }

    /**
     * @return ?string
     */
    public function getPictureXsAttribute(): ?string
    {
        if ($this->attributes['xs'] === null) {
            return null;
        }

        return $this->makePath($this->attributes['xs']);
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
            $this->video->user->getKey() .
            '/' .
            $this->video->getKey() .
            '/posters/' . $key;
    }
}
