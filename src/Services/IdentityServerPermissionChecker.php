<?php

namespace ChrisBraybrooke\Helpers\Services;

use ChrisBraybrooke\Helpers\Contracts\PermissionChecker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class IdentityServerPermissionChecker
{
    /**
     * Check the user has permission to perform a task.
     *
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        $check = Http::withToken(
            request()->bearerToken()
        )
            ->get(
                config('helpers.identity_server_permission_check_url'),
                [
                    'permission' => $permission
                ]
            );

        if ($check->successful()) {
            return $check->json()['data']['permission'];            
        }

        return false;
    }

    /**
     * Check the user has permission to perform a task.
     *
     * @return bool
     */
    public function hasAccessToAccount($accountId): bool
    {
        $check = Http::withToken(
            request()->bearerToken()
        )
            ->get(
                Str::replace('{accountId}', $accountId, config('helpers.identity_server_account_check_url'))
            );

        if ($check->successful()) {
            return $check->json()['data']['permission'];            
        }

        return false;
    }

    /**
     * Check the user has permission to perform a task.
     *
     * @return bool
     */
    public function hasAccessToEntity($pathToCheck, $data = null): bool
    {
        $check = Http::withToken(
            request()->bearerToken()
        )
            ->get(config('helpers.identity_server_url') . "/api/{$pathToCheck}/permission-check", $data);

        if ($check->successful()) {
            return $check->json()['data']['permission'];            
        }

        return false;
    }
}