<?php

namespace Mmo7amed2010\Apiauth;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

trait ApiauthTrait
{

    public static function routes()
    {
        Route::post('/login/token', self::loginByToken());
        Route::middleware('auth:api')->post('/logout', self::logout());
        Route::post('/refresh', self::refresh());
        Route::post('/register', self::register());
        Route::middleware('auth:api')->get('/user', self::user());

    }
    public static function user(){
        return function (Request $request) {
            return $request->user();
        };
    }
    public static function register(){
        return function (Request $request) {

            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'fcm' => ['required'],
                'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ])->validate();

            $password = request()->password;
            request()->merge(["password" => bcrypt(request()->password)]);
//    $all = General::FileStore(["avatar"], $request, "User");
            $all = request()->all();
            $ModelObj = User::create($all);
            $response = Http::asForm()->post(url("oauth/token"), [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_GRANT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_GRANT_CLIENT_SECRET'),
                'username' => request()->email,
                'password' => $password,
                'scope' => '',
            ]);
            $user = User::where('email', $request->email)->first();

            return response(['user' => $user, 'token_data' => $response->json()]);


        };
    }
    public static function refresh(){
        return function (Request $request) {

            $response = Http::asForm()->post(url('/oauth/token'), [
                'grant_type' => 'refresh_token',
                'refresh_token' => request()->refresh_token,
                'client_id' => env('PASSPORT_GRANT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_GRANT_CLIENT_SECRET'),
                'scope' => '',
            ]);
            return $response->json();

        };
    }
    public static function logout(){
        return function (Request $request) {
            $user = User::find($request->user()->id);
            $user->tokens()->delete();
            $user->fcm = null;
            $user->save();
        };
    }
    public static function loginByToken(){
        return function (Request $request) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            $user->tokens()->delete();
            $response = Http::asForm()->post(url('/oauth/token'), [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_GRANT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_GRANT_CLIENT_SECRET'),
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',

            ]);

            return $response->json();
        };
    }
}
