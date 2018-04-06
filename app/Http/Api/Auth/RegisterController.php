<?php

namespace App\Http\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    //
    use RegistersUsers;
    use Helpers;
    public function register(Request $request){
       $validator = $this->validator($request->all());
       if ($validator->fail()){
           throw new StoreResourceFailedException("Validation Error", $validator->errors());

       }
        $user = $this->create($request->all());
       if ($user->save()){
           $token = JWTAuth::fromUser($user);
           return $this->response->array([
               "token"=>$token,
               "message" => "User created",
               "status_code" => 201
           ]);
       }else{
           return $this->response->error(404);
       }
    }
    protected function validator(array $data){
        return Validator::make($data,[
            'username' => 'required|unique:user',
            'mobile' => 'required|email|max:255|unique:user',
            'password' => 'required|between:6,20',
        ]);
    }
    protected function create(array $data){
        return User::create([
            'username' => $data['username'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
