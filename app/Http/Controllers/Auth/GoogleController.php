<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->id,
                    'auth_provider' => 'google',
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                $user = User::create([
                    'nom' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'auth_provider' => 'google',
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
                
                // Ensure the 'Guest' role exists before assigning it
                \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Guest', 'guard_name' => 'web']);
                $user->assignRole('Guest');
            }

            if (!$user->is_active) {
                return redirect()->route('login')->with('error', 'Votre compte est désactivé. Veuillez contacter un administrateur.');
            }

            Auth::login($user);

            if (empty($user->organisation_id) || empty($user->province_id)) {
                return redirect()->route('complete-profile');
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la connexion avec Google : ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('login')->with('error', 'Une erreur est survenue lors de la connexion avec Google. Veuillez réessayer.');
        }
    }
}
