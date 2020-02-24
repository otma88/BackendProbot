<?php
namespace App\Http\Controllers\Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{


    /**
     * @OA\Post(path="/api/auth/login",
     *   tags={"Login"},
     *   summary="Login user into mobile application",
     *   description="Probot app login",
     *   operationId="login",
     *   @OA\Parameter(
     *     name="email",
     *     required=true,
     *     in="query",
     *     description="User email for login",
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="The password for user login",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(response=400, description="Invalid username/password supplied")
     * )
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            //'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }



    /**
     * @OA\Post(path="/api/auth/register",
     *   tags={"register"},
     *   summary="Create user for mobile app",
     *   description="Register user for mobile app",
     *   operationId="createUser",
     *    @OA\Parameter(
     *     name="name",
     *     required=true,
     *     in="query",
     *     description="Username for register",
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="email",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="The email for register user",
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     required=true,
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="The password for register user",
     *   ),
     *   @OA\Response(response="default", description="successful operation")
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }


    /**
     * @OA\Get(path="/api/auth/logout",
     *   tags={"Logout"},
     *   summary="Logout user from mobile application",
     *   description="Probot app logout",
     *   operationId="logout",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *     @OA\Schema(type="string"),
     *   ),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
