<?php

namespace App\Http\Controllers\LMS;

use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\StreamProvider;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WorkshopController extends Controller
{
  public function index()
  {
    $workshopList = Workshop::get();
    $data = [
      'total' => $workshopList->count(),
      'draft' => $workshopList->count(),
      'scheduled' => $workshopList->count(),
      'completed' => $workshopList->count(),
    ];
    $workshops = Workshop::latest()->paginate(10);

    $statuses = ['total' => 'Total Workshops', 'draft' => 'Draft', 'scheduled' => 'Scheduled', 'completed' => 'Ended'];
    $colors = ['total' => 'from-blue-500 to-violet-500', 'draft' => 'from-red-600 to-orange-600', 'scheduled' => 'from-emerald-500 to-teal-400', 'completed' => 'from-orange-500 to-yellow-500'];
    $icons = ['total' => 'ni ni-money-coins', 'draft' => 'ni ni-world', 'scheduled' => 'ni ni-paper-diploma', 'completed' => 'bi bi-ban'];
    $statusColors = [
      'draft' => 'bg-[#FF9119]',
      'scheduled' => 'bg-[#1da1f2]',
      'live' => 'bg-green-500',
      'ended' => 'bg-[#050708]'
    ];
    return view('company.workshops.index', compact('workshops', 'data', 'statuses', 'colors', 'icons'));
  }


  public function create()
  {
    $company_id = auth()->user()->company_id;
    $teachers = Teacher::with('user')
      ->where('company_id', $company_id)
      ->get()
      ->map(function ($teacher) {
        return [
          'id'        => $teacher->id,
          'type'      => 'teacher',
          'name'      => $teacher->user->name ?? null,
          'email'     => $teacher->user->email ?? null,
          'user_id'   => $teacher->user->id ?? null,
        ];
      });

    $guestTeachers = User::where('acc_type', 'guest_teacher')
      ->where('company_id', $company_id)
      ->where('status', 1)
      ->get()
      ->map(function ($user) {
        return [
          'id'        => $user->id,
          'type'      => 'guest_teacher',
          'name'      => $user->name,
          'email'     => $user->email,
          'user_id'   => $user->id,
        ];
      });

    $users = $teachers->merge($guestTeachers)->values();

    $providers = StreamProvider::all();
    return view('company.workshops.form', compact('users', 'providers'));
  }

  public function store(Request $request)
  {

    // Validate request
    $data = $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'nullable|string|unique:workshops,slug',
      'description' => 'nullable|string',
      'host_id' => 'nullable|exists:users,id',
      'stream_provider_id' => 'nullable|exists:stream_providers,id',
      'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
      'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
      'started_at' => 'nullable|date',
      'ended_at' => 'nullable|date|after_or_equal:started_at',
      'registration_end_at' => 'nullable|date|before_or_equal:started_at',
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
    ]);

    // Auto-generate slug if not provided
    $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

    // Use DB transaction
    DB::beginTransaction();
    try {
      // Handle file uploads
      if ($request->hasFile('thumbnail_image')) {
        $data['thumbnail_image'] = $request->file('thumbnail_image')->store('workshops', 'public');
      }
      if ($request->hasFile('main_image')) {
        $data['main_image'] = $request->file('main_image')->store('workshops', 'public');
      }

      // Auto-generate slug if not provided
      $data['slug'] = $data['slug'] . '-' . time() ?? Str::slug($data['title']);

      // Auto-generate live_id
      $data['live_id'] = 'WKSHP-' . strtoupper(Str::random(8));

      // Add company_id if needed
      $data['company_id'] = auth()->user()->company_id;

      // Create workshops
      Workshop::create($data);

      DB::commit();

      return redirect()->route('company.workshops.index')->with('success', 'Workshop created successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()
        ->withInput()
        ->with('error', 'Workshop creation failed: ' . $e->getMessage());
    }
  }



  public function edit(Workshop $workshop)
  {
    $users = User::all();
    $providers = StreamProvider::all();
    return view('company.workshops.form', compact('workshop', 'users', 'providers'));
  }

  public function update(Request $request, Workshop $workshop)
  {
    $data = $request->validate([
      'title' => 'required|string|max:255',
      'slug' => 'nullable|string|unique:workshops,slug,' . $workshop->id,
      'description' => 'nullable|string',
      'host_id' => 'nullable|exists:users,id',
      'stream_provider_id' => 'nullable|exists:stream_providers,id',
      'thumbnail_image' => 'nullable|image',
      'main_image' => 'nullable|image',
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
    ]);

    DB::beginTransaction();
    try {
      // Handle thumbnail image
      if ($request->hasFile('thumbnail_image')) {
        if ($workshop->thumbnail_image) {
          Storage::disk('public')->delete($workshop->thumbnail_image);
        }
        $data['thumbnail_image'] = $request->file('thumbnail_image')->store('workshops', 'public');
      }

      // Handle main image
      if ($request->hasFile('main_image')) {
        if ($workshop->main_image) {
          Storage::disk('public')->delete($workshop->main_image);
        }
        $data['main_image'] = $request->file('main_image')->store('workshops', 'public');
      }

      // Slug
      $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

      $workshop->update($data);

      DB::commit();
      return redirect()->route('company.workshops.index')->with('success', 'Workshop updated successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->withInput()->with('error', 'Workshop update failed. ' . $e->getMessage());
    }
  }


  public function destroy(Workshop $workshop)
  {
    DB::beginTransaction();
    try {
      if ($workshop->thumbnail_image) Storage::disk('public')->delete($workshop->thumbnail_image);
      if ($workshop->main_image) Storage::disk('public')->delete($workshop->main_image);
      $workshop->delete();
      DB::commit();
      return redirect()->route('company.workshops.index')->with('success', 'Workshop deleted successfully.');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', 'Workshop updation failed. ' . $e->getMessage());
    }
  }

  public function start(Workshop $workshop)
  {
    // $workshop->update(['status' => 'live']);
    return redirect()->route('company.workshops.index')->with('success', 'Workshop started successfully.');
  }


  public function show(Workshop $workshop)
  {
    // Eager load relationships to avoid N+1 queries
    $workshop->load([
      'host',
      'provider',
      'providerApp',
      'registrations.user' // if registration is linked to user
    ]);

    // Optional: you can also calculate statistics here
    $totalParticipants = $workshop->registrations->count();
    $totalTeachers = $workshop->registrations->where('user.acc_type', 'teacher')->count();
    $totalStudents = $workshop->registrations->where('user.acc_type', 'student')->count();
    $totalGuests = $workshop->registrations->where('user.acc_type', 'guest')->count();

    return view('company.workshops.show', compact(
      'workshop',
      'totalParticipants',
      'totalTeachers',
      'totalStudents',
      'totalGuests',
    ));
  }

  public function downloadCsv(Workshop $workshop)
  {
    $fileName = 'workshop_' . $workshop->id . '_registrations.csv';

    $headers = [
      "Content-type"        => "text/csv",
      "Content-Disposition" => "attachment; filename=$fileName",
      "Pragma"              => "no-cache",
      "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
      "Expires"             => "0"
    ];

    $columns = ['Name', 'Email', 'Phone', 'Account Type', 'Checked In', 'Attended', 'Registered At'];

    $callback = function () use ($workshop, $columns) {
      $file = fopen('php://output', 'w');
      fputcsv($file, $columns);

      foreach ($workshop->registrations as $reg) {
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
