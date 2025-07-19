<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Mail\JobNotificationEmail;
use App\Http\Controllers\Controller;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::query();

        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request) {
                $query->orWhere('title', 'LIKE', '%' . $request->keyword . '%');
                $query->orWhere('keywords', 'LIKE', '%' . $request->keyword . '%');
            });
        }

        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        $jobTypeArray = [];
        if (!empty($request->job_type)) {
            $jobTypeArray = $request->job_type;
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', 'LIKE', '%' . $request->experience . '%');
        }

        $jobs = $jobs->with(['jobType', 'category']);
            if ($request->sort == 'oldest') {
                $jobs = $jobs->orderBy('created_at', 'ASC');
            } else {
                $jobs = $jobs->orderBy('created_at', 'DESC');
            }

        $jobs = $jobs->paginate(6);

        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }

    public function detail($id){
        $job = Job::where([
            'id'=> $id,
            'status' => 1
        ])->with(['jobType', 'category'])->first();

        if ($job == null) {
            abort(404);
        }
        return view('front.jobDetail', ['job' => $job]);
    }

    public function applyJob(Request $request){
    if (!Auth::check()) {
        return response()->json([
            'status' => false,
            'message' => 'You must be logged in to apply for jobs'
        ]);
    }

    $id = $request->id;
    $job = Job::where('id', $id)->first();
    
    if ($job == null) {
        return response()->json([
            'status' => false,
            'message' => 'Job not found'
        ]);
    }

    $employer_id = $job->user_id;
    if ($employer_id == Auth::user()->id) {
        return response()->json([
            'status' => false,
            'message' => 'You cannot apply for your own job'
        ]);
    }

    $jobApplicationCount = JobApplication::where([
        'job_id' => $id,
        'user_id' => Auth::user()->id
    ])->count();

    if ($jobApplicationCount > 0) {
        return response()->json([
            'status' => false,
            'message' => 'You have already applied for this job'
        ]);
    }

    $application = new JobApplication();
    $application->job_id = $id;
    $application->user_id = Auth::user()->id;
    $application->employer_id = $employer_id;
    $application->applied_date = now();
    $application->save();

    $employer = User::where('id', $employer_id)->first();
    $mailData = [
        'employer' => $employer,
        'user' => Auth::user(),
        'job' => $job
    ];
    Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

    return response()->json([
        'status' => true,
        'message' => 'Job applied successfully!'
    ]);
}

public function saveJob(Request $request){
    $id = $request->id;
    $job = Job::find($id);

    if ($job == null) {
        session()->flash('error', 'Job not found');
        return response()->json([
            'status' => false
        ]);
    }

    $count = SavedJob::where([
        'job_id' => $id,
        'user_id' => Auth::user()->id
    ])->count();

    if ($count > 0) {
        session()->flash('error', 'Job already saved');
        return response()->json([
            'status' => false
        ]);
    }

    $savedJob = new SavedJob();
    $savedJob->job_id = $id;
    $savedJob->user_id = Auth::user()->id;
    $savedJob->save();

    session()->flash('success', 'Job saved successfully');
    return response()->json([
        'status' => true
    ]);
}


}
