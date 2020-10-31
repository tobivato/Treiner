<?php

namespace Treiner\Policies;

use Treiner\User;
use Treiner\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any conversations.
     *
     * @param  \Treiner\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the conversation.
     *
     * @param  \Treiner\User  $user
     * @param  \Treiner\Conversation  $conversation
     * @return mixed
     */
    public function view(User $user, Conversation $conversation)
    {
        return ($conversation->from == $user) || ($conversation->to == $user);
    }
}
