<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ThrottleThread implements ValidationRule
{
    public function __construct(public $model)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tm = site_config('throttle_' . $this->model);
        if ($tm && $tm > 0) {
            $user = auth()->user();
            if ($user) {
                $last_time = $user->{$this->model}()->latest()->first()?->created_at;
                if (now()->lte($last_time->addMinutes($tm))) {
                    $fail(__('Please try again after :min minute(s).', ['min' => now()->diffInMinutes($last_time) + 1]));
                }
            }
        }
    }
}
