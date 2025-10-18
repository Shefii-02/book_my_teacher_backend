<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


     public static function createCompanyRoles($company_id)
    {
        // Create company role
        $role_c             = new Role();
        $role_c->name       = 'company-' . $company_id;
        $role_c->guard_name = 'web';
        $role_c->created_by = $company_id;
        $role_c->is_editable = 1;
        $role_c->is_deletable = 0;
        $role_c->save();

        // $companyPermissions = Permission::where('is_company', '1')->get();
        // $role_c->givePermissionTo($companyPermissions);

        // Create tenant role
        $role_t       = new Role();
        $role_t->name = 'student-' . $company_id;
        $role_t->guard_name = 'web';
        $role_t->created_by = $company_id;
        $role_t->is_editable = 1;
        $role_t->is_deletable = 0;
        $role_t->save();

        // $tenantPermissions = Permission::where('is_tenant', '1')->get();
        // $role_t->givePermissionTo($tenantPermissions);

        // Create owner role
        $role_o       = new Role();
        $role_o->name = 'teacher-' . $company_id;
        $role_o->guard_name = 'web';
        $role_o->created_by = $company_id;
        $role_o->is_editable = 1;
        $role_o->is_deletable = 0;
        $role_o->save();

        // $ownerPermissions = Permission::where('is_owner', '1')->get();
        // $role_o->givePermissionTo($ownerPermissions);

    }


}
