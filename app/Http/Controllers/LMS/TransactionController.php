<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\BannerRequest;
use App\Models\LivestreamClass;
use App\Models\Purchase;
use App\Models\TeacherClassRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
  public function index(Request $request)
  {
    $query = Purchase::with([
      'student:id,name,email,mobile',
      'course:id,title',
      'payments'
    ]);

    /* ========= STATUS FILTER ========= */

    if ($request->filled('type') && $request->type !== 'all') {
      $query->where('status', $request->type);
    }

    /* ========= SEARCH FILTER ========= */

    if ($request->filled('search')) {

      $search = $request->search;

      $query->whereHas('student', function ($q) use ($search) {

        $q->where('name', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%")
          ->orWhere('mobile', 'like', "%$search%");
      });
    }

    /* ========= DATE FILTER ========= */

    if ($request->filled('start_date')) {
      $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
      $query->whereDate('created_at', '<=', $request->end_date);
    }

    /* ========= PAGINATION ========= */

    $transactions = $query
      ->latest()
      ->paginate(15)
      ->withQueryString();

    /* ========= DASHBOARD STATS ========= */

    $stats = [
      'total'    => $this->statsByStatus(),
      'paid'     => $this->statsByStatus('paid'),
      'pending'  => $this->statsByStatus('pending'),
      'rejected' => $this->statsByStatus('rejected'),
    ];

    return view('company.academic.admissions.transactions', compact(
      'transactions',
      'stats'
    ));
  }

  private function statsByStatus($status = null)
  {
    $q = Purchase::query();
    if ($status) $q->where('status', $status);

    return [
      'count'   => $q->count(),
      'online'  => (clone $q)->where('payment_method', 'online')->count(),
      'manual'  => (clone $q)->whereIn('payment_method', ['bank', 'manual'])->count(),
      'cash'    => (clone $q)->where('payment_method', 'cash')->count(),
    ];
  }
}
