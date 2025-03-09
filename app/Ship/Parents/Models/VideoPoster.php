<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoPoster extends Model
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
     * @param string $key
     *
     * @return string
     */
    public function makePath(string $key): string
    {
        return config('filesystems.disks.yandex_profiles.endpoint') .
            '/' .
            config('filesystems.disks.yandex_profiles.bucket') .
            '/' .
            $this->user->getKey() .
            '/' .
            $this->getKey() .
            '/' . $key;
    }
}
