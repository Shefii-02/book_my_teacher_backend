<?php

namespace App\Http\Controllers\LMS;

use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\DemoClass;
use App\Models\StreamProvider;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DemoClassController extends Controller
{
  public function index()
  {
    $webinarList = DemoClass::get();
    $data = [
      'total' => $webinarList->count(),
      'draft' => $webinarList->count(),
      'scheduled' => $webinarList->count(),
      'completed' => $webinarList->count(),
    ];
    $demo_classes = DemoClass::latest()->paginate(10);

    $statuses = ['total' => 'Total Demo Class', 'draft' => 'Draft', 'scheduled' => 'Scheduled', 'completed' => 'Ended'];
    $colors = ['total' => 'from-blue-500 to-violet-500', 'draft' => 'from-red-600 to-orange-600', 'scheduled' => 'from-emerald-500 to-teal-400', 'completed' => 'from-orange-500 to-yellow-500'];
    $icons = ['total' => 'ni ni-money-coins', 'draft' => 'ni ni-world', 'scheduled' => 'ni ni-paper-diploma', 'completed' => 'bi bi-ban'];
    $statusColors = [
      'draft' => 'bg-[#FF9119]',
      'scheduled' => 'bg-[#1da1f2]',
      'live' => 'bg-green-500',
      'ended' => 'bg-[#050708]'
    ];
    return view('company.demo-class.index', compact('demo_classes', 'data', 'statuses', 'colors', 'icons'));
  }


  public function create()
  {
    $company_id = auth()->user()->company_id;
    $teachers = Teacher::with('user')->whereHas('user')
      ->where('company_id', $company_id)
      ->get()
      ->map(function ($teacher) {
        return [
          'id'        => $teacher->id,
          'type'      => 'Teacher',
          'name'      => $teacher->user->name ?? null,
          'email'     => $teacher->user->email ?? null,
          'user_id'   => $teacher->user->id ?? null,
        ];
      });

    $guestTeachers = User::where('acc_type', 'guest_teacher')
      ->where('company_id', $company_id)
      // ->where('status', 1)
      ->get()
      ->map(function ($user) {
        return [
          'id'        => $user->id,
          'type'      => 'Guest Teacher',
          'name'      => $user->name,
          'email'     => $user->email,
          'user_id'   => $user->id,
        ];
      });

    $users = $teachers->merge($guestTeachers)->values();
    $providers = StreamProvider::all();
    return view('company.demo-class.form', compact('users', 'providers'));
  }

  public function store(Request $request)
  {
    // Validate request
    $data = $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'nullable|string|unique:webinars,slug',
      'description' => 'nullable|string',
      'host_id' => 'nullable|exists:users,id',
      'stream_provider_id' => 'nullable|exists:stream_providers,id',
      'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
      'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
      'recording_url' => 'nullable|url',
      'meeting_url' => 'nullable|url',
      'started_at' => 'nullable|date',
      'ended_at' => 'nullable|date|after_or_equal:started_at',

      'max_participants' => 'nullable|integer',
      'is_record_enabled' => 'nullable|boolean',
      'is_chat_enabled' => 'nullable|boolean',
      'is_screen_share_enabled' => 'nullable|boolean',
      'is_whiteboard_enabled' => 'nullable|boolean',
      'is_camera_enabled' => 'nullable|boolean',
      'is_audio_only_enabled' => 'nullable|boolean',
      'status' => 'required|string|in:draft,scheduled,live,ended',
      'tags' => 'nullable|string',
      'meta' => 'nullable|string',
    ]);

    // Auto-generate slug if not provided
    $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

    // Use DB transaction
    DB::beginTransaction();
    try {
      // Handle file uploads
      if ($request->hasFile('thumbnail_image')) {
        $data['thumbnail_image'] = $request->file('thumbnail_image')->store('webinars', 'public');
      }
      if ($request->hasFile('main_image')) {
        $data['main_image'] = $request->file('main_image')->store('webinars', 'public');
      }

      // Auto-generate slug if not provided
      $data['slug'] = $data['slug'] . '-' . time() ?? Str::slug($data['title']);

      // Auto-generate live_id
      $data['live_id'] = 'DEMOCLASS-' . strtoupper(Str::random(8));

      // Add company_id if needed
      $data['company_id'] = auth()->user()->company_id;

      // Create webinar
      DemoClass::create($data);

      DB::commit();

      return redirect()->route('company.demo-classes.index')->with('success', 'Demo Class created successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()
        ->withInput()
        ->with('error', 'DemoClass creation failed: ' . $e->getMessage());
    }
  }

  public function edit(DemoClass $webinar)
  {
    $company_id = 1;
    $teachers = Teacher::with('user')->whereHas('user')
      ->where('company_id', $company_id)
      ->get()
      ->map(function ($teacher) {
        return [
          'id'        => $teacher->id,
          'type'      => 'Teacher',
          'name'      => $teacher->user->name ?? null,
          'email'     => $teacher->user->email ?? null,
          'user_id'   => $teacher->user->id ?? null,
        ];
      });

    $guestTeachers = User::where('acc_type', 'guest_teacher')
      ->where('company_id', $company_id)
      // ->where('status', 1)
      ->get()
      ->map(function ($user) {
        return [
          'id'        => $user->id,
          'type'      => 'Guest Teacher',
          'name'      => $user->name,
          'email'     => $user->email,
          'user_id'   => $user->id,
        ];
      });

    $users = $teachers->merge($guestTeachers)->values();
    $providers = StreamProvider::all();
    return view('company.demo-class.form', compact('webinar', 'users', 'providers'));
  }

  public function update(Request $request, DemoClass $webinar)
  {
    $data = $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'nullable|string|unique:webinars,slug,' . $webinar->id,
      'description' => 'nullable|string',
      'host_id' => 'nullable|exists:users,id',
      'stream_provider_id' => 'nullable|exists:stream_providers,id',
      'thumbnail_image' => 'nullable|image',
      'main_image' => 'nullable|image',
      'recording_url' => 'nullable|url',
      'meeting_url' => 'nullable|url',
      'started_at' => 'nullable|date',
      'ended_at' => 'nullable|date',
      'registration_end_at' => 'nullable|date',
      'is_teacher_allowed' => 'nullable|boolean',
      'is_student_allowed' => 'nullable|boolean',
      'is_guest_allowed' => 'nullable|boolean',
      'max_participants' => 'nullable|integer',
      'is_record_enabled' => 'nullable|boolean',
      'is_chat_enabled' => 'nullable|boolean',
      'is_screen_share_enabled' => 'nullable|boolean',
      'is_whiteboard_enabled' => 'nullable|boolean',
      'is_camera_enabled' => 'nullable|boolean',
      'is_audio_only_enabled' => 'nullable|boolean',
      'status' => 'required|string|in:draft,scheduled,live,ended',
      'tags' => 'nullable|string',
      'meta' => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
      // Handle thumbnail image
      if ($request->hasFile('thumbnail_image')) {
        if ($webinar->thumbnail_image) {
          Storage::disk('public')->delete($webinar->thumbnail_image);
        }
        $data['thumbnail_image'] = $request->file('thumbnail_image')->store('webinars', 'public');
      }

      // Handle main image
      if ($request->hasFile('main_image')) {
        if ($webinar->main_image) {
          Storage::disk('public')->delete($webinar->main_image);
        }
        $data['main_image'] = $request->file('main_image')->store('webinars', 'public');
      }

      // Slug
      $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

      $webinar->update($data);

      DB::commit();
      return redirect()->route('company.demo-classes.index')->with('success', 'Demo Class updated successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->withInput()->with('error', 'DemoClass update failed. ' . $e->getMessage());
    }
  }


  public function destroy(DemoClass $webinar)
  {
    DB::beginTransaction();
    try {
      if ($webinar->thumbnail_image) Storage::disk('public')->delete($webinar->thumbnail_image);
      if ($webinar->main_image) Storage::disk('public')->delete($webinar->main_image);
      $webinar->delete();
      DB::commit();
      return redirect()->route('company.demo-classes.index')->with('success', 'Demo Class deleted successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Demo Class updation failed. ' . $e->getMessage());
    }
  }

  public function start(DemoClass $webinar)
  {
    // $webinar->update(['status' => 'live']);
    return redirect()->route('company.demo-classes.index')->with('success', 'Demo Class started successfully.');
  }


  public function show(DemoClass $webinar)
  {
    // Eager load relationships to avoid N+1 queries
    $webinar->load([
      'host',
      'provider',
      'providerApp',
      'registrations.user' // if registration is linked to user
    ]);

    // Optional: you can also calculate statistics here
    $totalParticipants = $webinar->registrations->count();
    $totalTeachers = $webinar->registrations->where('user.acc_type', 'teacher')->count();
    $totalStudents = $webinar->registrations->where('user.acc_type', 'student')->count();
    $totalGuests = $webinar->registrations->where('user.acc_type', 'guest')->count();

    return view('company.demo-class.show', compact(
      'webinar',
      'totalParticipants',
      'totalTeachers',
      'totalStudents',
      'totalGuests',
    ));
  }

  public function downloadCsv(DemoClass $webinar)
  {
    $fileName = 'demo_class_' . $webinar->id . '_registrations.csv';

    $headers = [
      "Content-type"        => "text/csv",
      "Content-Disposition" => "attachment; filename=$fileName",
      "Pragma"              => "no-cache",
      "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
      "Expires"             => "0"
    ];

    $columns = ['Name', 'Email', 'Phone', 'Account Type', 'Checked In', 'Attended', 'Registered At'];

    $callback = function () use ($webinar, $columns) {
      $file = fopen('php://output', 'w');
      fputcsv($file, $columns);

      foreach ($webinar->registrations as $reg) {
        fputcsv($file, [
          $reg->name,
          $reg->email,
          $reg->phone ?? '-',
          $reg->user?->acc_type ?? 'Guest',
          $reg->checked_in ? 'Confirmed' : 'Pending',
          $reg->attended_status ? 'Attended' : 'Absent',
          $reg->created_at->format('Y-m-d H:i:s'),
        ]);
      }

      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}
