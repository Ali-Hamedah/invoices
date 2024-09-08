<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

    'invoices',
    'invoices list',
    'paid invoices',
    'partially paid invoices',
    'unpaid invoices',
    'invoices archive',
    'reports',
    'invoices report',
    'customers report',
    'users',
    'users list',
    'users permissions',
    'settings',
    'products',
    'categories',

    'add invoice',
    'delete invoice',
    'export EXCEL',
    'export PDF',
    'change payment status',
    'edit invoice',
    'archive invoice',
    'print invoice',
    'send invoice',
    'add attachment',
    'delete attachment',

    'add user',
    'edit user',
    'delete user',

    'view permission',
    'add permission',
    'edit permission',
    'delete permission',

    'add product',
    'edit product',
    'delete product',

    'add category',
    'edit category',
    'delete category',
    'notifications',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
