<?php

namespace App\Repositories;

use App\Models\JobApplicant;

class JobApplicantRepository implements JobApplicantRepositoryInterface
{
    public function getAll($jobPostId = null)
    {
        $query = JobApplicant::with('user');
        if ($jobPostId) {
            $query->where('job_post_id', $jobPostId);
        }
        return $query->get();
    }

    public function store(array $data)
    {
        return JobApplicant::create($data);
    }

    public function find($id)
    {
        return JobApplicant::with('user')->find($id);
    }

    public function update($id, array $data)
    {
        $applicant = JobApplicant::find($id);
        if ($applicant) {
            $applicant->update($data);
        }
        return $applicant;
    }

    public function delete($id)
    {
        $applicant = JobApplicant::find($id);
        if ($applicant) {
            $applicant->delete();
            return true;
        }
        return false;
    }

    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}
