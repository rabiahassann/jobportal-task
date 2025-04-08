<?php

namespace App\Http\Controllers;

use App\Repositories\JobPostRepositoryInterface;
use App\Http\Requests\JobPostRequest;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    protected $jobPostRepository;

    public function __construct(JobPostRepositoryInterface $jobPostRepository)
    {
        $this->jobPostRepository = $jobPostRepository;
    }

    public function index()
    {
        $jobPosts = $this->jobPostRepository->all();
        return view('job-posts.index', compact('jobPosts'));
    }

    
    public function create()
    {
        return view('job-posts.create');
    }

    
    public function store(JobPostRequest $request)
    {
        \Log::info('Job Post Store Request:', $request->all());
        
        try {
            $data = $request->validated();
            $this->jobPostRepository->create($data);
            return redirect()->route('job-posts.index')->with('success', 'Job post created successfully');
        } catch (\Exception $e) {
            \Log::error('Error creating job post: ' . $e->getMessage());
            return back()->with('error', 'Failed to create job post. Please try again.');
        }
    }

    
    public function edit($id)
    {
        $jobPost = $this->jobPostRepository->find($id);
        return view('job-posts.edit', compact('jobPost'));
    }

   
    public function update(JobPostRequest $request, $id)
    {
        $data = $request->validated();
        $this->jobPostRepository->update($id, $data);
        return redirect()->route('job-posts.index');
    }

   
    public function destroy($id)
    {
        $this->jobPostRepository->delete($id);
        return redirect()->route('job-posts.index');
    }
}

