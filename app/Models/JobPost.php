<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'salary_range',
        'description',
        'applied_before',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($job) {
            // Check if job is past deadline
            if ($job->applied_before < now() && $job->status === 'active') {
                $job->status = 'expired';
            }
        });
    }
}
