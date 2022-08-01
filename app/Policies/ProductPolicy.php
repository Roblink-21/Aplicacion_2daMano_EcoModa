<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user;
    }

    public function view(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny("You don't own this product.");
    }

    public function create(User $user)
    {
        return $user;
    }
   
    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny("You don't own this product.");
            
    }

    /**
     * Determine whether the user can delete the model.
     *
     */
    public function delete(User $user, Product $post)
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny("You don't own this product.");
    }

    public function published(?User $user, Product $post){

        if($post -> status == 0){
            return true;
        }else{
            return false;
        }

    }
}
