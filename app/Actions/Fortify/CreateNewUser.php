<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\Turnstile;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        $settings = site_config();
        if (($settings['registration'] ?? null) != 1) {
            return to_route('threads')->with('error', __('Registration is disabled.'));
        }

        Validator::make($input, [
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:25', 'unique:users'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms'    => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',

            'captcha'               => (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'local')) ? ['required', 'localCaptcha'] : 'nullable',
            'g-recaptcha-response'  => (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'recaptcha')) ? 'required|captcha' : 'nullable',
            'cf-turnstile-response' => (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'trunstile')) ? ['required', new Turnstile] : 'nullable',
        ])->validate();

        $user = User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'active'   => ($settings['mode'] ?? null) == 'Public',
        ]);
        $user->assignRole('member');

        return $user;
    }
}
