<?php

namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EnrollmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Instructors need to see who is enrolled
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Enrollment $enrollment): bool
    {
        // Instructors can view details
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admins or System/Self-service can create financial contracts
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Enrollment $enrollment): bool
    {
        // Strictly forbidden for everyone (including admins)
        // Use custom actions instead (cancel, renew, change payment method)
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Enrollment $enrollment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Enrollment $enrollment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Enrollment $enrollment): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can cancel an enrollment.
     */
    public function cancel(User $user, Enrollment $enrollment): bool
    {
        // Only admins can run the custom 'cancel' action
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can renew an enrollment.
     */
    public function renew(User $user, Enrollment $enrollment): bool
    {
        // Only admins can run the custom 'renew' action
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can change payment method.
     */
    public function changePaymentMethod(User $user, Enrollment $enrollment): bool
    {
        // Only admins can change payment method
        return $user->isAdmin();
    }
}
