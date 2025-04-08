<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobApplicant;

class JobApplicantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin'; // Only admins can view all applicants
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, JobApplicant $applicant): bool
    {
        // Users can view their own applications, admins can view all
        return $user->role === 'admin' || $user->id === $applicant->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role !== 'admin'; // Only non-admins can apply for jobs
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobApplicant $applicant): bool
    {
        return $user->role === 'admin'; // Only admins can update applicant status
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobApplicant $applicant): bool
    {
        return $user->role === 'admin'; // Only admins can delete applications
    }

    /**
     * Determine whether the user can send bulk emails to applicants.
     */
    public function sendBulkEmail(User $user): bool
    {
        return $user->role === 'admin'; // Only admins can send bulk emails
    }

    /**
     * Determine whether the user can download CVs.
     */
    public function downloadCV(User $user, JobApplicant $applicant): bool
    {
        return $user->role === 'admin'; // Only admins can download CVs
    }
} 