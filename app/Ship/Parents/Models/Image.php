<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    /**
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'bucket',
        'original',
        'md',
        'sm',
        'xs',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return config('filesystems.disks.yandex_profiles.endpoint') .
            '/' .
            config('filesystems.disks.yandex_profiles.bucket') .
            '/' .
            $this->user->getKey() .
            '/' . $key;
    }


    // /**
    //  * @return UserFactory|null
    //  */
    // protected static function newFactory(): ?UserFactory
    // {
    //     return UserFactory::new();
    // }
}
