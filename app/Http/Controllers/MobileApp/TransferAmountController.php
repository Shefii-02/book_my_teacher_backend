<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferAmountRequest;
use App\Models\TransferAmount;
use App\Models\TransferRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferAmountController extends Controller
{
  public function index(Request $request)
  {
    $company_id = auth()->user()->company_id;

    $status = $request->status ?? 'pending';
    $search = $request->search;

    $tRequests = TransferRequest::with('user')
      ->where('company_id', $company_id)
      ->where('status', $status)

      ->when($search, function ($q) use ($search) {
        $q->whereHas('user', function ($userQuery) use ($search) {
          $userQuery->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('mobile', 'like', "%{$search}%");
        });
      })

      ->latest()
      ->paginate(20)
      ->withQueryString();

    return view('company.mobile-app.transfer.index', compact('tRequests', 'status', 'search'));
  }



  public function edit($id)
  {
    $company_id = auth()->user()->company_id;
    $item = TransferRequest::where('company_id', $company_id)->where('id', $id)->where('status', 'pending')->first();
    return view('company.mobile-app.transfer.form', compact('item'));
  }


  public function store()
  {
    //	company_id	user_id	request_id	requested_at	request_amount	approved_by	approved_at	approved_amount	transfer_account	status	created_at	updated_at
  }

  public function ApproveStore(TransferAmountRequest $request, $id)
  {


    $company_id = auth()->user()->company_id;

    $transRequests = TransferRequest::where('id', $id)->where('company_id', $company_id)->first();
    try {
      DB::beginTransaction();
      TransferAmount::create([
        'company_id'  => auth()->user()->company_id,
        'user_id'     => $transRequests->user_id,
        'transfer_amount' => $transRequests->request_amount,
        'transaction_source' => $request->transaction_source,
        'transaction_method' => $request->transaction_method,
        'transfer_to_account_no' => $request->transfer_to_account_no ?? '',
        'transfer_to_ifsc_no' => $request->transfer_to_ifsc_no ?? '',
        'transfer_holder_name' => $request->transfer_holder_name ?? '',
        'transfer_upi_id' => $request->transfer_upi_id ?? '',
        'transfer_upi_number' => $request->transfer_upi_number ?? '',
        'transferred_by' => auth()->id(),
        'approved_at' => now(),
        'status'      => 'approved',
        'approved_at' => now(),
        'approved_by' => auth()->id(),
      ]);

      $transRequests->status = 'approved';
      $transRequests->save();
      DB::commit();

      return back()->with('success', 'Transfer request created successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return back()->with('failed', $e->getMessage());
    }
  }


  public function approve($id)
  {


    return back()->with('success', 'Transfer approved.');
  }

  public function destroy($id)
  {
    $company_id = auth()->user()->company_id;

    $transRequests = TransferRequest::where('id', $id)->where('company_id', $company_id)->first();
    $transRequests->status = 'rejected';
    $transRequests->save();

    return back()->with('success', 'Transfer deleted.');
  }
}
