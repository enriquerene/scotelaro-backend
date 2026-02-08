<?php

namespace App\Livewire\App;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Subscription;
use App\Models\Enrollment;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public ?Subscription $subscription = null;

    public function mount()
    {
        $this->subscription = auth()->user()->subscriptions()->latest()->first();
    }

    public function render()
    {
        $user = auth()->user();
        $enrollmentCount = $user->enrollments()->count();
        $upcomingClasses = $user->enrollments()
            ->with('gymClass.modality')
            ->get()
            ->take(3);

        // Check if subscription is newly created (within last 5 minutes)
        $isNewSubscription = $this->subscription &&
                            $this->subscription->created_at->diffInMinutes(now()) < 5;

        return view('livewire.app.dashboard', [
            'enrollmentCount' => $enrollmentCount,
            'upcomingClasses' => $upcomingClasses,
            'subscriptionActive' => $this->subscription && $this->subscription->status === 'active',
            'isNewSubscription' => $isNewSubscription,
            'subscription' => $this->subscription,
        ]);
    }
}
