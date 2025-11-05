<?php

use App\Http\Controllers\Api\WebinarController;
use App\Http\Controllers\Api\WebinarRegistrationController;
use App\Http\Controllers\Api\ZegoTokenController;
use App\Http\Resources\WebinarResource;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use Google\Client as GoogleClient;


Route::group(['namespace' => 'App\Http\Controllers\Api', 'prifix' => 'api'], function () {


  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/guest-signup', 'RegisterController@guestSignup');
    Route::post('/google-login-check', 'LoginController@googleLoginCheck');
    Route::post('/user-data-retrieve', 'LoginController@userDataRetrieve');


    Route::post('/my-wallet', 'StudentController@myWallet');
    Route::post('/wallet/convert-to-rupees', 'StudentController@convertToRupees');
    Route::post('/wallet/transfer-to-bank', 'StudentController@transferToBank');
    Route::post('top-banner/submit', function (Request $request) {
      Log::info('📢 Top Banner Request:', $request->all());
      return response()->json([
        'status' => true,
        'data' => "Your request has been submitted successfully!",
      ]);
    });

    Route::post('request-teacher-class/submit', function (Request $request) {
      Log::info('👨‍🏫 Teacher Class Request:', $request->all());

      return response()->json([
        'status' => true,
        'data' => "Your request has been submitted successfully!",
      ]);
    });

    Route::post('request-form/submit', function (Request $request) {
      Log::info('📝 Request Form Submitted:', $request->all());

      return response()->json([
        'status' => true,
        'data' => "Your request has been submitted successfully!",
      ]);
    });

    Route::post('request-subject-class/submit', function (Request $request) {
      Log::info('📝 Request Form Submitted:', $request->all());

      return response()->json([
        'status' => true,
        'data' => "Your request has been submitted successfully!",
      ]);
    });

    Route::post('request-course/submit', function (Request $request) {
      Log::info('📝 Request Form Submitted:', $request->all());

      return response()->json([
        'status' => true,
        'data' => "Your request has been submitted successfully!",
      ]);
    });


    Route::post('/referral/share', function (Request $r) {
      // log share event for analytics
      Log::info('Referral share', ['code' => $r->code, 'method' => $r->method, 'user_id' => $r->user_id ?? null, 'ip' => $r->ip()]);
      return response()->json(['status' => true, 'message' => 'Share recorded']);
    });

    Route::post('/referral/click', function (Request $r) {
      // when user clicks link (open webview or app), record
      $code = $r->input('code');
      Log::info('Referral click', ['code' => $code, 'ip' => $r->ip(), 'ua' => $r->userAgent()]);
      return response()->json(['status' => true, 'message' => 'Click recorded']);
    });

    Route::post('/referral/send-invites', function (Request $r) {
      $payload = $r->input('contacts'); // array of contacts
      // validate and queue SMS/emails via gateway (not implemented)
      Log::info('Send invites', ['payload' => $payload, 'by' => $r->user()]);
      return response()->json(['status' => true, 'message' => 'Invites received. Will be sent (simulated).']);
    });

    // called when new user registers with ?ref=CODE or code in payload
    Route::post('/referral/register', function (Request $r) {
      $code = $r->input('referral_code');
      $newUserId = rand(1000, 9999); // simulate
      // store referral record
      Log::info('Referral register', ['code' => $code, 'new_user' => $newUserId, 'ip' => $r->ip()]);
      return response()->json(['status' => true, 'message' => 'Referral recorded', 'awarded' => 100]);
    });



    Route::post('requested-classes', function (Request $request) {

      return response()->json([
        'success' => true,
        'data' => [
          [
            'id' => 1,
            'title' => 'Math - Algebra Basics',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          [
            'id' => 2,
            'title' => 'Math - Algebra Basics-2',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          [
            'id' => 3,
            'title' => 'Math - Algebra Basics-3',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          [
            'id' => 4,
            'title' => 'Math - Algebra Basics-4',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          [
            'id' => 5,
            'title' => 'Math - Algebra Basics',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          [
            'id' => 6,
            'title' => 'Math - Algebra Basics-2',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          [
            'id' => 7,
            'title' => 'Math - Algebra Basics-3',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          [
            'id' => 8,
            'title' => 'Math - Algebra Basics-4',
            'grade' => '8th Grade',
            'board' => 'CBSE',
            'subject' => 'Mathematics',
            'note' => 'Need special focus on equations.',
            'status' => 'Pending',
            'created_at' => '2025-10-31',
          ],
          // More items...
        ]
      ]);
    });

    Route::post('referral/stats', function (Request $request) {
      $reward_per_join = 100;
      $bonus_on_first_class = 50;

      return response()->json([
        'earned_coins' => 1850,
        'friends_joined' => 4,
        'reward_per_join' => $reward_per_join,
        'bonus_on_first_class' => $bonus_on_first_class,
        'how_it_works' => 'How it works',
        'how_it_works_description' => 'For each friend who joins using your link/code, you earn Green Coins. Coins can be converted to rewards or wallet credits.',
        'badge_title' => '💰 Earn Green Coins',
        'badge_description' => "• $reward_per_join coins when your friend joins\n• $bonus_on_first_class extra coins when they join first class\n• Track your invites in Rewards → Invited List",
        'friends_list' => [
          [
            'name' => 'Rahul Mehta',
            'joined_at' => '2025-10-30',
            'earned_coins' => 150,
            'status' => 'completed',
          ],
          [
            'name' => 'Anjali Singh',
            'joined_at' => '2025-10-27',
            'earned_coins' => 100,
            'status' => 'joined',
          ],
          [
            'name' => 'Vikas Kumar',
            'joined_at' => '2025-10-25',
            'earned_coins' => 0,
            'status' => 'pending',
          ],
          [
            'name' => 'Priya Sharma',
            'joined_at' => '2025-10-21',
            'earned_coins' => 50,
            'status' => 'joined',
          ],
        ],
      ]);
    });

    Route::post('/student-home', 'StudentController@home');
  });

  Route::post('/user-login-email', 'LoginController@googleLoginCheck');


  Route::post('/teacher-signup', 'RegisterController@teacherSignup');
  Route::post('/student-signup', 'RegisterController@studentSignup');

  Route::get('/check-server', 'UserController@checkServer');
  Route::post('user-exist-not', 'LoginController@userExistNot')->name('user-exist-no');


  Route::post('/get-user-details', 'UserController@getUserDetails')->middleware('auth:sanctum');
  Route::post('/set-user-token', 'UserController@setUserToken');


  Route::post('/send-otp-signIn', 'OtpController@sendOtpSignIn');
  Route::post('/verify-otp-signIn', 'OtpController@verifyOtpSignIn');

  Route::post('/send-otp-signUp', 'OtpController@sendOtpSignUp');
  Route::post('/verify-otp-signUp', 'OtpController@verifyOtpSignUp');

  Route::post('/send-email-otp', 'OtpController@sendEmailOtp');
  Route::post('/verify-email-otp', 'OtpController@verifyEmailOtp');

  Route::post('/re-send-otp', 'OtpController@reSendOtp');


  Route::post('/user-details', 'UserController@index');
  Route::post('/teacher-home', 'TeacherController@home');

  Route::post('/guest-home', 'GuestController@home');


  Route::get('/teachers', function () {

    $data = [
      [
        'id' => 1,
        'name' => 'Asif T',
        'qualification' => 'MCA, NET',
        'subjects' => 'Computer Science, English',
        'ranking' => 1,
        'rating' => 4.8,
        'imageUrl' => asset('assets/mobile-app/asit-t.png'),
        'description' => 'Highly experienced computer science teacher with passion for modern learning.',
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ]
      ],
      [
        'id' => 2,
        'name' => 'James M',
        'qualification' => 'B.Ed, M.Sc',
        'subjects' => 'Maths, Physics',
        'ranking' => 2,
        'rating' => 4.5,
        'imageUrl' => asset('assets/mobile-app/asit-t.png'),
        'description' => 'Highly experienced computer science teacher with passion for modern learning.',
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ]
      ],
      [
        'id' => 3,
        'name' => 'Sana K',
        'qualification' => 'B.Tech, M.Tech',
        'subjects' => 'Chemistry, Biology',
        'ranking' => 3,
        'rating' => 4.7,
        'imageUrl' => asset('assets/mobile-app/asit-t.png'),
        'description' => 'Highly experienced computer science teacher with passion for modern learning.',
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ]
      ],
      [
        'id' => 4,
        'name' => 'Mohammed S',
        'qualification' => 'PhD, M.Ed',
        'subjects' => 'History, Civics',
        'ranking' => 4,
        'rating' => 4.9,
        'imageUrl' => asset('assets/mobile-app/asit-t.png'),
        'description' => 'Highly experienced computer science teacher with passion for modern learning.',
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ]
      ]
    ];
    return response()->json([
      'message' => 'Teachers Fetached successfully',
      'data' => $data,
      'status' => true
    ]);
  });

  Route::get('/teacher/{id}', function ($id) {
    // simple dummy single teacher detail
    return response()->json([
      'id' => $id,
      'name' => 'Asif T',
      'qualification' => 'MCA, NET',
      'subjects' => 'Computer Science, English',
      'ranking' => 1,
      'rating' => 4.8,
      'image' => asset('assets/mobile-app/asit-t.png'),
      'description' => 'Highly experienced computer science teacher with passion for modern learning.',
      'reviews' => [
        [
          'name' => 'Student 1',
          'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
          'comment' => 'Very helpful sessions!',
          'rating' => 5
        ],
        [
          'name' => 'Student 2',
          'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
          'comment' => 'Explains concepts clearly.',
          'rating' => 4
        ],
      ]
    ]);
  });


  Route::get('/subjects', function () {
    $subjects = [
      [
        'name' => 'English',
        'description' => 'Improve grammar, vocabulary, and communication skills.',
        'main_image' => asset("/assets/mobile-app/images/subjects/english.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'Alice Johnson',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
          [
            'id'  => 2,
            'name' => 'Robert White',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
      [
        'name' => 'Math',
        'description' => 'Learn arithmetic, algebra, geometry, and more.',
        'main_image' => asset("/assets/mobile-app/images/subjects/math.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'David Miller',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
          [
            'id'  => 2,
            'name' => 'Sophia Taylor',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
      [
        'name' => 'Science',
        'description' => 'Explore physics, chemistry, and biology through fun learning.',
        'main_image' => asset("/assets/mobile-app/images/subjects/science.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'Daniel Brown',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
          [
            'id'  => 2,
            'name' => 'Emma Davis',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
      [
        'name' => 'History',
        'description' => 'Understand world history and important civilizations.',
        'main_image' => asset("/assets/mobile-app/images/subjects/history.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'Michael Scott',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
          [
            'id'  => 2,
            'name' => 'Laura Green',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
      [
        'name' => 'Geography',
        'description' => 'Learn about Earth, maps, and global environments.',
        'main_image' => asset("/assets/mobile-app/images/subjects/geography.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'James Wilson',
            'qualification' => 'B.Tech, M.Tech',
            'subjects' => 'Chemistry, Biology',
            'ranking' => 3,
            'rating' => 4.7,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
      [
        'name' => 'Art',
        'description' => 'Explore creativity through painting, drawing, and design.',
        'main_image' => asset("/assets/mobile-app/images/subjects/art.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'Anna Lee',
            'qualification' => 'PhD, M.Ed',
            'subjects' => 'History, Civics',
            'ranking' => 4,
            'rating' => 4.9,
            'imageUrl' => asset('assets/mobile-app/asit-t.png'),
          ],
        ],
      ],
      [
        'name' => 'Physics',
        'description' => 'Understand motion, energy, and the laws of the universe.',
        'main_image' => asset("/assets/mobile-app/images/subjects/physics.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'William Clark',
            'qualification' => 'PhD, M.Ed',
            'subjects' => 'History, Civics',
            'ranking' => 4,
            'rating' => 4.9,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
          [
            'id'  => 2,
            'name' => 'Olivia Evans',
            'qualification' => 'PhD, M.Ed',
            'subjects' => 'History, Civics',
            'ranking' => 4,
            'rating' => 4.9,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
      [
        'name' => 'Chemistry',
        'description' => 'Learn about elements, compounds, and reactions.',
        'main_image' => asset("/assets/mobile-app/images/subjects/chemistry.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'Henry Adams',
            'qualification' => 'PhD, M.Ed',
            'subjects' => 'History, Civics',
            'ranking' => 4,
            'rating' => 4.9,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
      [
        'id'  => 1,
        'name' => 'Biology',
        'description' => 'Study living organisms, genetics, and ecosystems.',
        'main_image' => asset("/assets/mobile-app/images/subjects/biology.jpg"),
        'image' => asset("/assets/mobile-app/icons/book-icon.png"),
        'reviews' => [
          [
            'name' => 'Student 1',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png',
            'comment' => 'Very helpful sessions!',
            'rating' => 5
          ],
          [
            'name' => 'Student 2',
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
            'comment' => 'Explains concepts clearly.',
            'rating' => 4
          ],
        ],
        'available_teachers' => [
          [
            'id'  => 1,
            'name' => 'Sarah Thompson',
            'qualification' => 'PhD, M.Ed',
            'subjects' => 'History, Civics',
            'ranking' => 4,
            'rating' => 4.9,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
          [
            'id'  => 2,
            'name' => 'Mark Anderson',
            'qualification' => 'PhD, M.Ed',
            'subjects' => 'History, Civics',
            'ranking' => 4,
            'rating' => 4.9,
            'imageUrl' => asset('assets/mobile-app/asit-t.png')
          ],
        ],
      ],
    ];

    return response()->json([
      'status' => true,
      'message' => 'Subjects fetched successfully',
      'data' => $subjects,
    ]);
  });

  // Route::post('/teacher-profile', 'TeacherController@home');

  // Route::post('/teacher-mycourses', 'TeacherController@home');

  // Route::post('/student-profile', 'StudentController@home');

  // Route::post('/notifications', 'UserController@notifications');

  Route::any('upload', function (Request $request) {
    Log::info($request->all());
    $source = $request->header('X-Request-Source', 'Unknown');

    // if ($request->hasFile('avatar')) {
    //     $avatarPath = $request->file('avatar')->store('avatars', 'public');
    // }

    // if ($request->hasFile('cv')) {
    //     $cvPath = $request->file('cv')->store('cvs', 'public');
    // }
    return response()->json([
      'message' => 'Files uploaded successfully',
      'source' => $source,
      'avatar' => "avatarPath" ?? null,
      'cv' => "cvPath" ?? null,
    ]);
  });


  // Route::middleware('auth:sanctum')->group(function () {
  // Route::any('webinars-list', function (Request $request) {

  //   $data = Webinar::get();
  //   Log::info($data);
  //   return response()->json([
  //     'status' => true,
  //     'data' => WebinarResource::collection($data),
  //   ]);
  // })->middleware('auth:sanctum');

  Route::post('/webinars', 'WebinarApiController@index')->middleware('auth:sanctum');
  Route::post('/webinars/{id}', 'WebinarApiController@show');
  Route::post('/webinars/{id}/live', 'WebinarApiController@liveDetails');
  Route::post('/webinars/{id}/register', 'WebinarApiController@register')->middleware('auth:sanctum');
  Route::post('/webinars/{id}/join', 'WebinarApiController@join')->middleware('auth:sanctum');
  // });

  // Public webinar listing and detail
  // Route::get('webinars', [WebinarController::class, 'index']);
  // Route::get('webinars/{webinar}', [WebinarController::class, 'show']);

  // // Protected routes — add auth middleware as needed
  // Route::post('webinars', [WebinarController::class, 'store']);       // create
  // Route::put('webinars/{webinar}', [WebinarController::class, 'update']);
  // Route::delete('webinars/{webinar}', [WebinarController::class, 'destroy']);

  // // Start/end (host)
  // Route::post('webinars/{webinar}/start', [WebinarController::class, 'start']);
  // Route::post('webinars/{webinar}/end', [WebinarController::class, 'end']);

  // registration
  // Route::post('webinars/{webinar}/register', [WebinarRegistrationController::class, 'store']);
  // Route::get('webinars/{webinar}/registrations', [WebinarRegistrationController::class, 'index']);

  // // registered webinars for a user
  // Route::get('registrations', [WebinarRegistrationController::class, 'registeredForUser']);

  // // token generation for joining ZEGOCLOUD
  // Route::post('webinars/{webinar}/token', [ZegoTokenController::class, 'generate']);


  //   Route::get('/grades', function () {
  //     return response()->json([
  //         'status' => true,
  //         'data' => [
  //             ['id' => 1, 'name' => 'Higher Secondary', 'code' => 'hs'],
  //             ['id' => 2, 'name' => 'Under Graduate', 'code' => 'ug'],
  //             ['id' => 3, 'name' => 'Competitive Exam', 'code' => 'ce'],
  //             ['id' => 4, 'name' => 'Skill Development', 'code' => 'sd'],
  //             ['id' => 5, 'name' => 'Other', 'code' => 'other'],
  //         ]
  //     ]);
  // });
  Route::get('/options/{grade_code}', function ($grade_code) {
    $response = [];

    switch ($grade_code) {
      case 'hs':
        $response = [
          'type' => 'boards',
          'list' => [
            ['id' => 1, 'name' => 'CBSE'],
            ['id' => 2, 'name' => 'State Board'],
          ],
        ];
        break;
      case 'ug':
        $response = [
          'type' => 'universities',
          'list' => [
            ['id' => 1, 'name' => 'Kerala University'],
            ['id' => 2, 'name' => 'MG University'],
          ],
        ];
        break;
      case 'ce':
        $response = [
          'type' => 'exam_categories',
          'list' => [
            ['id' => 1, 'name' => 'UPSC'],
            ['id' => 2, 'name' => 'SSC'],
          ],
        ];
        break;
      case 'sd':
        $response = [
          'type' => 'skill_categories',
          'list' => [
            ['id' => 1, 'name' => 'Programming'],
            ['id' => 2, 'name' => 'Designing'],
          ],
        ];
        break;
      case 'other':
        $response = [
          'type' => 'manual_input',
          'fields' => ['course_name', 'subject_name']
        ];
        break;
    }

    return response()->json(['status' => true, 'data' => $response]);
  });

  Route::get('/subjects/{board_id}', function ($board_id) {
    $data = [
      1 => ['Maths', 'Physics', 'Chemistry'],
      2 => ['Biology', 'History', 'Civics'],
    ];
    return response()->json(['status' => true, 'data' => $data[$board_id] ?? []]);
  });

  Route::get('/skills/{category_id}', function ($category_id) {
    $skills = [
      1 => ['Flutter', 'Laravel', 'React'],
      2 => ['Photoshop', 'Figma'],
    ];
    return response()->json(['status' => true, 'data' => $skills[$category_id] ?? []]);
  });



  // 🔹 Get Grades List
  // Route::get('/grades', function () {
  //     $grades = Grade::all()->pluck('name');

  //     return response()->json([
  //         'status' => true,
  //         'data' => $grades,
  //     ]);
  // });
  Route::get('/grades', function () {
    $data = [
      [
        'id' => 1,
        'name' => 'Pre-Primary / Kindergarten',
        'value' => 'Pre-Primary / Kindergarten',
        'boards' => [
          [
            'id' => 1,
            'name' => 'Kerala State Board',
            'value' => 'Kerala State Board',
            'subjects' => [
              ['id' => 1, 'name' => 'All Subjects', 'value' => 'All Subjects'],
              ['id' => 4, 'name' => 'English', 'value' => 'English'],
              ['id' => 14, 'name' => 'General Knowledge', 'value' => 'General Knowledge'],
            ],
          ],
          [
            'id' => 2,
            'name' => 'CBSE',
            'value' => 'CBSE',
            'subjects' => [
              ['id' => 1, 'name' => 'All Subjects', 'value' => 'All Subjects'],
              ['id' => 4, 'name' => 'English', 'value' => 'English'],
              ['id' => 18, 'name' => 'Spoken English', 'value' => 'Spoken English'],
            ],
          ],
        ],
      ],
      [
        'id' => 2,
        'name' => 'Lower Primary',
        'value' => 'Lower Primary',
        'boards' => [
          [
            'id' => 3,
            'name' => 'Kerala State Board',
            'value' => 'Kerala State Board',
            'subjects' => [
              ['id' => 2, 'name' => 'Mathematics', 'value' => 'Mathematics'],
              ['id' => 3, 'name' => 'Science', 'value' => 'Science'],
              ['id' => 4, 'name' => 'English', 'value' => 'English'],
            ],
          ],
          [
            'id' => 4,
            'name' => 'ICSE',
            'value' => 'ICSE',
            'subjects' => [
              ['id' => 2, 'name' => 'Mathematics', 'value' => 'Mathematics'],
              ['id' => 3, 'name' => 'Science', 'value' => 'Science'],
              ['id' => 14, 'name' => 'General Knowledge', 'value' => 'General Knowledge'],
            ],
          ],
        ],
      ],
      [
        'id' => 3,
        'name' => 'Up to 10th',
        'value' => 'Up to 10th',
        'boards' => [
          [
            'id' => 5,
            'name' => 'CBSE',
            'value' => 'CBSE',
            'subjects' => [
              ['id' => 2, 'name' => 'Mathematics', 'value' => 'Mathematics'],
              ['id' => 3, 'name' => 'Science', 'value' => 'Science'],
              ['id' => 5, 'name' => 'Social Studies', 'value' => 'Social Studies'],
            ],
          ],
          [
            'id' => 6,
            'name' => 'Kerala State Board',
            'value' => 'Kerala State Board',
            'subjects' => [
              ['id' => 4, 'name' => 'English', 'value' => 'English'],
              ['id' => 7, 'name' => 'Physics', 'value' => 'Physics'],
              ['id' => 8, 'name' => 'Chemistry', 'value' => 'Chemistry'],
            ],
          ],
        ],
      ],
      [
        'id' => 4,
        'name' => 'Higher Secondary',
        'value' => 'Higher Secondary',
        'boards' => [
          [
            'id' => 7,
            'name' => 'State Board',
            'value' => 'State Board',
            'subjects' => [
              ['id' => 7, 'name' => 'Physics', 'value' => 'Physics'],
              ['id' => 8, 'name' => 'Chemistry', 'value' => 'Chemistry'],
              ['id' => 9, 'name' => 'Biology', 'value' => 'Biology'],
            ],
          ],
          [
            'id' => 8,
            'name' => 'CBSE',
            'value' => 'CBSE',
            'subjects' => [
              ['id' => 10, 'name' => 'Commerce', 'value' => 'Commerce'],
              ['id' => 11, 'name' => 'Economics', 'value' => 'Economics'],
              ['id' => 14, 'name' => 'General Knowledge', 'value' => 'General Knowledge'],
            ],
          ],
        ],
      ],
      [
        'id' => 5,
        'name' => 'Under/Post Graduate Level',
        'value' => 'Under/Post Graduate Level',
        'boards' => [
          [
            'id' => 9,
            'name' => 'University',
            'value' => 'University',
            'subjects' => [
              ['id' => 12, 'name' => 'Engineering Subjects', 'value' => 'Engineering Subjects'],
              ['id' => 13, 'name' => 'Medical Subjects', 'value' => 'Medical Subjects'],
              ['id' => 19, 'name' => 'Programming', 'value' => 'Programming'],
            ],
          ],
        ],
      ],
      [
        'id' => 6,
        'name' => 'Competitive Exams',
        'value' => 'Competitive Exams',
        'boards' => [
          [
            'id' => 10,
            'name' => 'National Level',
            'value' => 'National Level',
            'subjects' => [
              ['id' => 15, 'name' => 'Quantitative Aptitude', 'value' => 'Quantitative Aptitude'],
              ['id' => 16, 'name' => 'Reasoning', 'value' => 'Reasoning'],
              ['id' => 17, 'name' => 'Current Affairs', 'value' => 'Current Affairs'],
            ],
          ],
        ],
      ],
      [
        'id' => 7,
        'name' => 'Skill Development',
        'value' => 'Skill Development',
        'boards' => [
          [
            'id' => 11,
            'name' => 'Vocational Training',
            'value' => 'Vocational Training',
            'subjects' => [
              ['id' => 18, 'name' => 'Spoken English', 'value' => 'Spoken English'],
              ['id' => 20, 'name' => 'Digital Marketing', 'value' => 'Digital Marketing'],
              ['id' => 21, 'name' => 'Designing', 'value' => 'Designing'],
            ],
          ],
        ],
      ],
    ];

    return response()->json([
      'status' => true,
      'message' => 'Grades with boards and subjects fetched successfully.',
      'grades' => $data,
    ]);
  });

  // 🔹 Get Subjects List
  // Route::get('/subjects', function () {
  //   $subjects = Subject::all()->pluck('name');

  //   return response()->json([
  //     'status' => true,
  //     'data' => $subjects,
  //   ]);
  // });

  Route::get('/boards', function () {
    $grades = Grade::all()->pluck('name');

    return response()->json([
      'status' => true,
      'data' => $grades,
    ]);
  });

  // Route::get('/fetch-grades', function () {
  //   return response()->json([
  //     'status' => true,
  //     'data' => [
  //       ['id' => 1, 'name' => 'Pre-Primary / Kindergarten', 'value' => 'Pre-Primary / Kindergarten'],
  //       ['id' => 2, 'name' => 'Lower Primary', 'value' => 'Lower Primary'],
  //       ['id' => 3, 'name' => 'Up to 10th', 'value' => 'Up to 10th'],
  //       ['id' => 4, 'name' => 'Higher Secondary', 'value' => 'Higher Secondary'],
  //       ['id' => 5, 'name' => 'Under/Post Graduate Level', 'value' => 'Under/Post Graduate Level'],
  //       ['id' => 6, 'name' => 'Competitive Exams', 'value' => 'Competitive Exams'],
  //       ['id' => 7, 'name' => 'Skill Development', 'value' => 'Skill Development'],
  //     ]
  //   ]);
  // });





  // Route::get('/fetch-subjects', function () {
  //   return response()->json([
  //     'status' => true,
  //     'data' => [
  //       // Common subjects
  //       ['id' => 1, 'name' => 'All Subjects', 'value' => 'All Subjects'],
  //       ['id' => 2, 'name' => 'Mathematics', 'value' => 'Mathematics'],
  //       ['id' => 3, 'name' => 'Science', 'value' => 'Science'],
  //       ['id' => 4, 'name' => 'English', 'value' => 'English'],
  //       ['id' => 5, 'name' => 'Social Studies', 'value' => 'Social Studies'],
  //       ['id' => 6, 'name' => 'Computer Science', 'value' => 'Computer Science'],

  //       // Higher Secondary
  //       ['id' => 7, 'name' => 'Physics', 'value' => 'Physics'],
  //       ['id' => 8, 'name' => 'Chemistry', 'value' => 'Chemistry'],
  //       ['id' => 9, 'name' => 'Biology', 'value' => 'Biology'],

  //       // UG/PG
  //       ['id' => 10, 'name' => 'Commerce', 'value' => 'Commerce'],
  //       ['id' => 11, 'name' => 'Economics', 'value' => 'Economics'],
  //       ['id' => 12, 'name' => 'Engineering Subjects', 'value' => 'Engineering Subjects'],
  //       ['id' => 13, 'name' => 'Medical Subjects', 'value' => 'Medical Subjects'],

  //       // Competitive Exams
  //       ['id' => 14, 'name' => 'General Knowledge', 'value' => 'General Knowledge'],
  //       ['id' => 15, 'name' => 'Quantitative Aptitude', 'value' => 'Quantitative Aptitude'],
  //       ['id' => 16, 'name' => 'Reasoning', 'value' => 'Reasoning'],
  //       ['id' => 17, 'name' => 'Current Affairs', 'value' => 'Current Affairs'],

  //       // Skills
  //       ['id' => 18, 'name' => 'Spoken English', 'value' => 'Spoken English'],
  //       ['id' => 19, 'name' => 'Programming', 'value' => 'Programming'],
  //       ['id' => 20, 'name' => 'Digital Marketing', 'value' => 'Digital Marketing'],
  //       ['id' => 21, 'name' => 'Designing', 'value' => 'Designing'],
  //     ]
  //   ]);
  // });

  Route::post('/user-activity', [App\Http\Controllers\Api\UserActivityController::class, 'store']);


  Route::post('/check-user', function (\Illuminate\Http\Request $request) {
    $exists = \App\Models\User::where('id', $request->user_id)->where('acc_type', $request->acc_type)->exists();
    return response()->json(['exists' => $exists]);
  });



  // Route::post('/google-login-check', function (\Illuminate\Http\Request $request) {

  //   $idToken = $request->idToken;


  //   Log::info($idToken);

  //   $client = new GoogleClient(['client_id' => env('GOOGLE_CLIENT_ID')]);
  //   $payload = $client->verifyIdToken($idToken);

  //   if (!$payload) {
  //     Log::info($payload);
  //     return response()->json(['status' => 'error', 'message' => 'Invalid ID token'], 401);
  //   }

  //   Log::info('payload' . $payload);
  //   $email = $payload['email'];
  //   $user = User::where('email', $email)->first();

  //   if (!$user) {
  //     Log::info('status error' . $email);
  //     return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
  //   }

  //   // Optionally create your own JWT / sanctum token
  //   // $token = $user->createToken('google_login')->plainTextToken;
  //   // Log::info('token' . $token);
  //   return response()->json([
  //     'status' => 'success',
  //     // 'token'  => $token,
  //     'user'   => $user,
  //   ]);
  // });




  Route::get('/top-banners', 'StudentController@topBanners');
  Route::get('/course-banners', 'StudentController@courseBanners');

  // Route::get('/teachers', 'StudentController@teachersListing');
  Route::get('/grades-subjects', 'StudentController@gradesSubjects');
  Route::get('/board-syllabus', 'StudentController@boardSyllabus');

  Route::get('/referral', 'StudentController@Referral');
  Route::get('/provide-subjects', 'StudentController@provideSubjects');
  Route::get('/provide-courses', 'StudentController@provideCourses');


  Route::get('/social-links', function () {
    $socials = [
      [
        'name' => 'Facebook',
        'icon' => asset('assets/mobile-app/icons/facebook.png'),
        'link' => 'https://facebook.com/BookMyTeacher',
      ],
      [
        'name' => 'Instagram',
        'icon' => asset('assets/mobile-app/icons/instagram.png'),
        'link' => 'https://instagram.com/BookMyTeacher',
      ],
      [
        'name' => 'YouTube',
        'icon' => asset('assets/mobile-app/icons/youtube.png'),
        'link' => 'https://youtube.com/@BookMyTeacher',
      ],
      [
        'name' => 'LinkedIn',
        'icon' => asset('assets/mobile-app/icons/linkedin.png'),
        'link' => 'https://linkedin.com/company/BookMyTeacher',
      ],
    ];

    return response()->json([
      'status' => true,
      'data' => $socials,
    ]);
  });
});
