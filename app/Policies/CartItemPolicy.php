<?php

declare(strict_types=1);

namespace Treiner\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Treiner\CartItem;
use Treiner\Player;
use Treiner\User;

class CartItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any cart items.
     */
    public function viewAny(User $user)
    {
        return $user->role instanceof Player;
    }

    /**
     * Determine whether the user can view the cart item.
     */
    public function view(User $user, CartItem $cartItem)
    {
        return $cartItem->player->user === $user;
    }

    /**
     * Determine whether the user can create cart items.
     */
    public function create(User $user)
    {
        return $user->role instanceof Player;
    }

    /**
     * Determine whether the user can update the cart item.
     */
    public function update(User $user, CartItem $cartItem)
    {
        return $cartItem->player->user === $user;
    }

    /**
     * Determine whether the user can delete the cart item.
     */
    public function delete(User $user, CartItem $cartItem)
    {
        return $cartItem->player->user === $user;
    }

    public function complete(User $user)
    {
        return $user->role instanceof Player;
    }
}
