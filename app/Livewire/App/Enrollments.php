<?php

namespace App\Livewire\App;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Enrollment;

#[Layout('layouts.app')]
class Enrollments extends Component
{
    public function render()
    {
        $enrollments = auth()->user()
            ->enrollments()
            ->with('gymClass.modality', 'gymClass.instructor')
            ->orderBy('enrolled_at', 'desc')
            ->get();

        return view('livewire.app.enrollments', [
            'enrollments' => $enrollments,
        ]);
    }
}
