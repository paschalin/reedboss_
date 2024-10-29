<?php

namespace App\Http\Livewire\Category;

use Livewire\Component;

class PublicList extends Component
{
    public function render()
    {
        return view('livewire.category.list')->layout('layouts.public', ['title' => __('Categories')]);
    }
}
