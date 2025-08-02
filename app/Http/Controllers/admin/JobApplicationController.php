<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Http\Controllers\Controller;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::orderBy('created_at', 'ASC')
                        ->with('job', 'user', 'employer')
                        ->paginate(5);
        return view ('admin.job-applications.list', [
            'applications' => $applications
        ]);
    }
}
