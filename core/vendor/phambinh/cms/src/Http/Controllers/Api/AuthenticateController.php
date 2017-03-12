<?php 

namespace Phambinh\Cms\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;
use ApiController;

class AuthenticateController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('jwt.auth', ['except' => [
            'authenticate',
            'check'
        ]]);
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
    }

    /**
     * Đăng nhập
     * @param  Request $request
     * @return string
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            Auth::attempt($credentials);
            $user = Auth::user();
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token', 'user'));
    }


    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    /**
     * Kiểm tra đã đăng nhập hay chưa
     * @return [type] [description]
     */
    public function check()
    {
        if (\Auth::check()) {
            return response()->json([
                'authenticate'  =>  '1',
                'user_data' => array_merge(\Auth::user()->toArray(), [
                    'full_name' => \Auth::user()->full_name,
                ]),
            ]);
        }

        return response()->json([
            'authenticate'  =>  '0',
            'user_data' => [],
        ]);
    }
}
