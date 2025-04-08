<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobPost;

class JobPostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view job posts
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, JobPost $jobPost): bool
    {
        return true; // Anyone can view a specific job post
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin'; // Only admins can create job posts
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobPost $jobPost): bool
    {
        return $user->role === 'admin'; // Only admins can update job posts
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobPost $jobPost): bool
    {
        return $user->role === 'admin'; // Only admins can delete job posts
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, JobPost $jobPost): bool
    {
        return $user->role === 'admin'; // Only admins can restore job posts
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, JobPost $jobPost): bool
    {
        return $user->role === 'admin'; // Only admins can permanently delete job posts
    }

    /**
     * Determine whether the user can apply for the job.
     */
    public function apply(User $user, JobPost $jobPost): bool
    {
        // Users can apply if:
        // 1. They are not admins
        // 2. The job is active
        // 3. The deadline hasn't passed
        return $user->role !== 'admin' 
            && $jobPost->status === 'active' 
            && $jobPost->applied_before > now();
    }
} 