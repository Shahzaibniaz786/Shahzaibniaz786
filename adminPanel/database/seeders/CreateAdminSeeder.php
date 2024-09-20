<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminSeeder extends Seeder {
    public function run(): void {
        // Check if the user already exists
        $user = User::where( 'email', 'admin@gmail.com' )->first();

        if ( !$user ) {
            $user = User::create( [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make( 'admin123' ),
            ] );
        }

        // Check if the role exists and create it if not
        $role = Role::firstOrCreate( [ 'name' => 'Admin' ] );

        // Define permissions
        $permissions = [
            'product',
            'customer',
            'suppliers',
            'nozzale',
            'accounts',
            'expense',
            'sale',
            'purchase',
            'reports',
            // 'party-reports',
            // 'order-reports',
            // 'expense-reports',
            // 'payment-receiving-reports',
            // 'summary-reports',
            // 'party-statements',
            // 'ledger',
            'user-management'
        ];

        // Ensure each permission exists and is assigned to the role
        foreach ( $permissions as $permission ) {
            $perm = Permission::firstOrCreate( [ 'name' => $permission ] );
            $role->givePermissionTo( $perm );
        }

        // Assign the role to the user
        if ( !$user->hasRole( $role->name ) ) {
            $user->assignRole( $role );
        }
    }
}
