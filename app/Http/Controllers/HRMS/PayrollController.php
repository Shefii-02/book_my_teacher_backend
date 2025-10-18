<?php
namespace App\Http\Controllers\HRMS;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PayrollDetail;
use App\Models\PayrollAdvance;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = PayrollDetail::with('user')->latest()->paginate(10);
        return view('company.team.payroll.index', compact('payrolls'));
    }

    public function create($userId)
    {
        $user = User::findOrFail($userId);
        return view('company.team.payroll.create', compact('user'));
    }

    public function store(Request $request, $userId)
    {
        $validated = $request->validate([
            'salary_type' => 'required|in:monthly,hourly',
            'basic_salary' => 'nullable|numeric',
            'hourly_rate' => 'nullable|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'total_hours' => 'nullable|numeric',
            'payment_mode' => 'nullable|string',
            'joining_date' => 'nullable|date',
        ]);

        PayrollDetail::updateOrCreate(
            ['user_id' => $userId],
            $validated
        );

        return redirect()->route('admin.hrms.staff.index')->with('success', 'Payroll saved successfully.');
    }

    public function addAdvance(Request $request, $userId)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string',
            'date'   => 'nullable|date',
        ]);

        PayrollAdvance::create(array_merge($validated, ['user_id' => $userId]));

        return back()->with('success', 'Advance recorded successfully.');
    }

    public function markPaid($id)
    {
        $payroll = PayrollDetail::findOrFail($id);
        $payroll->update(['is_paid' => true]);

        PayrollAdvance::where('user_id', $payroll->user_id)->update(['is_deducted' => true]);

        return back()->with('success', 'Salary marked as paid and advances cleared.');
    }
}
