<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
    protected $fillable = [
        'user_id',
        'viewed_user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function viewedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'viewed_user_id');
    }
}
