<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    //ini adalah controller untuk mengatur akun pengguna
    public function register()
    {
       return view('front.account.register');
    }

    //ini adalah fungsi untuk memproses register pengguna
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'Registration successful. You can now login.');
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

    public function login()
    {
       return view('front.account.login');
    }

    //ini adalah fungsi untuk memproses login pengguna
    public function authenticate(Request $request){
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if($validator->passes()){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('login')->with('error', 'Email or password is incorrect.');
        }
    } else {
        return redirect()->route('login')
        ->withErrors($validator)
        ->withInput($request->only('email'));
    }
}


    public function profile(){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request){
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email, '.$id.', id',
        ]);

        if($validator->passes()){
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'Profile updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

            if ($request->password) {
                $validatorPassword = Validator::make($request->all(), [
                    'password' => 'required|min:5|same:confirm_password',
                    'confirm_password' => 'required',
                ]);

                if ($validatorPassword->passes()) {
                    $user->password = Hash::make($request->password);
                } else {
                    return response()->json([
                        'status' => false,
                        'errors' => $validatorPassword->errors()
                    ]);
                }
            }

            $user->save();

            session()->flash('success', 'Profile updated successfully.');
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

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfilePicture(Request $request)
    {
        // dd($request->all());
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->passes()) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = $id. '-' . time() . '.' . $ext;
            $image->move(public_path('/profile_pic'), $imageName);

            // Resize the image using Intervention Image
            $sourcePath = public_path('/profile_pic/' . $imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);

            $image->cover(150, 150);
            $image->toPng()->save(public_path('/profile_pic/thumb/' . $imageName));

            //delete the old image if exists
            File::delete(public_path('/profile_pic/thumb/' . Auth::user()->image));
            File::delete(public_path('/profile_pic/' . Auth::user()->image));

            User::where('id', $id)->update(['image' => $imageName]);
            session()->flash('success', 'Profile picture updated successfully.');
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

    public function createJob()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create', [
            'categories' => $categories,
            'jobTypes' => $jobTypes
        ]);
    }

    public function saveJob(Request $request){        
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
        $job = new Job();            
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
        $job->user_id = Auth::user()->id;
        $job->save();            
        
        session()->flash('success', 'Job created successfully.');            
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

    public function myJobs()
    {
        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->paginate(2);
        return view('front.account.job.my-jobs', [
            'jobs' => $jobs
        ]);
    }
}
