<?php

namespace App\Http\Controllers\HRMS;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use App\Traits\ActivityLogger;

class RoleController extends Controller
{
  use ActivityLogger;
  public function index()
  {
    $roles = Role::where('created_by', 1)->get();
    return view('company.hrms.roles.index')->with('roles', $roles);
  }

  public function create()
  {
    // if (Auth::user()->can('create role')) {
    $user_id = 1;
    $permissions = Permission::whereHas('company_permissions', function ($query) use ($user_id) {
      $query->where('company_id', $user_id);
    })->get();

    return view('company.hrms.roles.form', compact('permissions'));
    // } else {
    //   return redirect()->back()->with('error', 'Permission denied.');
    // }
  }

  public function show($id)
  {
    $company_id = 1;
    // if (Auth::user()->can('role details')) {
      $role = Role::with('permissions')->where('created_by', '=', $company_id)->findOrFail($id);
      $allPermissions = Permission::all();

      return view('company.hrms.roles.show', compact('role', 'allPermissions'));
    // } else {
    //   return redirect()->back()->with('error', 'Permission denied.');
    // }
  }

  public function store(Request $request)
  {
    $company_id= 1;
    // Step 1: Prepare _name field
    $request->merge([
      '_name' => $request->input('name') . '-' . $company_id
    ]);

    // Step 2: Validate everything at once
    $validator = Validator::make(
      $request->all(),
      [
        'name' => [
          'required',
          'max:100',
          'regex:/^[A-Za-z\s]+$/', // Only letters and spaces
        ],
        '_name' => [
          'required',
          'max:100',
          'unique:roles,name,NULL,id,created_by,' . $company_id,
        ],
        'permissions' => 'required|array|min:1',
      ],
      [
        'name.regex' => 'The name must only contain letters and spaces.',
        'permissions.required' => 'At least one permission must be selected.',
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()->with('error', $validator->errors()->first());
    }

    // Step 3: Store the role
    $role = new Role();
    $role->name = $request['_name']; // Save the unique merged name
    $role->is_editable = 1;
    $role->is_deletable = 1;
    $role->created_by = 1;
    $role->save();

    // Step 4: Attach permissions
    foreach ($request['permissions'] as $permission) {
      $p = Permission::findOrFail($permission);
      $role->givePermissionTo($p);
    }

    // $this->logActivity(
    //   'Role as Created',
    //   'Role Name ' . $role->name,
    //   route('company.hrms.roles.index'),
    //   'Role Name ' . $role->name . ' is Created successfully',
    //   Auth::user()->creatorId(),
    //   Auth::user()->id
    // );

    return redirect()->route('company.hrms.roles.index')->with('success', 'Role successfully created.');
  }

  public function edit(Role $role)
  {

      $company_id = 1;
      $permissions = Permission::whereHas('company_permissions', function ($query) use ($company_id) {
        $query->where('company_id', 'LIKE', '%' . $company_id . '%');
      });

      if ($role->name == 'teacher') {
        $permissions = $permissions->where('is_teacher', 1);
      } else if ($role->name == 'student') {
        $permissions = $permissions->where('is_student', 1);
      } else if ($role->name == 'company') {
        $permissions = $permissions->where('is_company', 1);
      }

      $permissions = $permissions->get();

      return view('company.hrms.roles.form', compact('role', 'permissions'));
    // } else {
    //   return redirect()->back()->with('error', 'Permission denied.');
    // }
  }

  public function update(Request $request, Role $role)
  {

      $company_id = 1;
      // Merge custom _name to apply uniqueness check with company ID
      $request->merge([
        '_name' => $request->input('name') . '-' . $company_id,
      ]);

      // Validation
      $validator = Validator::make(
        $request->all(),
        [
          'name' => [
            'required',
            'max:100',
            'regex:/^[A-Za-z\s]+$/', // Only letters and spaces
          ],
          '_name' => [
            'required',
            'max:100',
            Rule::unique('roles', 'name')
              ->where('created_by', $company_id)
              ->ignore($role->id),
          ],
          'permissions' => 'required|array|min:1',
        ],
        [
          'name.regex' => 'The name must only contain letters and spaces.',
          'permissions.required' => 'At least one permission must be selected.',
        ]
      );

      if ($validator->fails()) {
        return redirect()->back()->with('error', $validator->errors()->first());
      }

      if ($role->name == 'teacher-' . $company_id || $role->name == 'student-' . $company_id || $role->name == 'company-' . $company_id) {
      } else {
        $role->name = $request['_name'];
      }


      // Update role

      $role->save();

      // Sync permissions
      $permissions = Permission::whereIn('id', $request->permissions)->get();
      $role->syncPermissions($permissions);

      // $this->logActivity(
      //   'Role as Updated',
      //   'Role Name ' . $role->name,
      //   route('company.hrms.roles.index'),
      //   'Role Name ' . $role->name . ' is Updated successfully',
      //   Auth::user()->creatorId(),
      //   Auth::user()->id
      // );

      return redirect()->route('company.hrms.roles.index')->with('success', 'Role successfully updated.');

  }


  public function destroy(Role $role)
  {
    // if (Auth::user()->can('delete role')) {
      $role->delete();

      // $this->logActivity(
      //   'Role as Deleted',
      //   'Role Name ' . $role->name,
      //   route('company.hrms.roles.index'),
      //   'Role Name ' . $role->name . ' is Deleted successfully',
      //   Auth::user()->creatorId(),
      //   Auth::user()->id
      // );
      return redirect()->route('company.hrms.roles.index')->with(
        'success',
        'Role successfully deleted.'
      );
    // } else {
    //   return redirect()->back()->with('error', 'Permission denied.');
    // }
  }
}
