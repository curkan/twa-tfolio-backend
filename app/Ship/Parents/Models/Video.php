<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
