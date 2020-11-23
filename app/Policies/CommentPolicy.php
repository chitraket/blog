<?php

namespace App\Policies;

use App\Model\admin\admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Model\user\User  $user
     * @return mixed
     */
    public function viewAny(admin $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Model\user\User  $user
     * @param  \App\comment  $comment
     * @return mixed
     */
    public function view(admin $user)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Model\user\User  $user
     * @return mixed
     */
    public function create(admin $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Model\user\User  $user
     * @param  \App\comment  $comment
     * @return mixed
     */
    public function update(admin $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Model\user\User  $user
     * @param  \App\comment  $comment
     * @return mixed
     */
    public function delete(admin $user)
    {
        //
        return $this->getPermission($user,25);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Model\user\User  $user
     * @param  \App\comment  $comment
     * @return mixed
     */
    public function restore(admin $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Model\user\User  $user
     * @param  \App\comment  $comment
     * @return mixed
     */
    public function forceDelete(admin $user)
    {
        //
    }
    protected function getPermission($user,$p_id)
    {
        foreach($user->roles as $role)
        {
            foreach($role->permissions as $permission)
            {
                if($permission->id == $p_id)
                {
                    return true;
                }
            }
        }
        return false;
    }
}
