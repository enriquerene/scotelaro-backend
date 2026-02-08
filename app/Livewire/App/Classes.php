<?php

namespace App\Livewire\App;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\GymClass;

#[Layout('layouts.app')]
class Classes extends Component
{
    public function render()
    {
        $classes = GymClass::with('modality', 'instructor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.app.classes', [
            'classes' => $classes,
        ]);
    }
}
