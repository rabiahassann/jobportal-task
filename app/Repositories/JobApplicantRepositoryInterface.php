<?php

namespace App\Repositories;

interface JobApplicantRepositoryInterface
{
    public function getAll($jobPost);
    public function store(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}
