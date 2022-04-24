<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

return [
    'user_model' => User::class,

    'permission_model' => Permission::class,

    'role_model' => Role::class,

    'identity_server_url' => env('IDENTITY_SERVER_BASE_URL', 'http://localhost'),

    'identity_server_permission_check_url' => env('IDENTITY_SERVER_BASE_URL', 'http://localhost') . '/api/user/permission-check',

    'identity_server_account_check_url' => env('IDENTITY_SERVER_BASE_URL', 'http://localhost') . '/api/accounts/{accountId}/permission-check'
];