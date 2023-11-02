<?php

namespace App\Services\Permission\Traits;

use App\Models\Role;

trait HasRoles
{
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
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
     * detach roles
     * @param $roles
     * @return HasRoles
     */
    public function withDrawRoles(...$roles)
    {
        $roles = $this->getAllRoles($roles);

        $this->roles()->detach($roles);

        return $this;
    }

    /**
     * new roles replace previous roles
     * @param $roles
     * @return HasRoles
     */
    public function refreshRoles(...$roles)
    {
        $roles = $this->getAllRoles($roles);

        $this->roles()->sync($roles);

        return $this;
    }

    /**
     * check user has role
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role)
    {
        return $this->roles->contains('name', $role);
    }

    /**
     * find all roles from database in arguments given
     */
    protected function getAllRoles(array $roles)
    {
        return Role::whereIn('name', array_flatten($roles))->get();
    }
}
