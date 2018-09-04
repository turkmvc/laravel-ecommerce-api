<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;

class AuthController extends Controller
{
    /**
     * API Auth Controller
     */
    private $client;

    /**
     * When constructing the application, instance a valid client instance for users auth
     */
    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where([
            ['password_client', true],
            ['revoked', false]
        ])->orderByDesc('created_at')->first();
    }

    // The register method
    public function register(Request $request){

        $validate  = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);
        
        if($validate->fails()){
            return response()->json(["errors" => $validate->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(compact('user'), 201);
    }

    // The Login Method
    public function login(Request $request){

        // Valida a requisição
        $validate = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ]);

        // Monta o request para o endpoint
        $data = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->email,
            'password' => $request->password
        ];

        // Send the request for the oauth Endpoint with user data and client data
        $req = Request::create('/oauth/token', 'POST', $data);
        
        // Simulate a request from the end user app, but is just a internal redirect for security issues
        return app()->handle($req);
    }

    // The RefreshToken 
    public function refreshToken(Request $request){
       
        // Valida a requisição
        $validate = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ]);

        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret
        ]);

        $proxy = Request::create([
            'oauth/token',
            'POST'
        ]);
            
        return Route::dispatch($proxy);
    }

    public function logout(Request $request){
        $accessToken = auth()->user()->token();

        $refreshToken = DB::table('oauth_refresh_tokens')
                        ->where('access_token_id', $accessToken->id)
                        ->update([
                            'revoked' => true
                        ]);

        $accessToken->revoke();
        
        return response()->json([], 200);
    }

}
