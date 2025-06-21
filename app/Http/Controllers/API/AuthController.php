<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteToken;
use App\Mail\resetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Pest\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class AuthController extends BaseController
{
    public function register(Request $request){
        $validateUser = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:4'
            ]
        );

        if($validateUser->fails()){
            return $this->sendError('Validation Error',$validateUser->errors()->all(),401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return $this->sendResponse('User Created successfuly',$user);

    }

    public function login(Request $request){
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if($validateUser->fails()){
            return $this->sendError('Validation Error',$validateUser->errors()->all(),404);
        }

        if(Auth::attempt(['email'=> $request->email , 'password'=> $request->password])){
            $authUser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'User Logged in Successfully',
                'token' => $authUser->createToken("API Token")->plainTextToken,
                'token_type' => 'bearer'
            ]);
        }
        else{
            return $this->sendError('Invalid Email or Password',401);

        }

        
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();

        return $this->sendResponse('User Logged Out successfully');
        
    }

    public function profile(Request $request){
       
        $user = $request->user();
        
        return $this->sendResponse('Here is the user Data',$user);
    }

    public function updatePassword(Request $request){
        $validateUser = Validator($request->all(),[
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password'
        ]);

        if($validateUser->fails()){
            return $this->sendError("Validation Error",$validateUser->errors()->all(),404);
        }

        $user = User::find($request->user()->id);
        $user->password = $request->password;
        if($user->save()){
            return $this->sendResponse("Password Updated successfully");
        }
    }

    public function forgotPassword(Request $request){
        $validateUser = Validator($request->all(),[
            'email' =>'required|email|exists:users,email'
        ]);

        if($validateUser->fails()){
            return $this->sendError("Validation Error",$validateUser->errors()->all(),404);
        }

        $tokenExists = DB::table('password_reset_tokens')->where('email',$request->email)->first();
        if($tokenExists){
            return $this->sendResponse("Reset link has already sent to your email. Please wait or try again after 5 minutes");
        }
        $token = Str::random(16);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($request->email)->send(new resetPassword());
        dispatch(new DeleteToken($request->email))->delay(now()->addMinutes(5));
        return $this->sendResponse("Reset Password Mail has sent to your Email");
    }

    public function resetPassword(Request $request){
        $validateUser = Validator($request->all(),[
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password'
        ]);

        if($validateUser->fails()){
            return $this->sendError("Validation Error",$validateUser->errors()->all(),404);
        }

        $tokenExists = DB::table('password_reset_tokens')->where('email',$request->email)->exists();
        if($tokenExists){
        DB::table('users')->where("email",$request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where('email',$request->email)->delete();
        return $this->sendResponse("Password reseted successfully");   
    }

    return $this->sendError("You are unauthorized");
    }

    public function deleteAccount(Request $request){
        User::where('id',$request->user()->id)->delete();
        return $this->sendResponse("Account Deleted Successfully");
    }

    public function changeUsername(Request $request){
        $validateUser = Validator($request->all(),[
            'name' => 'required|min:3'
        ]);

        if($validateUser->fails()){
            return $this->sendError("Validation Error",$validateUser->errors()->all(),404);
        }
        User::where('id',$request->user()->id)->update(['name' => $request->name]);
        return $this->sendResponse("Name update successfully");
    }




}
