<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnggotaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if($user->isAnggota()){
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Anggota $anggota)
    {
        if($user->isAnggota() && ($user->id == $anggota->user->id)){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Anggota $anggota)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Anggota $anggota)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Anggota $anggota)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Anggota $anggota)
    {
        //
    }
}
