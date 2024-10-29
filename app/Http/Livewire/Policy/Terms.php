<?php

namespace App\Http\Livewire\Policy;

use Livewire\Component;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\File;

class Terms extends Component
{
    public function mount()
    {
        if (! File::exists(resource_path('markdown/terms.md'))) {
            File::put(resource_path('markdown/terms.md'), "# Terms of Service\n\nPlease update the terms in the settings.");
        }
    }

    public function render()
    {
        $termsFile = Jetstream::localizedMarkdownPath('terms.md');

        return view('livewire.policy.terms', ['terms' => file_get_contents($termsFile)])->layout('layouts.public');
    }
}
