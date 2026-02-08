<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip check for non-student roles (staff, admin)
        if (!$user || !$user->isStudent()) {
            return $next($request);
        }

        // Check if student has an active subscription
        $hasActiveSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->exists();

        // If no active subscription, redirect to onboarding
        if (!$hasActiveSubscription && !$request->routeIs('onboarding')) {
            return redirect()->route('onboarding');
        }

        // If has subscription and trying to access onboarding, redirect to app
        if ($hasActiveSubscription && $request->routeIs('onboarding')) {
            return redirect()->route('app.home');
        }

        return $next($request);
    }
}