<?php

namespace App\Services\Permission\Traits;

use App\Models\Permission;

trait HasPermissions
{
    /**
     * give permission to user
     * @return HasPermissions
     */
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions->isEmpty()) return $this;

        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    /**
     * detach permission from user
     * @return HasPermissions
     */
    public function withDrawPermissions(...$drawPermissions)
    {
        $permissions = $this->getAllPermissions($drawPermissions);

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * new permissions replace previous permissions
     * @return HasPermissions
     */
    public function refreshPermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        $this->permissions()->sync($permissions);

        return $this;
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * check user has a permission
     * @param Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission)
    {
        return $this->hasPermissionsThroughRole($permission) || $this->permissions->contain($permission);
    }

    /**
     * get permission through role
     * @param Permission $permission
     * @return bool
     */
    protected function hasPermissionsThroughRole(Permission $permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) return true;
        }
        return false;
    }

    /**
     * find all permissions from database in arguments given
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('name', array_flatten($permissions))->get();
    }
}
