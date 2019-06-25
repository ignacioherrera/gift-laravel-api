<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Traits\UploadTrait;

class AuthController extends Controller{
    use UploadTrait;
    public $successStatus = 200;
    public function register(Request $request){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'birth_date' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password', 
        ]);   
        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);             
        }    
        $input = $request->all();  
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input); 
        $token =  $user->createToken('AppName')->accessToken;
        return response()->json(['success'=>$token], $this->successStatus);            
    }
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
           $user = Auth::user(); 
           $token =  $user->createToken('AppName')-> accessToken; 
            return response()->json(['success' => $token], $this->successStatus); 
          } else{ 
           return response()->json(['error'=>'Unauthorised'], 401); 
           } 
        }   
    public function getUser() {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus); 
    }
    
    public function updateProfile(Request $request)
    {
        // Form validation

        // Get current user
        $user = Auth::user();

        // Check if a profile image has been uploaded
        if ($request->has('image')) {
            $request->validate([
                'image'     =>  'required|image|mimes:jpeg,png,jpg,gif'
            ]);
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = str_slug($request->input('name')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $user->avatar = $filePath;
            $user->save();

            return response()->json(['success' => $user], 200); 
        }
        // Persist user record to database
        return response()->json(['error' => $user], 400); 
    }







}
