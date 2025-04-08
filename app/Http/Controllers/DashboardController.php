<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\JobApplicant;
use App\Models\User;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function admindashboard()
    {
        $totalUsers = User::count();
        $activeJobPosts = JobPost::where('status', 'active')->count();
        $totalApplicants = JobApplicant::count();
        $pendingApprovals = JobPost::where('status', 'pending')->count();
        $recentPosts = JobPost::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'activeJobPosts', 'totalApplicants', 'pendingApprovals', 'recentPosts'));
    }


    public function home(Request $request)
{
    $query = JobPost::where('status', 'active');

    if ($request->location) {
        $query->where('location', $request->location);
    }

    if ($request->job_type) {
        $query->where('job_type', $request->job_type);
    }

    if ($request->category) {
        $query->where('category', $request->category);
    }

    $activeJobPosts = $query->get();

    $locations = JobPost::distinct()->pluck('location');
    $categories = JobPost::distinct()->pluck('category');
    $jobTypes = JobPost::distinct()->pluck('job_type');

    return view('welcome', compact('activeJobPosts', 'locations', 'categories', 'jobTypes'));
}

    

    public function userdashboard()
    {
        $userId = auth()->user()->id;
        $totalApplications = JobApplicant::where('user_id', $userId)->count();
        $pendingApplications = JobApplicant::where('user_id', $userId)->where('status', 'pending')->count();
        $approvedApplications = JobApplicant::where('user_id', $userId)->where('status', 'approved')->count();
        $rejectedApplications = JobApplicant::where('user_id', $userId)->where('status', 'rejected')->count();
        return view('user.dashboard', compact('totalApplications', 'pendingApplications', 'approvedApplications', 'rejectedApplications'));
    }
}
