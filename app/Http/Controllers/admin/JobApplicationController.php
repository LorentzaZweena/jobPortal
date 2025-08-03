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

    public function destroy(Request $request){
        $id = $request->id;
        $jobApplication = JobApplication::find($id);
        if ($jobApplication == null) {
            return response()->json([
                session()->flash('error', 'Job application not found.'),
                'status' => false,
            ]);
        }
        $jobApplication->delete();
        session()->flash('success', 'Job application deleted successfully.');
        return response()->json([
            'status' => true,
        ]);
    }
}
