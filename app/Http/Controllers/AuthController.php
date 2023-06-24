<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"Auth User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="senha123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     * */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * @OA\Post(
     * path="/api/auth/register",
     * summary="Register",
     * description="register with email, password",
     * operationId="authRegister",
     * tags={"Auth User"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Register user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="name", type="string", format="email", example="test"),
     *       @OA\Property(property="email", type="string", format="email", example="test@test.com"),
     *       @OA\Property(property="password", type="string", format="password", example="senha123"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="senha123"),
     *    ),
     * ),
     * @OA\Response(
     *    response=400,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry,  Please try again")
     *        )
     *     )
     * )
     * */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
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

    /**
     * @OA\Post(
     *   path="/api/auth/logout",
     *   summary="Logout test",
     *   description="Logout user and invalidate token",
     *   operationId="authLogout",
     *   tags={"Auth User"},
     *   security={ {"bearerAuth": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="Success"
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Returns when user is not authenticated",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized")
     *     )
     *   )
     * )
     */


    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * @OA\Get(
     *   path="/api/auth/user-profile",
     *   summary="Retrieve profile information",
     *   description="Get profile short information",
     *   operationId="profileShow",
     *   tags={"Auth User"},
     *   security={ {"bearerAuth": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="Success"
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="User should be authorized to get profile information",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized")
     *     )
     *   )
     * )
     */

    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth('api')->factory()->getTTL() * 60,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }


}
