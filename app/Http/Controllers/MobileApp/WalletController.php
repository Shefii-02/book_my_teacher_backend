<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

  public function index(Request $request)
  {
    $query = Wallet::with('user');

    // Search by user fields
    if ($request->filled('search')) {
      $search = $request->search;

      $query->whereHas('user', function ($q) use ($search) {
        $q->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('mobile', 'like', "%$search%");
      });
    }

    // Filter by account type
    if ($request->filled('acc_type')) {
      $query->whereHas('user', function ($q) use ($request) {
        $q->where('acc_type', $request->acc_type);
      });
    }

    // Minimum Green coins
    if ($request->filled('min_green')) {
      $query->where('green_balance', '>=', $request->min_green);
    }

    // Minimum Rupees
    if ($request->filled('min_rupee')) {
      $query->where('rupee_balance', '>=', $request->min_rupee);
    }

    $wallets = $query->paginate(20)->appends($request->query());

    return view('company.mobile-app.wallets.index', compact('wallets'));
  }



  public function show($id){

  }


  public function adjustStore(WalletRequest $request)
  {

    $data = $request->validated();

    try {
      DB::beginTransaction();
      $data['wallet_type'] = 'green';
      $data['company_id'] = auth()->user()->company_id;
      $data['type']       = $data['action'];
      $data['date']       = now();
      $data['status']    = 'pending';

      // $wallet = Wallet::firstOrCreate(['user_id' => $request->user_id]);

      // Update balances
      // if ($request->wallet_type == 'green') {
      // $wallet->green_balance = $request->action == 'credit'
      //   ? $wallet->green_balance + $request->amount
      //   : $wallet->green_balance - $request->amount;
      // }
      // else {
      //   $wallet->rupee_balance = $request->action == 'credit'
      //     ? $wallet->rupee_balance + $request->amount
      //     : $wallet->rupee_balance - $request->amount;
      // }

      // $wallet->save();

      // Log history
      WalletHistory::create($data);
      DB::commit();
      return redirect()->route('admin.app.wallets.index')
        ->with('success', 'Wallet updated successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->route('admin.app.wallets.index')
        ->with('error', $e->getMessage());
    }
  }



  // public function adjustUpdate(Request $request, $userId)
  // {
  //   $request->validate([
  //     'wallet_type' => 'required|in:green,rupee',
  //     'amount' => 'required|numeric|min:1',
  //     'action' => 'required|in:add,subtract',
  //     'note' => 'nullable|string|max:255'
  //   ]);

  //   $wallet = Wallet::where('user_id', $userId)->firstOrFail();

  //   $amount = $request->amount;

  //   if ($request->wallet_type === 'green') {
  //     $wallet->green_balance += ($request->action === 'add' ? $amount : -$amount);
  //   } else {
  //     $wallet->rupee_balance += ($request->action === 'add' ? $amount : -$amount);
  //   }

  //   $wallet->save();

  //   // insert transaction history
  //   \App\Models\WalletHistory::create([
  //     'user_id' => $userId,
  //     'wallet_type' => $request->wallet_type,
  //     'title' => 'Admin ' . ($request->action === 'add' ? 'Added' : 'Removed'),
  //     'type' => $request->action === 'add' ? 'credit' : 'debit',
  //     'amount' => $amount,
  //     'status' => 'Completed',
  //     'date' => now(),
  //     'note' => $request->note
  //   ]);

  //   return redirect()->route('admin.wallets.index')
  //     ->with('success', 'Wallet updated successfully.');
  // }




  public function transationsIndex(Request $request)
  {
    $q = WalletHistory::with('user')->orderBy('date', 'desc');

    if ($request->wallet_type)
      $q->where('wallet_type', $request->wallet_type);

    if ($request->status)
      $q->where('status', $request->status);

    if ($request->search)
      $q->whereHas('user', function ($x) use ($request) {
        $s = $request->search;
        $x->where('name', 'like', "%$s%")
          ->orWhere('email', 'like', "%$s%")
          ->orWhere('mobile', 'like', "%$s%");
      });

    $histories = $q->paginate(20);

    return view('company.mobile-app.wallets.history', compact('histories'));
  }

  public function transationApprove(WalletHistory $history)
  {
    if ($history->status !== 'pending') {
      return back()->with('error', 'Only pending transactions can be approved.');
    }

    // update user wallet
    $user = $history->user;

    $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

    // if ($history->wallet_type === 'green') {
    $wallet->green_balance += ($history->type == 'credit' ? $history->amount : -$history->amount);
    // } else {
    //   $user->rupee_balance += ($history->type == 'credit' ? $history->amount : -$history->amount);
    // }

    $wallet->save();

    $history->update(['status' => 'approved']);

    return back()->with('success', 'Transaction approved & wallet updated.');
  }

  public function TransationRollback(WalletHistory $history)
  {
    if ($history->status !== 'approved') {
      return back()->with('error', 'Only approved transactions can be rolled back.');
    }
    $user = $history->user;
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
    // reverse effect
    // if ($history->wallet_type === 'green') {
    $wallet->green_balance -= ($history->type == 'credit' ? $history->amount : -$history->amount);
    // } else {
    //     $user->rupee_balance -= ($history->type == 'credit' ? $history->amount : -$history->amount);
    // }

    $wallet->save();

    $history->update(['status' => 'rejected']);

    return back()->with('success', 'Transaction rolled back successfully.');
  }




  // ------------------------------
  // GET WALLET DETAILS
  // ------------------------------
  public function myWallet(): JsonResponse
  {
    $wallet = Wallet::firstOrCreate(
      ['user_id' => auth()->id()],
      ['green_balance' => 0, 'rupee_balance' => 0]
    );

    $history = WalletHistory::where('user_id', auth()->id())
      ->orderByDesc('id')
      ->get()
      ->groupBy('wallet_type');

    return response()->json([
      'green' => [
        'balance' => $wallet->green_balance,
        'target' => 1000,
        'history' => $history['green'] ?? [],
      ],
      'rupee' => [
        'balance' => $wallet->rupee_balance,
        'target' => 5000,
        'history' => $history['rupee'] ?? [],
      ]
    ]);
  }

  // ------------------------------
  // ADD GREEN COINS
  // ------------------------------
  public function addGreen(Request $request): JsonResponse
  {
    $request->validate([
      'amount' => 'required|integer|min:1',
      'title'  => 'required|string'
    ]);

    $wallet = Wallet::firstOrCreate(
      ['user_id' => auth()->id()],
      ['green_balance' => 0, 'rupee_balance' => 0]
    );

    // Increase
    $wallet->green_balance += $request->amount;
    $wallet->save();

    // Log history
    WalletHistory::create([
      'user_id' => auth()->id(),
      'wallet_type' => 'green',
      'title' => $request->title,
      'type' => 'credit',
      'amount' => $request->amount,
      'status' => 'Approved',
      'date' => Carbon::now()->toDateString()
    ]);

    return response()->json(['message' => 'Green coins added']);
  }

  // ------------------------------
  // CONVERT GREEN TO RUPEES
  // ------------------------------
  public function convertGreenToRupee(Request $request): JsonResponse
  {
    $request->validate([
      'amount' => 'required|integer|min:1'
    ]);

    $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();

    if ($wallet->green_balance < $request->amount) {
      return response()->json(['message' => 'Not enough green balance'], 400);
    }

    // Deduct green
    $wallet->green_balance -= $request->amount;

    // 1 Green = 1 Rupee (modify if needed)
    $wallet->rupee_balance += $request->amount;

    $wallet->save();

    // Green history
    WalletHistory::create([
      'user_id' => auth()->id(),
      'wallet_type' => 'green',
      'title' => 'Converted to Rupees',
      'type' => 'debit',
      'amount' => $request->amount,
      'status' => 'Converted',
      'date' => Carbon::now()->toDateString()
    ]);

    // Rupee history
    WalletHistory::create([
      'user_id' => auth()->id(),
      'wallet_type' => 'rupee',
      'title' => 'Converted from Green Coins',
      'type' => 'credit',
      'amount' => $request->amount,
      'status' => 'Completed',
      'date' => Carbon::now()->toDateString()
    ]);

    return response()->json(['message' => 'Converted successfully']);
  }

  // ------------------------------
  // WITHDRAW RUPEES
  // ------------------------------
  public function withdrawRupee(Request $request): JsonResponse
  {
    $request->validate([
      'amount' => 'required|integer|min:1'
    ]);

    $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();

    if ($wallet->rupee_balance < $request->amount) {
      return response()->json(['message' => 'Insufficient rupee balance'], 400);
    }

    // Deduct
    $wallet->rupee_balance -= $request->amount;
    $wallet->save();

    // History
    WalletHistory::create([
      'user_id' => auth()->id(),
      'wallet_type' => 'rupee',
      'title' => 'Transferred to Bank',
      'type' => 'debit',
      'amount' => $request->amount,
      'status' => 'Pending',
      'date' => Carbon::now()->toDateString()
    ]);

    return response()->json(['message' => 'Withdrawal requested']);
  }
}
