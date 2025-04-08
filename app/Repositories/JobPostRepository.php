<?php
namespace App\Repositories;

use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;

class JobPostRepository implements JobPostRepositoryInterface
{
    public function all(): Collection
    {
        return JobPost::all();
    }

    public function create(array $data): JobPost
    {
        return JobPost::create($data);
    }

    public function find(int $id): ?JobPost
    {
        return JobPost::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $jobPost = $this->find($id);
        if ($jobPost) {
            return $jobPost->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $jobPost = $this->find($id);
        if ($jobPost) {
            return $jobPost->delete();
        }
        return false;
    }
}
