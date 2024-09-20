<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
 {
    /**
    * Run the database seeds.
    */

    public function run(): void
 {
        Permission::create( [ 'name' => 'product' ] );
        Permission::create( [ 'name' => 'customer' ] );
        Permission::create( [ 'name' => 'suppliers' ] );
        Permission::create( [ 'name' => 'nozzale' ] );
        Permission::create( [ 'name' => 'accounts' ] );
        Permission::create( [ 'name' => 'expense' ] );
        Permission::create( [ 'name' => 'sale' ] );
        Permission::create( [ 'name' => 'purchase' ] );
        Permission::create( [ 'name' => 'reports' ] );
        // Permission::create( [ 'name' => 'party-reports' ] );
        // Permission::create( [ 'name'=> 'order-reports' ] );
        // Permission::create( [ 'name' => 'expense-reports' ] );
        // Permission::create( [ 'name' => 'payment-receiving-reports' ] );
        // Permission::create( [ 'name' => 'summary-reports' ] );
        // Permission::create( [ 'name' => 'party-statements' ] );
        // Permission::create( [ 'name' => 'ledger' ] );
        Permission::create( [ 'name' => 'user-management' ] );

        Role::create( [ 'name' => 'Admin' ] );
        Role::create( [ 'name' => 'User' ] );
    }
}
