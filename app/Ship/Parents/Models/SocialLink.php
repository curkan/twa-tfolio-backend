<?php

declare(strict_types=1);

namespace App;

namespace App\Ship\Parents\Models;

use Illuminate\Support\Facades\Auth;

class SocialLink extends Model
{
    protected $fillable = [
        'url',
        'user_id',
    ];

    /**
     * @param mixed $query
     *
     * @return mixed
     */
    public function scopeForAuthUser($query)
    {
        return $query->where('user_id', Auth::id());
    }
}
