<?php

namespace App\Http\Controllers\MobileApp;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\StoreTeacherRequest;
use App\Http\Requests\Teachers\UpdateTeacherRequest;
use App\Models\DeleteAccountRequest;
use App\Models\Teacher;
use App\Models\TeacherSubjectRate;
use App\Models\Subject;
use App\Models\TeacherCertificate;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


  // List requests
  public function index()
  {
    $requests = DeleteAccountRequest::with('user')->where('company_id', '1')
      ->orderByRaw('CASE WHEN approved_at IS NULL AND rejected_at IS NULL THEN 0 ELSE 1 END ASC')
      ->orderBy('created_at', 'asc')
      ->get();

    return view('company.mobile-app.accounts.delete-accounts', compact('requests'));
  }

  // Approve request
  public function approve($id)
  {
    $request = DeleteAccountRequest::findOrFail($id);

    if (!$request->approved_at && !$request->rejected_at) {
      $request->approved_at = Carbon::now();
      $request->status = 'approved';
      $request->save();

      // Delete user account
      $user = User::find($request->user_id);
      if ($user) {
        $user->delete();
      }
    }

    return redirect()->back()->with('success', 'Request approved and user deleted.');
  }

  // Reject request
  public function reject($id)
  {
    $request = DeleteAccountRequest::findOrFail($id);

    if (!$request->approved_at && !$request->rejected_at) {
      $request->rejected_at = Carbon::now();
      $request->status = 'rejected';
      $request->save();
    }

    return redirect()->back()->with('success', 'Request rejected.');
  }



  public function deleted_accounts()
  {
    // Fetch only soft-deleted users
    $deletedUsers = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
    return view('company.mobile-app.accounts.deleted-accounts', compact('deletedUsers'));
  }

  public function restore($id)
  {
    $user = User::onlyTrashed()->findOrFail($id);
    $user->restore();

    return redirect()->route('company.app.delete_accounts.list')
      ->with('success', 'User restored successfully!');
  }

  public function forceDelete($id)
  {
    DB::beginTransaction();

    try {
      // Fetch only soft deleted user
      $user = User::onlyTrashed()->findOrFail($id);

      // OPTIONAL: delete related data safely (adjust if needed)
      // Example:
      // $user->teacher()->forceDelete();
      // $user->certificates()->delete();
      // $user->subjects()->detach();

      // Remove delete account requests linked to this user
      DeleteAccountRequest::where('user_id', $user->id)->delete();

      // Permanently delete user
      $user->forceDelete();

      DB::commit();

      return redirect()
        ->back()
        ->with('success', 'User permanently deleted from system.');
    } catch (Exception $e) {
      DB::rollBack();

      return redirect()
        ->back()
        ->with('error', 'Something went wrong while deleting user.');
    }
  }
}
