<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobApplicantController;
use App\Http\Controllers\DashboardController;




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


Route::get('/', [DashboardController::class, 'home'])->name('home');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admindashboard'])->name('admin.dashboard');

   Route::get('/job-posts', [JobPostController::class, 'index'])->name('job-posts.index');
   Route::get('/job-posts/create', [JobPostController::class, 'create'])->name('job-posts.create');
   Route::post('/job-posts', [JobPostController::class, 'store'])->name('job-posts.store');
   Route::get('/job-posts/{jobPost}/edit', [JobPostController::class, 'edit'])->name('job-posts.edit');
   Route::put('/job-posts/{jobPost}', [JobPostController::class, 'update'])->name('job-posts.update');
   Route::delete('/job-posts/delete/{jobPost}', [JobPostController::class, 'destroy'])->name('job-posts.destroy');

// Job Applicants Routes
   Route::get('/job-applicants', [JobApplicantController::class, 'index'])->name('job-applicants.index');
   Route::get('/job-applicants/{jobPost}', [JobApplicantController::class, 'show'])->name('job-applicants.show');
   Route::post('/job-applicants/{jobPost}/send-bulk-email', [JobApplicantController::class, 'sendBulkEmail'])->name('job-applicants.send-bulk-email');
   Route::get('/job-applicants/{id}/download-cv', [JobApplicantController::class, 'downloadCV'])->name('job-applicants.download-cv');
   Route::put('/job-applicants/{id}/update-status', [JobApplicantController::class, 'updateStatus'])->name('job-applicants.update-status');
});



Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userdashboard'])->name('user.dashboard');
    Route::get('/my-applications', [JobApplicantController::class, 'myApplications'])->name('user.applications');
    Route::post('/apply', [JobApplicantController::class, 'store'])->name('apply.job');
});



require __DIR__.'/auth.php';
