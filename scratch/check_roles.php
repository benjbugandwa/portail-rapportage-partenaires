<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \App\Models\User::all();
foreach($users as $u) {
    echo "User: {$u->email} | DB Role: {$u->role} | Spatie Roles: " . $u->roles->pluck('name')->join(', ') . "\n";
}
