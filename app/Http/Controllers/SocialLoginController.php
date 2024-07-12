<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class SocialLoginController extends Controller
{

    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $socialite = Socialite::driver('google')->user();
            $now = Carbon::now();
            $weekLater = $now->copy()->addDays(7);

            // Retrieve or create the user
            $user = User::firstOrCreate(
                [ 'email' => $socialite->getEmail()],
                [
                    'name'          => $socialite->getName(),
                    'email'         => $socialite->getEmail(),
                    'avatar'        => $socialite->getAvatar(),
                    'user_id'       => $socialite->getId(),
                    'social_token'  => $socialite->token,
                    'login_type'    => 'google',
                    'password'      => bcrypt('test@123'),
                    'trial_ends_at' => $weekLater,
                ]
            );
            // Log out any existing user session and log in the new user
            Auth::logout();
            session()->flush();
            // Update the name if it's null
            Auth::login($user);
            // Calculate the remaining trial days
            $trialLeft = Carbon::today()->diffInDays(Carbon::parse($user->trial_ends_at), false);

            // Redirect with appropriate message
            if ($trialLeft >= 0) {
                $message = "Trial left for $trialLeft days.";
                return redirect(route('dashboard'))->banner($message);
            } else {
                $billingUrl = route('billing'); // Ensure you have a named route for billing
                $message = "Your trial period has ended. Please <a href='{$billingUrl}'>subscribe to a plan</a>.";
                return redirect(route('billing'))->with('danger', $message);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return redirect('/login')->withErrors(['error' => 'Google authentication failed.']);
        }
    }


    public function redirectToOutlook()
    {
        return Socialite::driver('graph')->redirect();
    }

    public function handleOutlookCallback(Request $request)
    {
        try {
            $socialite = Socialite::driver('graph')->user();


            $user = User::firstOrCreate(
                [ 'email' => $socialite->getEmail()],
                [
                    'name'          => $socialite->getName() ?? null,
                    'email'         => $socialite->email ?? null,
                    'avatar'        => $socialite->avatar ?? null,
                    'user_id'       => $socialite->id ?? null,
                    'social_token'  => $socialite->token ?? null,
                    'login_type' => 'outlook',
                    'password'      =>bcrypt('test@123'),
                    'trial_ends_at' => Carbon::now()->addDays(7),
                ]
            );

            Auth::login($user);
            return redirect(route('dashboard'));
        } catch (\Exception $e) {
            Log::info($e);
            // Handle any errors
            return redirect('/login')->withErrors(['error' => 'Google authentication failed.']);
        }
    }


}
