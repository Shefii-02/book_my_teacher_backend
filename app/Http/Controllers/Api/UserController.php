<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyContactResource;
use App\Http\Resources\ReferralFriendResource;
use App\Http\Resources\SocialLinkResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use App\Models\AppReferral;
use App\Models\AppReview;
use App\Models\CompanyContact;
use App\Models\CompanyTeacher;
use App\Models\CourseEnrollment;
use App\Models\DeleteAccountRequest;
use App\Models\DemoClass;
use App\Models\DemoClassRegistration;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TeacherClass;
use App\Models\TransferRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\Webinar;
use App\Models\WebinarRegistration;
use App\Models\WorkshopClass;
use App\Models\WorkshopRegistration;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $mobileNo   = '91' . $request->mobile;
    $company_id = 1;

    $user = User::where('mobile', $mobileNo)
      ->where('company_id', $company_id)
      ->first();

    if ($user) {
      return response()->json([
        'success' => true,
        'message' => 'User details found successfully',
        'data'    => $user,
      ], 200);
    }

    return response()->json([
      'success' => false,
      'message' => 'User details not found',
      'data'    => null,
    ], 404);
  }

  public function overviewTeacher($id)
  {
    $teacher = User::with([
      'professionalInfo',
      'workingDays',
      'workingHours',
      'teacherGrades',
      'subjects',
      'mediaFiles'
    ])->where('id', $id)->where('acc_type', 'teacher')->first();

    if (!$teacher) {
      return response()->json(['message' => 'Teacher not found'], 404);
    }

    return response()->json($teacher, 200);
  }


  // Fetch user data by token
  public function getUserDetails(Request $request)
  {



    $user = $request->user();



    if (!$user) {
      return response()->json([
        'status' => 'error',
        'message' => 'User not found'
      ], 404);
    }

    return response()->json([
      'status' => 'success',
      'data' => $user,
    ], 200);
  }

  // Set or update user token
  public function setUserToken(Request $request)
  {
    $userId = $request->input('user_id');
    $company_id = 1;

    if (!$userId) {
      return response()->json([
        'status' => 'error',
        'message' => 'User ID is required'
      ], 400);
    }

    $user = User::find($userId);

    if (!$user) {
      return response()->json([
        'status' => 'error',
        'message' => 'User not found'
      ], 404);
    }

    $token = $user->createToken('MyAppToken')->plainTextToken;

    return response()->json([
      'status' => 'success',
      'data'   => $user,
      'token' => $token,
    ], 200);
  }

  public function checkServer(): JsonResponse
  {
    try {
      // Example: You could load status from .env or database
      $status = config('app.status', 'production');
      // Or from env: env('APP_STATUS', 'production')

      // You can also add server health check logic here
      // Example: check DB connection
      try {
        DB::connection()->getPdo();
        $db_status = "ok";
      } catch (\Exception $e) {
        $db_status = "failed";
      }

      return response()->json([
        'status' => $status, // "production" or "development"
        'db_status' => $db_status,
        'message' => $status === 'development'
          ? 'App under maintenance'
          : 'Server running fine',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => 'Server check failed',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  public function userLogout(Request $request)
  {
    $user = $request->user();

    return response()->json([
      'success' => true,
      'message' => 'Logout successfully'
    ], 200);
  }
  public function deleteAccountRequest(Request $request)
  {
    $user = $request->user();

    // Check existing pending request
    $existing = DeleteAccountRequest::where('user_id', $user->id)
      ->where('status', 'pending')
      ->first();

    if ($existing) {
      return response()->json([
        'status' => false,
        'message' => 'A delete account request is already pending.'
      ], 400);
    }

    $deleteReq = DeleteAccountRequest::create([
      'company_id' => 1,
      'user_id' => $user->id,
      'reason' => $request->reason,
      'description' => $request->description,
    ]);

    return response()->json([
      'status' => true,
      'message' => 'Delete account request submitted successfully.',
      'data' => $deleteReq
    ]);
  }

  public function  userDataRetrieve(Request $request)
  {
    try {
      $user = $request->user();

      $accountStatusResponse = accountStatus($user);
      $accountMsg = $accountStatusResponse['accountMsg'];
      $steps = $accountStatusResponse['steps'];


      return response()->json([
        'success' => true,
        'message' => 'User data fetched successfully',
        'user'              => new UserResource($user, $accountMsg, $steps),
      ], 200);
    } catch (Exception $e) {
      Log::error('User data getting  failed: ' . $e->getMessage());
      return response()->json([
        'status' => false,
        'message' => $e->getMessage(),
      ]);
    }
  }



  public function myWallet2(Request $request): JsonResponse
  {
    // $user = $request->user();
    $wallet =  Wallet::where('user_id', 1)->first();
    $wallet_histories = WalletHistory::where('user_id', 1)->get();
    return response()->json(new WalletResource($wallet, $wallet_histories));
  }

  public function myWallet(Request $request): JsonResponse
  {
    $user = $request->user();
    $wallet =  Wallet::where('user_id', $user->id)->first();
    $wallet_histories = WalletHistory::where('user_id', $user->id)->get();
    return response()->json(new WalletResource($wallet, $wallet_histories));



    // return response()->json([
    //   'green' => [
    //     'balance' => 780,
    //     'target' => 1000,
    //     'history' => [
    //       ['title' => 'Completed Demo Class', 'type' => 'credit', 'amount' => 50, 'date' => '2025-11-01', 'status' => 'Approved'],
    //       ['title' => 'Redeemed to Rupees', 'type' => 'debit', 'amount' => 100, 'date' => '2025-10-20', 'status' => 'Processed'],
    //     ],
    //   ],
    //   'rupee' => [
    //     'balance' => 4400,
    //     'target' => 5000,
    //     'history' => [
    //       ['title' => 'Converted from Coins', 'type' => 'credit', 'amount' => 100, 'date' => '2025-10-20', 'status' => 'Completed'],
    //       ['title' => 'Transferred to Bank', 'type' => 'debit', 'amount' => 5000, 'date' => '2025-09-25', 'status' => 'Pending'],
    //     ],
    //   ],
    // ]);
  }

  public function convertToRupees(Request $request)
  {
    DB::beginTransaction();
    $user = $request->user();
    $wallet = Wallet::where('user_id', $user->id)->first();
    $greenCoinValue = 0.01;
    try {
      if ($wallet->green_balance > 4000) {
        $history                = new WalletHistory();
        $history->user_id       = $user->id;
        $history->wallet_type   = 'green';
        $history->title         = "Converted to Rupees";
        $history->type          = "debit";
        $history->amount        = $request->amount;
        $history->status        = "Processed";
        $history->date          = now();
        $history->notes         = "Converted green coins to rupees";
        $history->save();

        $wallet->green_balance = $wallet->green_balance - $request->amount;
        $wallet->rupee_balance = $wallet->rupee_balance + ($greenCoinValue * $request->amount);
        $wallet->save();

        $history                = new WalletHistory();
        $history->user_id       = $user->id;
        $history->wallet_type   = 'rupee';
        $history->title         = "Converted to Rupees";
        $history->type          = "credit";
        $history->amount        = $greenCoinValue * $request->amount;
        $history->status        = "Processed";
        $history->date          = now();
        $history->notes         = "Converted green coins to rupees";
        $history->save();

        DB::commit();

        return response()->json([
          'success' => true,
          'message' => 'Conversion request submitted successfully!',
          'request_id' => date('Ymd', strtotime($history->date)),
          'status' => 'Processed',
        ]);
      } else {
        DB::rollBack();
        return response()->json([
          'success' => false,
          'message' => 'Conversion request submitted failed!',
          'request_id' => date('Ymd', strtotime(now())),
          'status' => 'Processed',
        ]);
      }
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        'success' => false,
        'message' => 'Conversion request submitted failed!',
        'request_id' => date('Ymd', strtotime(now())),
        'status' => 'Processed',
      ]);
    }
  }

  public function transferToBank(Request $request)
  {
    $user = $request->user();
    $transReq = new TransferRequest();
    $transReq->company_id = 1;
    $transReq->user_id = $user->id;
    $transReq->request_id = date('ymdhisa');
    $transReq->requested_at = now();
    $transReq->request_amount = null;
    $transReq->approved_by = null;
    $transReq->approved_at = null;
    $transReq->approved_amount = null;
    $transReq->transfer_account = null;
    $transReq->status = 'pending';
    $transReq->save();


    return response()->json([
      'success' => true,
      'message' => 'Transfer request submitted successfully!',
      'transaction_id' => rand(10000, 99999),
      'status' => 'pending',
    ]);
  }


  public function socialLinks(Request $request)
  {
    $socials = SocialLink::where('company_id', 1)->get();
    $contact = CompanyContact::where('company_id', 1)->first();

    // $socials = [
    //   [
    //     'name' => 'Facebook',
    //     'icon' => asset('assets/mobile-app/icons/facebook.png'),
    //     'link' => 'https://facebook.com/BookMyTeacher',
    //     'type' => 'facebook',
    //   ],
    //   [
    //     'name' => 'Instagram',
    //     'icon' => asset('assets/mobile-app/icons/instagram.png'),
    //     'link' => 'https://instagram.com/BookMyTeacher',
    //     'type' => 'instagram',
    //   ],
    //   [
    //     'name' => 'YouTube',
    //     'icon' => asset('assets/mobile-app/icons/youtube.png'),
    //     'link' => 'https://youtube.com/@BookMyTeacher',
    //     'type' => 'youtube',
    //   ],
    //   [
    //     'name' => 'LinkedIn',
    //     'icon' => asset('assets/mobile-app/icons/linkedin.png'),
    //     'link' => 'https://linkedin.com/company/BookMyTeacher',
    //     'type' => 'linkedIn',
    //   ],
    // ];

    // $contact = [
    //   "email" => "support@bookmyteacher.com",
    //   "phone" => "+91 98765 43210",
    //   "whatsapp" => "917510114455",
    //   "website" => "https://bookmyteacher.co.in",
    //   "address" => "Trivandrum, Kerala, India"
    // ];

    return response()->json([
      'status' => true,
      'socials' =>  SocialLinkResource::collection($socials),
      'contact' => new CompanyContactResource($contact),
    ]);
  }
  public function communityLinks(Request $request)
  {
    $socials = SocialLink::where('company_id', 1)->get();
    return response()->json([
      'status' => true,
      'data' =>  SocialLinkResource::collection($socials),
    ]);
  }

  public function bottomSocialLinks(Request $request)
  {
    $socials = SocialLink::where('company_id', 1)->get();
    return response()->json([
      'status' => true,
      'data' =>  SocialLinkResource::collection($socials),
    ]);
  }




  public function Referral(): JsonResponse
  {
    return response()->json([
      'referral_link' => 'https://bookmyteacher.com/ref/ABC123',
      'qr_code_url' => 'https://cdn.app/qr/ABC123.png',
      'bonus_threshold' => 5,
      'expiry_date' => now()->addMonths(2)->toDateString(),
      'my_referral_list' => [
        ['name' => 'Ankit', 'joined_at' => '2025-09-12'],
        ['name' => 'Riya', 'joined_at' => '2025-09-18']
      ],
      'referral_terms_points' => [
        ['category' => 'signup', 'points' => 10],
        ['category' => 'review', 'points' => 5]
      ],
      'reward_per_referral' => 20
    ]);
  }


  public function referralStats(Request $request): JsonResponse
  {
    $user = $request->user();
    $walletHistory =  WalletHistory::where('user_id', $user->id)->get();
    $reward_per_join = 100;
    $bonus_on_first_class = 250;
    $earned_coins = $walletHistory->where('wallet_type', 'green')->where('type', 'credit')->sum('amount');
    $joinedUsers = AppReferral::with('appliedUser')->where('ref_user_id', $user->id)->get();
    $friends_joined = $joinedUsers->where('status', 'active')->count();

    $user = $request->user();

    // Calculate Earned Coins
    $earned_coins = $walletHistory
      ->where('wallet_type', 'green')
      ->where('type', 'credit')
      ->sum('amount');

    // All Joined Users via referral
    $joinedUsers = AppReferral::with('appliedUser')
      ->where('ref_user_id', $user->id)
      ->get();

    // Only Completed/Active Joins
    $friends_joined = $joinedUsers->where('status', 'active')->count();

    return response()->json([
      'referral_code' => $user->referral_code,
      'earned_coins' => $earned_coins,
      'friends_joined' => $friends_joined,
      'reward_per_join' => $reward_per_join,
      'bonus_on_first_class' => $bonus_on_first_class,

      'how_it_works' => 'How it works',
      'how_it_works_description' =>
      'For each friend who joins using your link/code, you earn Green Coins. Coins can be converted to rewards or wallet credits.',

      'badge_title' => '💰 Earn Green Coins',
      'badge_description' =>
      "• $reward_per_join coins when your friend joins\n" .
        "• $bonus_on_first_class extra coins when they join first class\n" .
        "• Track your invites in Rewards → Invited List",

      'share_link_description' =>
      "Join me on BookMyTeacher! Use my referral code {$user->referral_code} to sign up and earn rewards. " .
        "https://bookmyteacher.cloud/invite?ref={$user->referral_code}",

      // RESOURCE BASED FRIEND LIST
      'friends_list' => ReferralFriendResource::collection($joinedUsers),
    ]);


    // return response()->json([
    //   'referral_code' => $user->referral_code,
    //   'earned_coins' => $earned_coins,
    //   'friends_joined' => $friends_joined,
    //   'reward_per_join' => $reward_per_join,
    //   'bonus_on_first_class' => $bonus_on_first_class,
    //   'how_it_works' => 'How it works',
    //   'how_it_works_description' => 'For each friend who joins using your link/code, you earn Green Coins. Coins can be converted to rewards or wallet credits.',
    //   'badge_title' => '💰 Earn Green Coins',
    //   'badge_description' => "• $reward_per_join coins when your friend joins\n• $bonus_on_first_class extra coins when they join first class\n• Track your invites in Rewards → Invited List",
    //   'share_link_description' => 'Join me on BookMyTeacher! Use my referral code BMT-9834 to sign up and earn rewards.https://bookmyteacher.cloud/invite?ref=BMT-9834',
    //   'friends_list' => [
    //     //resource connect(joinedUsers)
    //     [
    //       'name' => 'Rahul Mehta',
    //       'joined_at' => '2025-10-30',
    //       'earned_coins' => 150,
    //       'status' => 'completed',
    //     ],
    //     [
    //       'name' => 'Anjali Singh',
    //       'joined_at' => '2025-10-27',
    //       'earned_coins' => 100,
    //       'status' => 'joined',
    //     ],
    //     [
    //       'name' => 'Vikas Kumar',
    //       'joined_at' => '2025-10-25',
    //       'earned_coins' => 0,
    //       'status' => 'pending',
    //     ],
    //     [
    //       'name' => 'Priya Sharma',
    //       'joined_at' => '2025-10-21',
    //       'earned_coins' => 50,
    //       'status' => 'joined',
    //     ],
    //     [
    //       'name' => 'Vikas Kumar',
    //       'joined_at' => '2025-10-25',
    //       'earned_coins' => 0,
    //       'status' => 'pending',
    //     ],
    //   ],
    // ]);
  }


  public function fetchingReviews(Request $request)
  {
    $reviews = [
      [
        "name" => "Aisha Patel",
        "review" => "Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.Great teacher! Explained concepts very clearly.",
        "image" => "https://i.pravatar.cc/150?img=5",
        "rating" => 4.5,
      ],
      [
        "name" => "Rahul Sharma",
        "review" => "Helpful and patient during sessions.",
        "image" => "https://i.pravatar.cc/150?img=12",
        "rating" => 5.0,
      ],
      [
        "name" => "Sneha R.",
        "review" => "Good teaching but classes sometimes run late.",
        "image" => "https://i.pravatar.cc/150?img=8",
        "rating" => 3.5,
      ],
      [
        "name" => "Kevin Thomas",
        "review" => "Very friendly and made learning fun!",
        "image" => "https://i.pravatar.cc/150?img=14",
        "rating" => 4.0,
      ],
      // Add the rest...
    ];

    return response()->json([
      "status" => true,
      "reviews" => $reviews
    ]);
  }


  // public function todayClasses(Request $request)
  // {
  //   return response()->json([
  //     "status" => true,
  //     "message" => "Today's classes fetched successfully",
  //     "data" => [
  //       // [
  //       //   "id" => 1,
  //       //   "title" => 'Test 1',
  //       //   "type" => 'Course',
  //       //   "start_time" => "2026-03-04 10:00:00",
  //       //   "end_time" => "2026-03-04 11:00:00",
  //       //   "platform" => "gmeet",
  //       //   "time" => "10:00 AM",
  //       //   "subject" => "Mathematics",
  //       //   "course" => "Grade 8",
  //       //   "teacher_name" => "Rahul Sir",
  //       //   "meeting_link" => "https://meet.google.com/tqt-hfno-hcm",
  //       //   "recorded_link" => null,
  //       //   "status" => "live"
  //       // ],
  //       // [
  //       //   "id" => 2,
  //       //   "time" => "11:30 AM",
  //       //   "title" => 'Test 1',
  //       //   "type" => 'Course',
  //       //   "start_time" => "2026-03-04 10:00:00",
  //       //   "end_time" => "2026-03-04 11:00:00",
  //       //   "platform" => "gmeet",
  //       //   "subject" => "Physics",
  //       //   "course" => "Grade 9",
  //       //   "teacher_name" => "Anjali Ma'am",
  //       //   "meeting_link" => "https://meet.google.com/tqt-hfno-hcm",
  //       //   "recorded_link" => null,
  //       //   "status" => "upcoming"
  //       // ],
  //       // [
  //       //   "id" => 3,
  //       //   "title" => 'Test 1',
  //       //   "type" => 'Course',
  //       //   "time" => "02:00 PM",
  //       //   "start_time" => "2026-03-04 10:00:00",
  //       //   "end_time" => "2026-03-04 11:00:00",
  //       //   "platform" => "gmeet",
  //       //   "subject" => "English",
  //       //   "course" => "Grade 6",
  //       //   "teacher_name" => "Joseph Sir",
  //       //   "meeting_link" => null,
  //       //   "recorded_link" => "https://www.youtube.com/watch?v=Vn3J4ophS8M",
  //       //   "status" => "completed"
  //       // ],
  //     ]
  //   ]);
  // }

  // public function todayClasses(Request $request)
  // {
  //   $user = $request->user();
  //   $today = now()->toDateString();

  //   // if ($user->acc_type == 'student') {

  //     // ✅ Courses (enrolled)
  //     $courses = CourseEnrollment::where('user_id', $user->id)
  //       ->where('status', 1)
  //       ->with(['course.courseClasses'])
  //       ->get()
  //       ->flatMap(function ($enrollment) {
  //         return $enrollment->course->courseClasses->map(function ($courseClass) {
  //           return $this->formatEvent($courseClass, 'Course');
  //         });
  //       })
  //       ->values();
  //     // ✅ Demos (registered)
  //     $demos = DemoClassRegistration::where('user_id', $user->id)->where('checked_in', 1)
  //       ->with(['demoClass'])
  //       ->get()
  //       ->map(function ($reg) {
  //         if (!$reg->demoClass) return null;
  //         return $this->formatEvent($reg->demoClass, 'Demo');
  //       })

  //       ->filter()
  //       ->values();

  //     // ✅ Workshops (checked_in = 1)
  //     $workshops = WorkshopRegistration::where('user_id', $user->id)->where('checked_in', 1)
  //       ->where('checked_in', 1)
  //       ->with(['workshop.classes'])
  //       ->get()
  //       ->flatMap(function ($reg) {
  //         return $reg->workshop->classes->map(function ($workshopClass) {
  //           return $this->formatEvent($workshopClass, 'Workshop');
  //         });
  //       })
  //       ->values();

  //     // ✅ Webinars (checked_in = 1)
  //     $webinars = WebinarRegistration::where('user_id', $user->id)->where('checked_in', 1)
  //       ->where('checked_in', 1)
  //       ->with(['webinar'])
  //       ->get()
  //       ->map(function ($reg) {
  //         if (!$reg->webinar) return null;
  //         return $this->formatEvent($reg->webinar, 'Webinar');
  //       })
  //       ->filter()
  //       ->values();
  //   // } else
  //   if ($user->acc_type == 'teacher') {
  //     $courses = TeacherClass::where('teacher_id', $user->id)
  //       ->with(['course_classes', 'course'])
  //       ->get()
  //       ->map(function ($teacherClass) {
  //         if (!$teacherClass->course_classes) return null;
  //         return $this->formatEvent($teacherClass->course_classes, 'Course'); // ✅ Capitalized
  //       })
  //       ->filter()
  //       ->values();

  //     $webinars = Webinar::where('host_id', $user->id)
  //       ->get()
  //       ->map(fn($w) => $this->formatEvent($w, 'Webinar')); // ✅ Capitalized

  //     $demos = DemoClass::where('host_id', $user->id)
  //       ->get()
  //       ->map(fn($w) => $this->formatEvent($w, 'Demo')); // ✅ Capitalized

  //     $workshops = WorkshopClass::whereHas('workshop', function ($q) use ($user) {
  //       $q->where('host_id', $user->id);
  //     })->get()
  //       ->map(fn($w) => $this->formatEvent($w, 'Workshop')); // ✅ Capitalized



  //   }
  //   // else {
  //   //   return response()->json([
  //   //     "status"  => true,
  //   //     "message" => "Today's classes fetched successfully",
  //   //     "data"    => [],
  //   //   ]);
  //   // }

  //   $todayClasses = collect()
  //     ->merge($demos)
  //     ->merge($webinars)
  //     ->merge($workshops)
  //     ->merge($courses)
  //     ->filter(fn($event) => isset($event['date']) && $event['date'] === $today)
  //     ->sortBy(fn($event) => Carbon::parse($event['_start_datetime']))
  //     ->map(function ($event) {
  //       unset($event['_start_datetime']); // ✅ remove helper keys
  //       unset($event['date']);
  //       return $event;
  //     })
  //     ->values();

  //   return response()->json([
  //     "status"  => true,
  //     "message" => "Today's classes fetched successfully",
  //     "data"    => $todayClasses,
  //   ]);
  // }

  public function todayClasses(Request $request)
  {
    $user  = $request->user();
    $today = now()->toDateString();

    // ✅ Always initialize
    $courses   = collect();
    $demos     = collect();
    $workshops = collect();
    $webinars  = collect();

    // ===========================
    // 🎓 STUDENT
    // ===========================
    if ($user->acc_type == 'student') {

      // ✅ Courses
      $courses = CourseEnrollment::where('user_id', $user->id)
        ->where('status', 1)
        ->with(['course.courseClasses'])
        ->get()
        ->flatMap(function ($enrollment) use ($today) {
          return $enrollment->course->courseClasses
            ->filter(function ($cls) use ($today) {
              return $cls->start_time <= now()->endOfDay() &&
                $cls->end_time   >= now()->startOfDay();
            })
            ->map(fn($cls) => $this->formatEvent($cls, 'Course'));
        });

      // ✅ Demos
      $demos = DemoClassRegistration::where('user_id', $user->id)
        ->where('checked_in', 1)
        ->with(['demoClass'])
        ->get()
        ->map(function ($reg) use ($today) {
          $cls = $reg->demoClass;
          if (!$cls) return null;

          if (
            $cls->start_time <= now()->endOfDay() &&
            $cls->end_time   >= now()->startOfDay()
          ) {
            return $this->formatEvent($cls, 'Demo');
          }

          return null;
        })
        ->filter();

      // ✅ Workshops
      $workshops = WorkshopRegistration::where('user_id', $user->id)
        ->where('checked_in', 1)
        ->with(['workshop.classes'])
        ->get()
        ->flatMap(function ($reg) use ($today) {
          return $reg->workshop->classes
            ->filter(function ($cls) {
              return $cls->start_time <= now()->endOfDay() &&
                $cls->end_time   >= now()->startOfDay();
            })
            ->map(fn($cls) => $this->formatEvent($cls, 'Workshop'));
        });

      // ✅ Webinars
      $webinars = WebinarRegistration::where('user_id', $user->id)
        ->where('checked_in', 1)
        ->with(['webinar'])
        ->get()
        ->map(function ($reg) {
          $w = $reg->webinar;
          if (!$w) return null;

          if (
            $w->start_time <= now()->endOfDay() &&
            $w->end_time   >= now()->startOfDay()
          ) {
            return $this->formatEvent($w, 'Webinar');
          }

          return null;
        })
        ->filter();
    }

    // ===========================
    // 👨‍🏫 TEACHER
    // ===========================
    elseif ($user->acc_type == 'teacher') {

      // ✅ Courses
      $courses = TeacherClass::where('teacher_id', $user->id)
        ->with(['course_classes'])
        ->get()
        ->map(function ($tc) {
          $cls = $tc->course_classes;
          if (!$cls) return null;

          if (
            $cls->start_time <= now()->endOfDay() &&
            $cls->end_time   >= now()->startOfDay()
          ) {
            return $this->formatEvent($cls, 'Course');
          }

          return null;
        })
        ->filter();

      // ✅ Webinars
      $webinars = Webinar::where('host_id', $user->id)
        ->where('start_time', '<=', now()->endOfDay())
        ->where('end_time', '>=', now()->startOfDay())
        ->get()
        ->map(fn($w) => $this->formatEvent($w, 'Webinar'));

      // ✅ Demos
      $demos = DemoClass::where('host_id', $user->id)
        ->where('start_time', '<=', now()->endOfDay())
        ->where('end_time', '>=', now()->startOfDay())
        ->get()
        ->map(fn($d) => $this->formatEvent($d, 'Demo'));

      // ✅ Workshops
      $workshops = WorkshopClass::whereHas('workshop', function ($q) use ($user) {
        $q->where('host_id', $user->id);
      })
        ->where('start_time', '<=', now()->endOfDay())
        ->where('end_time', '>=', now()->startOfDay())
        ->get()
        ->map(fn($w) => $this->formatEvent($w, 'Workshop'));



      /////////////------------////////////////////////

      // ✅ Courses
      $courses2 = CourseEnrollment::where('user_id', $user->id)
        ->where('status', 1)
        ->with(['course.courseClasses'])
        ->get()
        ->flatMap(function ($enrollment) use ($today) {
          return $enrollment->course->courseClasses
            ->filter(function ($cls) use ($today) {
              return $cls->start_time <= now()->endOfDay() &&
                $cls->end_time   >= now()->startOfDay();
            })
            ->map(fn($cls) => $this->formatEvent($cls, 'Course'));
        });

      // ✅ Demos
      $demos2 = DemoClassRegistration::where('user_id', $user->id)
        ->where('checked_in', 1)
        ->with(['demoClass'])
        ->get()
        ->map(function ($reg) use ($today) {
          $cls = $reg->demoClass;
          if (!$cls) return null;

          if (
            $cls->start_time <= now()->endOfDay() &&
            $cls->end_time   >= now()->startOfDay()
          ) {
            return $this->formatEvent($cls, 'Demo');
          }

          return null;
        })
        ->filter();

      // ✅ Workshops
      $workshops2 = WorkshopRegistration::where('user_id', $user->id)
        ->where('checked_in', 1)
        ->with(['workshop.classes'])
        ->get()
        ->flatMap(function ($reg) use ($today) {
          return $reg->workshop->classes
            ->filter(function ($cls) {
              return $cls->start_time <= now()->endOfDay() &&
                $cls->end_time   >= now()->startOfDay();
            })
            ->map(fn($cls) => $this->formatEvent($cls, 'Workshop'));
        });

      // ✅ Webinars
      $webinars2 = WebinarRegistration::where('user_id', $user->id)
        ->where('checked_in', 1)
        ->with(['webinar'])
        ->get()
        ->map(function ($reg) {
          $w = $reg->webinar;
          if (!$w) return null;

          if (
            $w->start_time <= now()->endOfDay() &&
            $w->end_time   >= now()->startOfDay()
          ) {
            return $this->formatEvent($w, 'Webinar');
          }

          return null;
        })
        ->filter();


      $courses = $courses->merge($courses2);
      $demos = $demos->merge($demos2);
      $workshops = $workshops->merge($workshops2);
      $webinars = $webinars->merge($webinars2);
    }

    // ===========================
    // 🔥 MERGE + SORT
    // ===========================
    $todayClasses = collect()
      ->merge($courses)
      ->merge($demos)
      ->merge($webinars)
      ->merge($workshops)
      ->filter(fn($event) => !is_null($event))
      ->sortBy(fn($event) => Carbon::parse($event['_start_datetime']))
      ->map(function ($event) {
        unset($event['_start_datetime']);
        unset($event['date']);
        return $event;
      })
      ->values();

    return response()->json([
      "status"  => true,
      "message" => "Today's classes fetched successfully",
      "data"    => $todayClasses,
    ]);
  }

  private function formatEvent($model, string $type): array
  {
    if ($type == 'Workshop') {
      $start = Carbon::parse($model->start_date_time);
    } else {
      $start = Carbon::parse(
        $model->start_time
          ?? $model->started_at
          ?? $model->start_date_time
      );
    }


    $end = Carbon::parse($model->end_time ?? $model->ended_at ?? $model->end_date_time);
    $now = Carbon::now();



    $classStatus = 'pending';
    if ($model->status == '1' || $model->status == 'scheduled' || $model->status == 'live') {
      if ($now->lt($start)) {
        $classStatus = 'upcoming';
      } elseif ($now->between($start, $end)) {
        $classStatus = 'ongoing';
      } elseif ($now->gt($end)) {
        $classStatus = 'completed';
      }
    }


    // ✅ Fix: $model IS the course_class already when type is Course
    if ($type == 'Course') {
      $parent = $model->course_classes;
      $title  = $model->title ?? $parent?->title ?? '';
      $course = $model->course;
    } elseif ($type == 'Webinar') {
      $parent = $model;
      $title  = $model->title ?? '';
      $course = $model;
    } elseif ($type == 'Workshop') {
      $parent = $model->workshop;
      $title  = $model->title ?? $parent?->title ?? '';
      $course = $model->workshop;
    } elseif ($type == 'Demo') {
      $parent = $model;
      $title  = $model->title ?? '';
      $course = $model;
    } else {
      $parent = null;
      $title  = '';
    }

    return [
      "date"            => $start->toDateString(),       // used for filtering
      "_start_datetime" => $start->toDateTimeString(),   // used for sorting

      "id"           => $model->id,
      "title"        => $title,
      "type"         => $type,
      "time"         => $start->format('h:i a'),
      "start_time"   => $start->format('d-m-Y h:i a'),
      "end_time"     => $end->format('d-m-Y h:i a'),
      "platform"     => $model->provider?->slug ?? $model->class_mode ?? '',
      "subject"      => $model->description ?? '',
      "course"       => $course?->title ?? '',
      "teacher_name" => $model->host?->name ?? '',
      "meeting_link" => $model->meeting_link ?? $model->meeting_url,
      "recorded_link" => $model->recording_url ?? '',
      "status"       => $classStatus,
    ];
  }


  public function myReview(Request $request)
  {
    $user = $request->user();




    $review = AppReview::where('user_id', $user->id)
      ->first();



    $total = AppReview::where('status', 'approved')->count();



    if (!$review) {
      return response()->json([
        'status' => true,
        'data' => null,
        'total_reviews' => $total
      ]);
    }

    return response()->json([
      'status' => true,
      'data' => [
        'rating' => $review->rating,
        'feedback' => $review->feedback,
        'total_reviews' => $total
      ]
    ]);
  }



  /// ✅ CREATE / UPDATE REVIEW
  public function writeReview(Request $request)
  {

    $user = $request->user();

    $review = AppReview::updateOrCreate(
      [
        'user_id' => $user->id,
      ],
      [
        'rating' => $request->rating,
        'feedback' => $request->feedback
      ]
    );

    return response()->json([
      'status' => true,
      'message' => 'Review saved successfully',
      'data' => $review
    ]);
  }
}
