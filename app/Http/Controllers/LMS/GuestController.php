<?php

namespace App\Http\Controllers\LMS;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    /**
     * Display a listing of the guests.
     */
    public function index()
    {
        $guests = User::where('company_id', 1)
            ->where('acc_type', 'guest')
            ->paginate(10);

        return view('company.guests.index', compact('guests'));
    }

    /**
     * Show the form for creating a new guest.
     */
    public function create()
    {
        return view('company.guests.form');
    }

    /**
     * Store a newly created guest in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'title'  => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:15|unique:users,mobile',
        ]);

        // First create the user without avatar
        $user = User::create([
            'name'       => $validated['title'],
            'email'      => $validated['email'],
            'mobile'     => $validated['mobile'],
            'company_id' => 1,
            'acc_type'   => 'guest',
        ]);

        // Handle avatar upload if provided
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

        return redirect()->route('admin.guest.index')->with('success', 'Guest created successfully!');
    }

    /**
     * Show the form for editing the specified guest.
     */
    public function edit(User $guest)
    {
        return view('company.guests.form', compact('guest'));
    }

    /**
     * Update the specified guest in storage.
     */
    public function update(Request $request, User $guest)
    {
        $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'title'  => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $guest->id,
            'mobile' => 'required|string|max:15|unique:users,mobile,' . $guest->id,
        ]);

        $guest->update([
            'name'   => $validated['title'],
            'email'  => $validated['email'],
            'mobile' => $validated['mobile'],
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar record if exists
            $oldAvatar = MediaFile::where('company_id', 1)
                ->where('user_id', $guest->id)
                ->where('file_type', 'avatar')
                ->first();

            if ($oldAvatar) {
                if (Storage::disk('public')->exists($oldAvatar->file_path)) {
                    Storage::disk('public')->delete($oldAvatar->file_path);
                }
                $oldAvatar->delete();
            }

            // Store new avatar
            $file = $request->file('avatar');
            $path = $file->storeAs(
                'uploads/avatars',
                time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
                'public'
            );

            MediaFile::create([
                'user_id'    => $guest->id,
                'company_id' => 1,
                'file_type'  => 'avatar',
                'file_path'  => $path,
                'name'       => $file->getClientOriginalName(),
                'mime_type'  => $file->getMimeType(),
            ]);
        }

        return redirect()->route('admin.guest.index')->with('success', 'Guest updated successfully!');
    }

    /**
     * Remove the specified guest from storage.
     */
    public function destroy(User $guest)
    {
        // Delete avatar file & DB entry
        $avatars = MediaFile::where('company_id', 1)
            ->where('user_id', $guest->id)
            ->where('file_type', 'avatar')
            ->get();

        foreach ($avatars as $avatar) {
            if (Storage::disk('public')->exists($avatar->file_path)) {
                Storage::disk('public')->delete($avatar->file_path);
            }
            $avatar->delete();
        }

        $guest->delete();

        return redirect()->route('admin.guest.index')->with('success', 'Guest deleted successfully!');
    }

    /**
     * Show single guest overview.
     */
  public function overview($id)
    {
        $guest = User::findOrFail($id);

        return view('company.guests.overview', compact('guest'));
    }
}
