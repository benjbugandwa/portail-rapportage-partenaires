<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \App\Models\User::all();
foreach($users as $user) {
    if ($user->role) {
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => $user->role, 'guard_name' => 'web']);
        $user->syncRoles([$user->role]);
        echo "Synced {$user->email} to role {$user->role}\n";
    }
}
