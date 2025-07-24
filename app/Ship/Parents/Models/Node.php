<?php

declare(strict_types=1);

namespace App\Ship\Parents\Models;

use App\Ship\Parents\Enums\Nodes\NodeTypeEnum;
use App\Ship\Parents\Factories\NodeFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Node extends Model
{
    /**
     * @var string
     */
    protected $table = 'nodes';


    protected $casts = [
        'type' => NodeTypeEnum::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sort',
        'user_id',
        'x',
        'y',
        'w',
        'h',
        'type',
        'image_id',
        'video_id',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(NodeLikes::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return NodeFactory|null
     */
    protected static function newFactory(): ?NodeFactory
    {
        return NodeFactory::new();
    }
}
