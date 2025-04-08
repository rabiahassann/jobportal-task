<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Http\Requests\JobPostRequest;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(JobPost::class, 'jobPost');
    }

    public function index()
    {
     
        $jobPosts = JobPost::latest()->paginate(10);
        return view('job_posts.index', compact('jobPosts'));
    }

    public function create()
    {
        return view('job_posts.create');
    }

    public function store(JobPostRequest $request)
    {
        JobPost::create($request->validated());
        return redirect()->route('job-posts.index')
            ->with('success', 'Job post created successfully.');
    }

    public function show(JobPost $jobPost)
    {
        return view('job_posts.show', compact('jobPost'));
    }

    public function edit(JobPost $jobPost)
    {
        return view('job_posts.edit', compact('jobPost'));
    }

    public function update(JobPostRequest $request, JobPost $jobPost)
    {
        $jobPost->update($request->validated());
        return redirect()->route('job-posts.index')
            ->with('success', 'Job post updated successfully.');
    }

    public function destroy(JobPost $jobPost)
    {
        $jobPost->delete();
        return redirect()->route('job-posts.index')
            ->with('success', 'Job post deleted successfully.');
    }
}

