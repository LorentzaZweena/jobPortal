<?php

namespace App\Http\Controllers\admin;

use App\Models\Job;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->with('user', 'applications')->paginate(5);
        return view('admin.jobs.list', [
            'jobs' => $jobs,
        ]);
    }

    public function edit($id){
        $job = Job::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        $jobTypes = JobType::orderBy('name', 'asc')->get();
        return view('admin.jobs.edit', [
            'job' => $job,
            'categories' => $categories,
            'jobTypes' => $jobTypes,
        ]);
    }

    public function update(Request $request, $id){        
    $rules = [            
        'title' => 'required|min:5|max:100',            
        'category' => 'required',            
        'jobType' => 'required',            
        'vacancy' => 'required|integer',            
        'location' => 'required|max:50',            
        'description' => 'required',            
        'company_name' => 'required|min:3|max:50',        
    ];        
    
    $validator = Validator::make($request->all(), $rules);        
    
    if($validator->passes()){            
        $job = Job::find($id);            
        $job->title = $request->title;            
        $job->category_id = $request->category;            
        $job->job_type_id = $request->jobType;            
        $job->vacancy = $request->vacancy;            
        $job->salary = $request->salary;            
        $job->location = $request->location;            
        $job->description = $request->description;            
        $job->benefit = $request->benefit;            
        $job->responsibility = $request->responsibility;            
        $job->qualifications = $request->qualifications;
        $job->keyword = $request->keyword;            
        $job->experience = $request->experience;            
        $job->company_name = $request->company_name;            
        $job->company_location = $request->company_location;            
        $job->company_website = $request->website;
        $job->save();            
        
        session()->flash('success', 'Job updated successfully.');            
        return response()->json([                
            'status' => true,                
            'errors' => []            
        ]);        
    } else {            
        return response()->json([                
            'status' => false,                
            'errors' => $validator->errors()            
        ]);        
    } 

    }
}
