<?php

namespace App\Livewire\App;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Profile extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.app.profile', [
            'user' => $user,
        ]);
    }
}
