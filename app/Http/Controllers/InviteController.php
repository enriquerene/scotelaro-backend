<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function show($token)
    {
        $invite = Invite::where('token', $token)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return view('invite.accept', compact('invite'));
    }

    public function accept(Request $request, $token)
    {
        $invite = Invite::where('token', $token)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $invite->phone, // temporary name
            'phone' => $invite->phone,
            'password' => Hash::make($request->password),
            'role' => $invite->role,
            'email_verified_at' => now(),
        ]);

        $invite->update(['used_at' => now()]);

        auth()->login($user);

        // Redirect based on subscription status
        if ($user->isStudent() && !$user->subscriptions()->where('status', 'active')->exists()) {
            return redirect()->route('onboarding');
        }

        return redirect()->route('app.home');
    }
}