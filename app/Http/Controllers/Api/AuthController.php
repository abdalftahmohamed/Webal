<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }



    public function update(UserRequest $request){

        $user = User::findOrFail($request->id);
        if ($user){
            if ($user->type == null){

                $data['name']  =$request->name ? $request->name : $user->name;
                $data['email'] = $request->email ? $request->email : $user->email;
                $data['password'] = $request->password ? $request->password : $user->password;
                $data['country_id'] = $request->country_id ? $request->country_id : $user->country_id;
                $data['city_id'] = $request->city_id ? $request->country_id : $user->city_id;
                $data['type'] = $request->type ? $request->type : $user->type;


                $user->update($data);
                return response()->json([
//            'status'=>true,
                    $user
//            'message' => 'User Updated Successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => 'This is Admin not updated',
                ],422);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'this id not found please try again',
            ],404);
        }

    }


    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }



    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }



    public function userProfile() {
//        dd('hghhh');
        return response()->json(auth()->user());
    }


    public function allusers() {

        $users=User::all();
        return response()->json($users);

    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }



    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        if ($user){
            if ($user->type == null){

                $user->delete();
                return response()->json([
                    'status'=>true,
                    'message' => 'User deleted Successfully',
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => 'This is Admin not deleted',
                ],422);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'this id not found please try again',
            ],404);
        }
    }



}

