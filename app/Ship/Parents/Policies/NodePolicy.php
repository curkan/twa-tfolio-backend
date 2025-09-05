<?php

declare(strict_types=1);

namespace App\Ship\Parents\Policies;

use App\Ship\Parents\Models\Node;
use App\Ship\Parents\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class NodePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param Node $node
     *
     * @return bool
     */
    public function update(User $user, Node $node): bool
    {
        return $node->user?->is($user) ?? false;
    }
}
