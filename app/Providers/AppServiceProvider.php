<?php

namespace App\Providers;
use App\Repositories\JobPostRepositoryInterface;
use App\Repositories\JobPostRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\JobApplicantRepository;
use App\Repositories\JobApplicantRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(JobPostRepositoryInterface::class, JobPostRepository::class);
        $this->app->bind(JobApplicantRepositoryInterface::class, JobApplicantRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
