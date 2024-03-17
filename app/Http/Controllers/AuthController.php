<?php

namespace App\Http\Controllers;

use App\Models\User;
 use App\Traits\HttpResponses;
   use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    use HttpResponses;

    public function login (LoginUserRequest $request){

        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email','password']))){
            return $this->error([],'credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success(
            [
                'user'=> $user ,
                'token'=> $user->createToken('API token for ' . $user->name)->plainTextToken
            ]
        );


     }


    public function register( StoreUserRequest $request){

        $request->Validated($request->all());

        $user = User::create([
            'name'=> $request->name ,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        return$this->success([
            'user'=> $user ,
            'token'=> $user->createToken('API token of' . $user->name)->plainTextToken
        ],'registration done succesfully', 201 );

    }
    public function logout(){

        return response()->json([
            'this is logout method'
        ]);
    }

}
