<?php


namespace Insyghts\Authentication\Controllers;

use Illuminate\Http\Request;
use Insyghts\Authentication\Helpers\Helpers;
use Insyghts\Authentication\Middleware\myAuth;
use Insyghts\Authentication\Services\UserService;
use Insyghts\Common\Controllers\CommonController;

class UserController extends CommonController
{

    public function __construct(UserService $userService)
    {
        // $this->middleware(myAuth::class);
        $this->middleware(myAuth::class, ['except' => ['login' , 'addUser']]);
        $this->userService = $userService;
    }



public function login(Request $request){
    $this->validate($request, [
        'username' => 'required',
        'password' => 'required'
    ]);
    $input = $request->input();
    $result = $this->userService->login($input);

    if($result['success']){
        return response()->json($result);
    }else{
        return response()->json($result);
    }
}

public function addUser(Request $request)
{
    $this->validate($request, [
        'username' => 'required',
        'password' => 'required'
    ]);
    $input = $request->all();
    if(isset($input['username']) && isset($input['password'])){
        $result = Helpers::addUser($input['username'], $input['password']);
        return response()->json($result);
    }
}


    public function refresh()
    {
        $result = $this->userService->refreshToken();
        if($result['success']){
            return response()->json($result);
        }else{
            return response()->json($result);
        }
    }

}
