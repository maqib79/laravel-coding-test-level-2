<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */

    public function index()
    {
        $user = User::all();
        return response()->json(['users' => $user], $this->successStatus);
    }

    public function details($id)
    {
        $user = User::find($id);
        if ($user) {

            return response()->json(['user' => $user], $this->successStatus);
        } else {
            return response()->json(['message' => "No user found"], 401);
        }
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['message' => 'Unauthorised'], 401);
        }
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        return response()->json(['success' => $success, "User Registered"], $this->successStatus);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::find($id);
        if ($user) {

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user->update($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return response()->json(['success' => $success, 'message'=> "User Updated"], $this->successStatus);
        } else {
            return response()->json(['message' => "No user found"], 401);
        }
    }

    public function delete($id){
        User::where('id',$id)->delete();
        return response()->json([ 'message'=> "User Deleted"], $this->successStatus);

    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
}
