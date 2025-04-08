<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\JobApplicantRepository;
use App\Http\Requests\JobApplicantRequest;
use App\Notifications\BulkJobApplicantEmail;
use Illuminate\Support\Facades\Notification;

class JobApplicantController extends Controller
{
    protected $jobApplicantRepo;

    public function __construct(JobApplicantRepository $jobApplicantRepo)
    {
        $this->jobApplicantRepo = $jobApplicantRepo;
    }

    public function show($jobPost)
    {
        $applicants = $this->jobApplicantRepo->getAll($jobPost);
        return view('job_applicants.index', compact('applicants', 'jobPost'));
    }

    public function downloadCV($id)
    {
        $applicant = $this->jobApplicantRepo->find($id);
        if (!$applicant || !$applicant->cv_path) {
            return back()->with('error', 'CV not found');
        }
        return response()->download(storage_path('app/' . $applicant->cv_path));
    }

    public function updateStatus(Request $request, $id)
    {
        $applicant = $this->jobApplicantRepo->find($id);
        if (!$applicant) {
            return back()->with('error', 'Applicant not found');
        }

        $this->jobApplicantRepo->updateStatus($id, $request->status);
        return back()->with('success', 'Status updated successfully');
    }

    public function store(JobApplicantRequest $request)
    {
        try {
            $this->jobApplicantRepo->store($request->validated());
            return redirect()->back()->with('success', 'Applicant added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function sendBulkEmail(Request $request, $jobPost)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'applicants' => 'required|array',
            'applicants.*' => 'exists:job_applicants,id'
        ]);

        $applicants = $this->jobApplicantRepo->getAll($jobPost)
            ->whereIn('id', $request->applicants)
            ->load('user');

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


   
}
