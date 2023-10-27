<?php

namespace App\Services\Permission\Traits;

use App\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->blongsToMany(Role::class);
    }

    /**
     * give roles to user
     * @param $roles
     * @return HasRoles
    */
    public function giveRolesTo(...$roles)
    {
        $roles = $this->getAllRoles($roles);

        if ($roles->isEmpty()) return $this;

        $this->roles()->syncWithoutDetaching($roles);

        return $this;
    }

    /**
     * get all roles
     * @param array $roles
     * @return mixed
     */
    protected function getAllRoles(array $roles)
    {
        return Role::whereIn('name', array_flatten($roles))->get();
    }
}
