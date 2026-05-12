<?php

namespace App\Http\Controllers\LMS;

use App\Models\TeacherPaymentTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class TeacherPaymentTransferController extends Controller
{
  /**
   * Display list.
   */
  public function index()
  {
    $transfers = TeacherPaymentTransfer::latest()->paginate(20);

    return view('teacher_payment_transfers.index', compact('transfers'));
  }

  /**
   * Show create form.
   */
  public function create()
  {
    return view('teacher_payment_transfers.create');
  }

  /**
   * Store.
   */
  public function store(Request $request)
  {
    $request->validate([

      'teacher_id' => 'required|exists:users,id',

      'amount' => 'required|numeric|min:1',

      'transfer_method' => 'required',

      'status' => 'required',
    ]);

    /*
    |--------------------------------------------------------------------------
    | TOTAL EARNINGS
    |--------------------------------------------------------------------------
    */

    $totalEarnings = TeacherEarning::where('teacher_id', $request->teacher_id)
      ->where('status', 'completed')
      ->sum('amount');

    /*
    |--------------------------------------------------------------------------
    | TOTAL TRANSFERRED
    |--------------------------------------------------------------------------
    */

    $totalTransferred = TeacherPaymentTransfer::where('teacher_id', $request->teacher_id)
      ->whereIn('status', ['processing', 'completed'])
      ->sum('amount');

    /*
    |--------------------------------------------------------------------------
    | AVAILABLE BALANCE
    |--------------------------------------------------------------------------
    */

    $availableBalance = $totalEarnings - $totalTransferred;

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($request->amount > $availableBalance) {

      return back()->withErrors([
        'amount' => 'Insufficient balance. Available balance is ₹' . number_format($availableBalance, 2)
      ])->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | CHARGE CALCULATION
    |--------------------------------------------------------------------------
    */

    $chargeAmount = 0;

    $finalAmount = $request->amount - $chargeAmount;

    /*
    |--------------------------------------------------------------------------
    | CREATE TRANSFER
    |--------------------------------------------------------------------------
    */

    TeacherPaymentTransfer::create([

      'teacher_id' => $request->teacher_id,

      'transfer_no' => 'TRF-' . rand(100000, 999999),

      'amount' => $request->amount,

      'charge_amount' => $chargeAmount,

      'final_amount' => $finalAmount,

      'transfer_method' => $request->transfer_method,

      'bank_name' => $request->bank_name,

      'account_holder_name' => $request->account_holder_name,

      'account_number' => $request->account_number,

      'ifsc_code' => $request->ifsc_code,

      'upi_id' => $request->upi_id,

      'status' => $request->status,

      'remarks' => $request->remarks,

      'requested_at' => now(),
    ]);

    return redirect()
      ->back()
      ->with('success', 'Transfer request created successfully');
  }
  /**
   * Show single.
   */
  public function show(TeacherPaymentTransfer $teacherPaymentTransfer)
  {
    return view(
      'teacher_payment_transfers.show',
      compact('teacherPaymentTransfer')
    );
  }

  /**
   * Edit form.
   */
  public function edit(TeacherPaymentTransfer $teacherPaymentTransfer)
  {
    return view(
      'teacher_payment_transfers.edit',
      compact('teacherPaymentTransfer')
    );
  }

  /**
   * Update.
   */
  public function update(
    Request $request,
    TeacherPaymentTransfer $teacherPaymentTransfer
  ) {
    $request->validate([
      'teacher_id' => 'required|exists:users,id',
      'amount' => 'required|numeric|min:0',
      'charge_amount' => 'nullable|numeric|min:0',
      'final_amount' => 'required|numeric|min:0',
      'transfer_method' => 'nullable',
      'bank_name' => 'nullable|string',
      'account_holder_name' => 'nullable|string',
      'account_number' => 'nullable|string',
      'ifsc_code' => 'nullable|string',
      'upi_id' => 'nullable|string',
      'status' => 'required',
      'approved_by' => 'nullable|exists:users,id',
      'reference_no' => 'nullable|string',
      'remarks' => 'nullable|string',
      'requested_at' => 'nullable|date',
      'processed_at' => 'nullable|date',
    ]);

    $teacherPaymentTransfer->update($request->all());

    return redirect()
      ->route('teacher-payment-transfers.index')
      ->with('success', 'Transfer updated successfully');
  }

  /**
   * Delete.
   */
  public function destroy(TeacherPaymentTransfer $teacherPaymentTransfer)
  {
    $teacherPaymentTransfer->delete();

    return redirect()
      ->route('teacher-payment-transfers.index')
      ->with('success', 'Transfer deleted successfully');
  }
}
