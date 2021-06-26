<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\User;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;

class UserController extends Controller
{
    //
    /**
     * @OA\Post(
     *      path="/user/login",
     *      operationId="Login",
     *      tags={"Users"},
     *      summary="Login",
     *      description="Returns User data and token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *             @OA\Property(
     *                  property="email", 
     *                  type="email", 
     *                  example="abc@abc.com"
     *              ),
     *              @OA\Property(
     *                  property="password", 
     *                  type="password", 
     *                  example="123456"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success Operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="true"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="login valid"
     *              ),
     *              @OA\Property(
     *                  property="token", 
     *                  type="string", 
     *                  example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMGRkN2YwZjQzMTJjYTUxYjYzNjc3MGE0ZDgyMzRiZTYyZWQ1OTU4ZjdhNTNiZTI3YWNiNzQ3ZDc5ZDkxNmRjMjBjM2M2MDY0ODllY2NlMzUiLCJpYXQiOjE2MjQ3MDQ2NDcsIm5iZiI6MTYyNDcwNDY0NywiZXhwIjoxNjU2MjQwNjQ3LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.OzFWNIiEFQ71X_2Xy-rH4RuBBOkYKEbs2toTtbSuzfF8Z01jguIGd5N-TPaMGATlIAC303hUcgvRnbuGb23CfJxH5UwaNJS1Q9hGQoMBEbr91xDf0xl_FduLWAgmOKD69xOl2_1kJ-z843o8Mov3zLMq190D0XB3EviJYtuo_Llo72hp11r8QAZoLL_4xGekfj-kOVSSR8rGFapSxvoDDQNccqba59kBtOikSDj_PvMQJ-YdRhAW5RAyqr8-xl5Qz5nnlbRO6UTeoSex1Fos3LiJxKhoJpHJXuNCN3NFKaoYok0qX9LnbdUlrS6HZTuo3bCbpTVyCJTXLdhbUGUSqAYgehotvDTaWD7KI62q-55k5jUM9BH45mtZStVSabDsy2F8eIsF1AepQTVN-2NR0056bYcVdw1IuF7xdySpmJm45ptcNGel3MnqBJpKlbpqF8oQ9gYYaa3tu7d3VeN-AelQgj9bUzAArAp4bone8r7x6s_Q0NwXKnmV2HMO_3cZ_shfdRfxy1L3BSinXjaVX3AlYgDM67DYf8HrHy5sBvMjiTB-6AIrbhAjoZP0sM3c8WZipXmG87KilniDRP3wQ5CRmeD918PARwhyd24kMeLjipomvDuv6r_86N4Dwm0UMHLmOHkNxpsGYUnAgkJRsh3TTG4dwZ8eflwfugt0Pfc"
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocess",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="email kosong"
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="unauthorized"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function login(Request $request) {
        $dat = $request->json()->all();
			$validator = Validator::make($request->all(), [
				'email' => 'required|email',
				'password' => 'required'
			]);

			if($validator->fails()){
				return response()->json([
					"success" => false,
					"message" => $validator->errors()
				],422);
			}   
        
        Auth::attempt($dat);

        if (Auth::check()) {
            $user = Auth::user();
            $token =  $user->createToken('nApp')->accessToken;
            //Login Success

            return response()->json([
                "success" => true,
                "message" => "Login valid",
                "token" => $token
            ],201); 
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Unauthorized"
            ],401);
        }
    }

    /**
     * @OA\Post(
     *      path="/user/register",
     *      operationId="Register",
     *      tags={"Users"},
     *      summary="Registration",
     *      description="Returns User data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="name", 
     *                  type="string", 
     *                  example="Ani"
     *              ),
     *              @OA\Property(
     *                  property="address", 
     *                  type="string", 
     *                  example="Jalan Pramuka no 100"
     *              ),
     *              @OA\Property(
     *                  property="email", 
     *                  type="email", 
     *                  example="abc@abc.com"
     *              ),
     *              @OA\Property(
     *                  property="password", 
     *                  type="password", 
     *                  example="123456"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success Operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="true"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="Register Berhasil"
     *              ),
     *          )    
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocess",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="success", 
     *                  type="boolean", 
     *                  example="false"
     *              ),
     *              @OA\Property(
     *                  property="message", 
     *                  type="string", 
     *                  example="nama Kosong"
     *              ),
     *          )    
     *      ),
     * )
     */
    public function register(Request $request) {
        $dat = $request->json()->all();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ],422);
        }

        $user = new UserModel;
        $user->email=$dat["email"];
        $user->password=Hash::make($dat["password"]);
        $user->name=$dat["name"];
        $user->address=$dat["address"];
        $user->save();
        return response()->json([
            "success" => true,
            "message" => "User created successfully.",
            "data" => $user
        ],200);
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return response()->json([
            "success" => true,
            "message" => "logout berhasil."
        ],201);
    }
}
