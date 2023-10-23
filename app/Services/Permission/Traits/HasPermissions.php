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

    public function permissions()
    {
        return $this->blongsToMany(Permission::class);
    }

    /**
     * find all permissions in arguments given
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('name', array_flatten($permissions))->get();
    }
}
