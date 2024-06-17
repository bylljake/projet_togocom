<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Contact;
use App\Models\Dish;
use App\Models\Order;
use App\Models\User;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    protected $userRepository;

    /**
    * UserService constructor.
    * @param UserRepository $userRepository
    */
   public function __construct(UserRepository $userRepository)
   {
       $this->userRepository = $userRepository;
       $this->middleware('auth:api', ['except' => ['login', 'register']]);
   }

    #endregion

    /* Get a JWT via given credentials.
    *
    * @return a logged user JsonResponse
    */
    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            Helper::sendError('Email ou mot de passe invalide!');
        }

        // send response
        return (new UserResource($token, $this->userRepository))
            ->response()
            ->withCookie(
                'token',
                auth()->getToken()->get(),
                config('jwt.ttl')
            );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $cookie = Cookie::forget('token');
        auth()->logout();

        return response()
            ->json([
                'status' => '200',
                'message' => 'Vous êtes déconnecté avec succès.'
                ])
            ->withCookie($cookie);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return UserResource::createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

   
}
