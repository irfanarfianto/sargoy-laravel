<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $breadcrumbItems = [
            ['name' => 'Dashboard', 'url' => auth()->user()->hasRole('seller') ? route('seller') : route('admin')],
            ['name' => 'Profile'],
        ];

        if ($user->hasRole('admin')) {
            $profile = Admin::where('user_id', $user->id)->first();
        } elseif ($user->hasRole('seller')) {
            $profile = Seller::where('user_id', $user->id)->first();
        } else {
            $profile = null; // Handle other types of users or roles here
        }

        return view('dashboard.profile.index', compact('user', 'profile', 'breadcrumbItems'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        try {
            // Update basic user information
            $user->fill($request->validated());

            // Check if email is updated, reset verification status
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Update profile details based on role
            if ($user->hasRole('admin')) {
                $adminProfile = Admin::where('user_id', $user->id)->firstOrNew();
                $adminProfile->update($request->input('admin', []));
            } elseif ($user->hasRole('seller')) {
                $sellerProfile = Seller::where('user_id', $user->id)->firstOrNew();
                $sellerProfile->update($request->input('seller', []));
            } elseif ($user->hasRole('visitor')) {
                $visitorProfile = Visitor::where('user_id', $user->id)->firstOrNew();
                $visitorProfile->update($request->input('visitor', []));
            }

            flash()->success('Profile updated successfully.');
        } catch (\Exception $e) {
            flash()->error('An error occurred while updating the profile.');
        }

        return Redirect::route('profile.index');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        try {
            Auth::logout();
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            flash()->success('Account deleted successfully.');
        } catch (\Exception $e) {
            flash()->error('An error occurred while deleting the account.');
            return Redirect::route('profile.index');
        }

        return Redirect::to('/');
    }
}
