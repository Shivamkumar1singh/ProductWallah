<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $admin = Auth::user(); // SAME users table
        return view('admin.profile.show', compact('admin'));
    }

    public function updatePersonal(Request $request)
    {
        
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female',
            'dob' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
        ]);

        $admin->update($request->only([
            'name', 'gender', 'dob', 'marital_status', 'address'
        ]));

        return back()->with('success', 'Profile updated successfully');
    }

    public function updateContact(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:10',
        ]);

        $admin->update($request->only(['email', 'phone']));

        return back()->with('success', 'Contact updated successfully');
    }

    public function updateAvatar(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'profile_image' => 'required|image|max:2048',
        ]);

        if ($admin->profile_image) {
            Storage::disk('public')->delete($admin->profile_image);
        }

        $path = $request->file('profile_image')
            ->store('users/profile', 'public');

        $admin->update(['profile_image' => $path]);

        return back()->with('success', 'Profile image updated');
    }

    public function updateCover(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'cover_image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);
    
        $user = auth()->user();
    
        // delete old cover
        if ($user->cover_image && Storage::disk('public')->exists($user->cover_image)) {
            Storage::disk('public')->delete($user->cover_image);
        }
    
        $path = $request->file('cover_image')->store('users/cover', 'public');
    
        $user->update([
            'cover_image' => $path,
        ]);
    
        return back()->with('success', 'Cover image updated successfully');
    }

    public function removeCover()
    {
        $user = auth()->user();
    
        if ($user->cover_image) {
            Storage::disk('public')->delete($user->cover_image);
            $user->update(['cover_image' => null]);
        }
    
        return back()->with('success', 'Cover image removed');
    }

}
