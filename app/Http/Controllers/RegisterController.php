<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller {

 
    public function register(Request $request)
    {
        //Validate requested data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $response['token'] =  $user->createToken('laraRestApi')->accessToken;
        $response['name'] =  $user->name;
        $response['success'] = true;
        $response['message'] = "User registered successfully.";
        return $response;
    }


    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
       
 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('TutsForWeb')->accessToken;
            return response()->json(['token' => $token,'email'=>$user->email,'name'=>$user->name], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    public function details() {
        return response()->json(['user' => auth()->user()], 200);
    }

   

}