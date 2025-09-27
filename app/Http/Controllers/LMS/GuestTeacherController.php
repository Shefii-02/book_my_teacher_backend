<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuestTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guestTeachers = User::where('company_id', 1)
            ->where('acc_type', 'guest_teacher')
            ->paginate(10);

        return view('company.guest_teacher.index', compact('guestTeachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.guest_teacher.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'title'    => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => 'required|string|max:15|unique:users,mobile',
        ]);

        // Create User first
        $user = User::create([
            'name'       => $request->title,
            'email'      => $request->email,
            'mobile'     => $request->mobile,
            'company_id' => 1,
            'acc_type'   => 'guest_teacher',
            'password'   => Hash::make('123456789000'),
        ]);

        // Handle avatar upload into media_files
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $path = $file->storeAs(
                'uploads/avatars',
                time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
                'public'
            );

            MediaFile::create([
                'user_id'    => $user->id,
                'company_id' => 1,
                'file_type'  => 'avatar',
                'file_path'  => $path,
                'name'       => $file->getClientOriginalName(),
                'mime_type'  => $file->getMimeType(),
            ]);
        }

        return redirect()->route('admin.guest-teacher.index')
            ->with('success', 'Guest teacher created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $guestTeacher = User::findOrFail($id);

        return view('company.guest_teacher.form', compact('guestTeacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $guestTeacher = User::findOrFail($id);

        $request->validate([
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'title'    => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $guestTeacher->id,
            'mobile'   => 'required|string|max:15|unique:users,mobile,' . $guestTeacher->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update User details
        $data = [
            'name'   => $request->title,
            'email'  => $request->email,
            'mobile' => $request->mobile,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guestTeacher->update($data);

        // Handle avatar update in media_files
        if ($request->hasFile('avatar')) {
            // Delete old avatar entry
            MediaFile::where('company_id', 1)
                ->where('user_id', $guestTeacher->id)
                ->where('file_type', 'avatar')
                ->delete();

            $file = $request->file('avatar');

            $path = $file->storeAs(
                'uploads/avatars',
                time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
                'public'
            );

            MediaFile::create([
                'user_id'    => $guestTeacher->id,
                'company_id' => 1,
                'file_type'  => 'avatar',
                'file_path'  => $path,
                'name'       => $file->getClientOriginalName(),
                'mime_type'  => $file->getMimeType(),
            ]);
        }

        return redirect()->route('admin.guest-teacher.index')
            ->with('success', 'Guest teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guestTeacher = User::findOrFail($id);

        // Delete avatar entry from media_files
        MediaFile::where('company_id', 1)
            ->where('user_id', $guestTeacher->id)
            ->where('file_type', 'avatar')
            ->delete();

        $guestTeacher->delete();

        return redirect()->route('admin.guest-teacher.index')
            ->with('success', 'Guest teacher deleted successfully.');
    }

    /**
     * Custom: Show teacher overview page.
     */
    public function overview($id)
    {
        $guestTeacher = User::findOrFail($id);

        return view('company.guest_teacher.overview', compact('guestTeacher'));
    }
}
