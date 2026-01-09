<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        // dd(
        //     auth('vendor')->check(),
        //     auth('vendor')->user()
        // );

        $vendor = auth('vendor')->user();
        return view('vendor.profile.show', compact('vendor'));
    }

    public function updatePersonal(Request $request)
    {
        //dd($request->all());
        $vendor = auth('vendor')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female',
            'dob' => 'nullable|date',
            'marital_status' => 'nullable|in:married,unmarried',
            'address' => 'nullable|string',
        ]);

        $vendor->update($request->only('name','gender','dob','marital_status','address'));

        return back()->with('success', 'Profile updated');
    }

    public function updateContact(Request $request)
    {
        $vendor = auth('vendor')->user();

        $request->validate([
            'email' => 'required|email|unique:vendors,email,' . $vendor->id,
            'phone' => ['nullable','digits:10'],
        ]);

        $vendor->update($request->only('email','phone'));

        return back()->with('success', 'Contact updated');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|max:2048',
        ]);

        $vendor = auth('vendor')->user();

        if ($vendor->profile_image) {
            Storage::disk('public')->delete($vendor->profile_image);
        }

        $path = $request->file('profile_image')->store('vendors/avatar', 'public');

        $vendor->update(['profile_image' => $path]);

        return back();
    }

    public function updateCover(Request $request)
    {
        $request->validate([
            'cover_image' => 'required|image|max:4096',
        ]);

        $vendor = auth('vendor')->user();

        if ($vendor->cover_image) {
            Storage::disk('public')->delete($vendor->cover_image);
        }

        $path = $request->file('cover_image')->store('vendors/cover', 'public');

        $vendor->update(['cover_image' => $path]);

        return back();
    }

    public function removeCover()
    {
        $vendor = auth('vendor')->user();

        if ($vendor->cover_image) {
            Storage::disk('public')->delete($vendor->cover_image);
            $vendor->update(['cover_image' => null]);
        }

        return back();
    }
}
