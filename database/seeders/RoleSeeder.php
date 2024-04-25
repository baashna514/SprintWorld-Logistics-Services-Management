<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        Role::create(['name' => 'System Administrator']);
        Role::create(['name' => 'OPS']);
        Role::create(['name' => 'MGMT']);
        Role::create(['name' => 'Accountant']);
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
        $user->assignRole('System Administrator');

        $pritesh = User::create([
            'name' => 'Pritesh',
            'email' => 'pritesh@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $pritesh->assignRole('MGMT');

        $nirav = User::create([
            'name' => 'Nirav',
            'email' => 'nirav@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $nirav->assignRole('MGMT');

        $sam = User::create([
            'name' => 'Sam',
            'email' => 'sam@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $sam->assignRole('OPS');

        $ketan = User::create([
            'name' => 'Ketan',
            'email' => 'ketan@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $ketan->assignRole('OPS');

        $darshan = User::create([
            'name' => 'Darshan',
            'email' => 'darshan@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $darshan->assignRole('OPS');

        $ronak = User::create([
            'name' => 'Ronak',
            'email' => 'ronak@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $ronak->assignRole('OPS');

        $sagar = User::create([
            'name' => 'Sagar',
            'email' => 'sagar@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $sagar->assignRole('OPS');

        $additional1 = User::create([
            'name' => 'Additional1',
            'email' => 'additional1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $additional1->assignRole('OPS');

        $sunil = User::create([
            'name' => 'Sunil',
            'email' => 'sunil@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $sunil->assignRole('Accountant');

        $additional2 = User::create([
            'name' => 'Additional2',
            'email' => 'additional2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $additional2->assignRole('Accountant');
    }
}
