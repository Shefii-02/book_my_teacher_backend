<?php

namespace App\Http\Controllers\HRMS;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
  public function index()
  {
    $staffs = User::where('company_id', 1)
      ->whereIn('acc_type', ['staff', 'teacher'])
      ->latest()
      ->get();

    return view('company.hrms.team.staff.index', compact('staffs'));
  }

  public function create()
  {
    $designations = Role::where('created_by', 1)->where('is_deletable', 1)->get();
    return view('company.hrms.team.staff.form', compact('designations'));
  }

  public function store(Request $request)
  {
    $company_id = 1;
    // --- Validation ---
    $request->validate([
      'name'          => 'required|string|max:255',
      'email'         => [
        'required',
        'email',
        Rule::unique('users')->where(function ($query) use ($request) {
          return $query->where('company_id', $request->company_id);
        }),
      ],
      'mobile'        => 'required|string|max:15',
      'address'       => 'required|string|max:255',
      'city'          => 'required|string|max:100',
      'district'      => 'required|string|max:100',
      'state'         => 'required|string|max:100',
      'country'       => 'required|string|max:100',
      'postal_code'   => 'required|string|max:10',
      'salary_type'   => 'required|in:monthly,hourly',
      'joining_date'  => 'required|date',
      'designation'   => 'required',
      'payment_mode'  => 'nullable|string|max:50',
      'allowances'    => 'nullable|numeric|min:0',
      'deductions'    => 'nullable|numeric|min:0',
      'final_salary'  => 'nullable|numeric|min:0',
      'profile'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // --- Conditional validation ---
    if ($request->salary_type === 'hourly') {
      $request->validate([
        'hourly_rate' => 'required|numeric|min:1',
      ]);
    } else {
      $request->validate([
        'basic_salary' => 'required|numeric|min:1',
      ]);
    }


    // --- Create Staff ---
    $staff = User::create([
      'company_id'  => $company_id,
      'name'        => $request->name,
      'email'       => $request->email,
      'mobile'      => $request->mobile,
      'address'     => $request->address,
      'city'        => $request->city,
      'district'    => $request->district,
      'state'       => $request->state,
      'country'     => $request->country,
      'postal_code' => $request->postal_code,
      'acc_type'    => 'staff',
      'status'   => $request->boolean('status', true),
      'password'    => Hash::make('123456'), // Default password
    ]);

    // --- Compute Final Salary if not given ---
    $finalSalary = $request->final_salary ?? (
      $request->salary_type === 'hourly'
      ? ($request->hourly_rate * ($request->total_hours ?? 0))
      : (($request->basic_salary ?? 0) + ($request->allowances ?? 0) - ($request->deductions ?? 0))
    );

    // --- Create Payroll ---
    PayrollDetail::create([
      'user_id'       => $staff->id,
      'salary_type'   => $request->salary_type,
      'basic_salary'  => $request->salary_type === 'monthly' ? $request->basic_salary : null,
      'hourly_rate'   => $request->salary_type === 'hourly' ? $request->hourly_rate : null,
      'allowances'    => $request->allowances ?? 0,
      'deductions'    => $request->deductions ?? 0,
      'joining_date'  => $request->joining_date,
      'payroll_type'  => $request->payroll_type ?? 'auto',
      'payment_mode'  => $request->payment_mode ?? 'cash',
      'is_paid'       => $request->boolean('is_paid', false),
      'final_salary'  => $finalSalary,
    ]);


    // --- Upload Profile ---
    if ($request->hasFile('profile')) {
      $profile = MediaHelper::uploadCompanyFile(
        $company_id,
        'users',
        $request->file('profile'),
        'avatar',
        $staff->id
      );
    }



    $role_r = Role::findById($request->designation);
    $staff->assignRole($role_r);


    return redirect()->route('company.hrms.teams.index')
      ->with('success', 'Staff created successfully!');
  }


  public function edit($id)
  {
    $staff = User::with('payroll')->findOrFail($id);

    $designations = Role::where('created_by', 1)->where('is_deletable', 1)->get();
    return view('company.hrms.team.staff.form', compact('staff', 'designations'));
  }

  public function update(Request $request, $id)
  {
    $staff = User::findOrFail($id);
    $company_id = 1;

    // --- Validation ---
    $request->validate([
      'name'          => 'required|string|max:255',
      'email'         => ['required', 'email', Rule::unique('users')->ignore($id)],
      'mobile'        => 'required|string|max:15',
      'address'       => 'required|string|max:255',
      'city'          => 'required|string|max:100',
      'district'      => 'required|string|max:100',
      'state'         => 'required|string|max:100',
      'country'       => 'required|string|max:100',
      'postal_code'   => 'required|string|max:10',
      'salary_type'   => 'required|in:monthly,hourly',
      'joining_date'  => 'required|date',
      'designation'   => 'required',
      'payment_mode'  => 'nullable|string|max:50',
      'allowances'    => 'nullable|numeric|min:0',
      'deductions'    => 'nullable|numeric|min:0',
      'final_salary'  => 'nullable|numeric|min:0',
      'profile'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->salary_type === 'hourly') {
      $request->validate(['hourly_rate' => 'required|numeric|min:1']);
    } else {
      $request->validate(['basic_salary' => 'required|numeric|min:1']);
    }

    if ($request->hasFile('profile')) {
      MediaHelper::removeCompanyFile($staff->avatar->id);
      $profile = MediaHelper::uploadCompanyFile(
        $company_id,
        'users',
        $request->file('profile'),
        'avatar',
        $staff->id
      );
    }

    // --- Update Staff Info ---
    $staff->update([
      'name'        => $request->name,
      'email'       => $request->email,
      'mobile'      => $request->mobile,
      'address'     => $request->address,
      'city'        => $request->city,
      'district'    => $request->district,
      'state'       => $request->state,
      'country'     => $request->country,
      'postal_code' => $request->postal_code,
      'status'   => $request->boolean('status', true),
    ]);

    // --- Recalculate Final Salary if needed ---
    $finalSalary = $request->final_salary ?? (
      $request->salary_type === 'hourly'
      ? ($request->hourly_rate * ($request->total_hours ?? 0))
      : (($request->basic_salary ?? 0) + ($request->allowances ?? 0) - ($request->deductions ?? 0))
    );

    // --- Update or Create Payroll ---
    $staff->payroll()->updateOrCreate(
      ['user_id' => $staff->id],
      [
        'salary_type'   => $request->salary_type,
        'basic_salary'  => $request->salary_type === 'monthly' ? $request->basic_salary : null,
        'hourly_rate'   => $request->salary_type === 'hourly' ? $request->hourly_rate : null,
        'allowances'    => $request->allowances ?? 0,
        'deductions'    => $request->deductions ?? 0,
        'final_salary'  => $finalSalary,
        'joining_date'  => $request->joining_date,
        'payment_mode'  => $request->payment_mode ?? 'cash',
        'payroll_type'  => $request->payroll_type ?? 'auto',
        'is_paid'       => $request->boolean('is_paid', false),
      ]
    );

    $staff->roles()->sync([$request->input('designation')]);

    return redirect()->route('company.hrms.teams.index')
      ->with('success', 'Staff details updated successfully!');
  }


  public function destroy($id)
  {
    $staff = User::findOrFail($id);

    if ($staff->avatar) {
      MediaHelper::removeCompanyFile($staff->avatar->id);
    }

    if ($staff->profile && Storage::disk('public')->exists($staff->profile)) {
      Storage::disk('public')->delete($staff->profile);
    }

    $staff->delete(); // Soft delete

    return back()->with('success', 'Staff deleted successfully!');
  }

  public function loginSecurity($id)
  {
    $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();
    return view('company.teachers.login-security', compact('teacher'));
  }


  public function loginSecurityChange($id, Request $request)
  {
    DB::beginTransaction();
    try {
      $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

      if (!$teacher) {
        return redirect()->back(['error' => 'Teacher not found'], 404);
      }

      $teacher = User::where('id', $id)->where('acc_type', 'teacher')->first();

      if ($request->filled('password')) {
        $teacher->password = $request->password;
      }

      $teacher->email  = $request->email;
      $teacher->mobile = $request->mobile;
      $teacher->save();

      DB::commit();

      return redirect()->route('company.teachers.index')->with('success', 'Teacher login security updated successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with(['error', 'Failed to teacher login security updation' . $e->getMessage()]);
    }
  }
}
