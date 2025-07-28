<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'ASC')->paginate(5);
        return view('admin.users.list', [
            'users' => $users   
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            // 'email' => 'email|unique:users,email, '.$id.', id',
        ]);

        if($validator->passes()){
            $user = User::find($id);
            $user->name = $request->name;
            // $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;

            if ($request->password) {
                $validatorPassword = Validator::make($request->all(), [
                    'password' => 'required|min:5|same:confirm_password',
                    'confirm_password' => 'required',
                ]);

                if ($validatorPassword->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validatorPassword->errors()
                    ]);
                }

                $user->password = Hash::make($request->password);
            }

            $user->save();

            session()->flash('success', 'User updated successfully.');

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

    public function destroy(Request $request){
        $id = $request->id;
        $user = User::find($id);

        if ($user == null) {
            session()->flash('error', 'User not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
