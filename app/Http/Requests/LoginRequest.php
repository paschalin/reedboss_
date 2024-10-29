<?php

namespace App\Http\Requests;

use App\Rules\Turnstile;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest as FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $settings = site_config();

        return [
            Fortify::username()     => 'required|string',
            'password'              => 'required|string',
            'captcha'               => (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'local')) ? ['required', 'localCaptcha'] : 'nullable',
            'g-recaptcha-response'  => (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'recaptcha')) ? 'required|captcha' : 'nullable',
            'cf-turnstile-response' => (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'trunstile')) ? ['required', new Turnstile] : 'nullable',
        ];
    }
}
