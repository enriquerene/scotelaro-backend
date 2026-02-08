<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin() || $user->isStaff()) {
        // Try to redirect to admin panel, fallback to welcome page if not available
        try {
            return redirect('/admin');
        } catch (\Exception $e) {
            return redirect('/')->with('info', 'Admin panel not configured. Redirected to home.');
        }
    }
    
    // For students, check subscription and redirect accordingly
    if ($user->isStudent()) {
        $hasActiveSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->exists();
            
        if (!$hasActiveSubscription) {
            return redirect()->route('onboarding');
        }
        
        return redirect()->route('app.home');
    }
    
    // Default fallback
    return redirect()->route('app.home');
})->middleware(['auth', 'verified'])->name('dashboard');

// Student App Routes (/app)
Route::prefix('app')->middleware(['auth', 'verified', 'check.subscription'])->group(function () {
    Route::get('/', \App\Livewire\App\Dashboard::class)->name('app.home');
    Route::get('classes', \App\Livewire\App\Classes::class)->name('app.classes');
    Route::get('enrollments', \App\Livewire\App\Enrollments::class)->name('app.enrollments');
    Route::get('profile', \App\Livewire\App\Profile::class)->name('app.profile');
    Route::get('progress', \App\Livewire\App\Progress::class)->name('app.progress');
});

// Invite routes
Route::get('invite/{token}', [\App\Http\Controllers\InviteController::class, 'show'])->name('invite.show');
Route::post('invite/{token}', [\App\Http\Controllers\InviteController::class, 'accept'])->name('invite.accept');

// Onboarding wizard
Route::get('onboarding', \App\Livewire\OnboardingWizard::class)
    ->middleware(['auth', 'verified'])
    ->name('onboarding');

require __DIR__.'/settings.php';
