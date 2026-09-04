<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$roles = Botble\ACL\Models\Role::query()
    ->get(['id', 'name', 'slug', 'permissions'])
    ->toArray();

$users = Botble\ACL\Models\User::query()
    ->with('roles:id,name,slug')
    ->get(['id', 'email', 'username', 'super_user', 'permissions'])
    ->map(fn ($user) => [
        'id' => $user->id,
        'email' => $user->email,
        'username' => $user->username,
        'super_user' => $user->super_user,
        'roles' => $user->roles->toArray(),
        'permissions' => $user->permissions,
    ])
    ->toArray();

echo json_encode([
    'roles' => $roles,
    'users' => $users,
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
