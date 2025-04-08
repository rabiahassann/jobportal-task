<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobApplicantController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');
    Route::resource('job-posts', JobPostController::class);
});

Route::middleware(['auth', 'role:user'])->get('/user/dashboard', function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('user.dashboard');
});

Route::get('/job-posts', [JobPostController::class, 'index'])->name('job-posts.index');
Route::get('/job-posts/create', [JobPostController::class, 'create'])->name('job-posts.create');
Route::post('/job-posts', [JobPostController::class, 'store'])->name('job-posts.store');
Route::get('/job-posts/{jobPost}', [JobPostController::class, 'show'])->name('job-posts.show');
Route::get('/job-posts/{jobPost}/edit', [JobPostController::class, 'edit'])->name('job-posts.edit');
Route::put('/job-posts/{jobPost}', [JobPostController::class, 'update'])->name('job-posts.update');
Route::delete('/job-posts/delete/{jobPost}', [JobPostController::class, 'destroy'])->name('job-posts.destroy');

// Job Applicants Routes
Route::get('/job-applicants', [JobApplicantController::class, 'index'])->name('job-applicants.index');
Route::get('/job-applicants/{jobPost}', [JobApplicantController::class, 'show'])->name('job-applicants.show');
Route::get('/job-applicants/{id}/download-cv', [JobApplicantController::class, 'downloadCV'])->name('job-applicants.download-cv');
Route::put('/job-applicants/{id}/update-status', [JobApplicantController::class, 'updateStatus'])->name('job-applicants.update-status');
Route::post('/job-posts/{jobPost}/applicants/send-bulk-email', [JobApplicantController::class, 'sendBulkEmail'])->name('job-applicants.send-bulk-email');

// Test Routes
Route::get('/test-bulk-email', function() {
    $jobPost = \App\Models\JobPost::first(); // Get any job post
    $applicants = \App\Models\JobApplicant::where('job_post_id', $jobPost->id)
        ->with('user')
        ->take(2) // Take only 2 applicants for testing
        ->get();

    $notification = new \App\Notifications\BulkJobApplicantEmail(
        'Test Email Subject',
        'This is a test email message for queue testing.'
    );

    \Illuminate\Support\Facades\Notification::send($applicants->pluck('user'), $notification);

    return 'Test emails have been queued. Check your queue worker and email inbox.';
})->name('test.bulk.email');

require __DIR__.'/auth.php';
