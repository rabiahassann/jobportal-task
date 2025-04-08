<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\JobApplicant;
use App\Models\User;

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
}
