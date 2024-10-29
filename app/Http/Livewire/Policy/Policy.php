<?php

namespace App\Http\Livewire\Policy;

use Livewire\Component;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\File;

class Policy extends Component
{
    public function mount()
    {
        if (! File::exists(resource_path('markdown/policy.md'))) {
            File::put(resource_path('markdown/policy.md'), "# Privacy Policy\n\nPlease update the policy in the settings.");
        }
    }

    public function render()
    {
        $termsFile = Jetstream::localizedMarkdownPath('policy.md');

        return view('livewire.policy.policy', ['policy' => file_get_contents($termsFile)])->layout('layouts.public');
    }
}
