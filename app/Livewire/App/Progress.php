<?php

namespace App\Livewire\App;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Graduation;

#[Layout('layouts.app')]
class Progress extends Component
{
    public function render()
    {
        $graduations = auth()->user()
            ->graduations()
            ->with('modality')
            ->orderBy('achieved_at', 'desc')
            ->get();

        return view('livewire.app.progress', [
            'graduations' => $graduations,
        ]);
    }
}
