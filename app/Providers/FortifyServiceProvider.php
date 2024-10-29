<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Http\Responses\LoginResponse;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Responses\LogoutResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Http\Responses\VerifyEmailResponse;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

        $this->app->singleton(\Laravel\Fortify\Contracts\LoginResponse::class, LoginResponse::class);
        $this->app->singleton(\Laravel\Fortify\Contracts\LogoutResponse::class, LogoutResponse::class);
        $this->app->singleton(\Laravel\Fortify\Http\Responses\TwoFactorLoginResponse::class, LoginResponse::class);
        $this->app->bind(\Laravel\Fortify\Http\Requests\LoginRequest::class, \App\Http\Requests\LoginRequest::class);
        $this->app->singleton(\Laravel\Fortify\Http\Responses\VerifyEmailResponse::class, VerifyEmailResponse::class);

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('username', $request->email)->orWhere('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }

    public function register()
    {
        //
    }
}
