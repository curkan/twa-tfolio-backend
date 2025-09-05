<?php

declare(strict_types=1);

namespace App\Containers\Telegram\Notifications\Listeners;

use App\Containers\Common\Node\UI\Api\Events\NodeLiked;
use App\Ship\Parents\Listeners\Listener;
use App\Ship\Parents\Models\NodeLikes;
use App\Ship\Parents\Models\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class LikeNodeListener extends Listener
{
    /**
     * @param NodeLiked $event
     *
     * @return void
     */
    public function handle(NodeLiked $event): void
    {
        /** @var User $user */
        $user = $event->nodeLike->node->user; /* @phpstan-ignore-line */

        if ($user == null) {
            return;
        }

        if ($user->getKey() === Auth::id()) {
            return;
        }

        $telegram = Telegram::bot('tfolio');
        $linkToUser = config('telegram.bots.tfolio.link') . '?startapp=' . $event->nodeLike->user->getKey();

        $countLikesByUserForAuthor = NodeLikes::where('user_id', $event->nodeLike->user_id)
            ->where('author_user_id', $event->nodeLike->author_user_id)
            ->withTrashed()
            ->count();

        $response = $telegram->sendMessage([
            'chat_id' => $user->getKey(),
            'text' => "[{$event->nodeLike->user->username}]({$linkToUser}) " . __('telegram.liked_node'), /* @phpstan-ignore-line */
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => true,
            'disable_notification' => $countLikesByUserForAuthor > 1 ? true : false,
        ]);
    }
}
