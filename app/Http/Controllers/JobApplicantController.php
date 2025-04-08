<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\JobApplicant;
use App\Http\Requests\JobApplicantRequest;
use Illuminate\Http\Request;
use Auth;
use App\Notifications\BulkJobApplicantEmail;
use Illuminate\Support\Facades\Notification;

class JobApplicantController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(JobApplicant::class, 'applicant');
    }


    public function show(JobPost $jobPost)
    {
      
        $applicants = JobApplicant::where('job_post_id', $jobPost->id)
            ->with('user')
            ->get();
            
        return view('job_applicants.index', compact('applicants', 'jobPost'));
    }

    public function downloadCV( $applicant)
    {
       $applicant = JobApplicant::where('id',$applicant)->first();
        if (!$applicant->resume) {
            return back()->with('error', 'CV not found');
        }
        
        return response()->download(storage_path('app/public/' . $applicant->resume));
    }

    public function updateStatus(Request $request, JobApplicant $applicant)
    {
        $this->authorize('update', $applicant);
        
        $applicant->update(['status' => $request->status]);
        return back()->with('success', 'Status updated successfully');
    }

    public function store(JobApplicantRequest $request)
    {
      
        $jobPost = JobPost::findOrFail($request->job_id);
        try {
            $cvPath = $request->file('cv')->store('cv_uploads', 'public');
    
            JobApplicant::create([
                'user_id' => auth()->id(),
                'job_post_id' => $jobPost->id,
                'cover_letter' => $request->cover_letter,
                'resume' => $cvPath,
            ]);
            return redirect()->back()->with('alert', 'Application submitted successfully!');

        } catch (\Exception $e) {
          
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function sendBulkEmail(Request $request, JobPost $jobPost)
    {
        $this->authorize('sendBulkEmail', JobApplicant::class);
        
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'applicants' => 'required|array',
            'applicants.*' => 'exists:job_applicants,id'
        ]);

        $applicants = JobApplicant::where('job_post_id', $jobPost->id)
            ->whereIn('id', $request->applicants)
            ->with('user')
            ->get();

        try {
            $notification = new BulkJobApplicantEmail($request->subject, $request->message);
            Notification::send($applicants->pluck('user'), $notification);

            return redirect()->route('job-applicants.show', $jobPost)
                ->with('success', 'Emails have been queued for sending to selected applicants.');
        } catch (\Exception $e) {
            \Log::error('Failed to queue bulk emails: ' . $e->getMessage());
            return redirect()->route('job-applicants.show', $jobPost)
                ->with('error', 'Failed to queue emails. Please try again.');
        }
    }

    public function myApplications()
    {
        $user = Auth::user();
        $applications =JobApplicant::with('jobPost')->where('user_id',$user->id)->get();
        return view('user.my_applications', compact('applications'));
    }
}
