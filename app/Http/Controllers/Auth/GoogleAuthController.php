<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('login')->withErrors([
                'google' => 'Login dengan Google gagal. Silakan coba lagi.',
            ]);
        }

        $email = $googleUser->getEmail();

        if (! $email || ! ($googleUser->user['verified_email'] ?? false)) {
            return redirect()->route('login')->withErrors([
                'google' => 'Google tidak memberikan email terverifikasi untuk akun ini.',
            ]);
        }

        $isAdmin = in_array(strtolower($email), [
            'ramadhanrizqi4810@gmail.com',
            'rizqi239@gmail.com',
            'fatoni260701@gmail.com',
        ]);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $googleUser->getName() ?: $email,
                'password' => Str::random(40),
                'role' => $isAdmin ? 'admin' : 'pelanggan',
                'email_verified_at' => now(),
            ]
        );

        if ($isAdmin && $user->role !== 'admin') {
            $user->role = 'admin';
            $user->save();
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}