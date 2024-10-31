<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendCodeResetPassword;
use App\Models\PasswordReset as ModelsPasswordReset;
use App\Models\PasswordResets;
use App\Models\Profile;
use App\Models\City;
use App\Services\SaveFileService;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthAPIController extends Controller
{
    private $user;
    private $saveFileService;
    private $path = 'profile';

    public function __construct()
    {
        $this->user = auth('sanctum')->user();
        $this->saveFileService = new SaveFileService();
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $tokenSSO = @$input['token'];
        if(empty($tokenSSO)){
            return response()->json([
                'status' => false,
                'message' => 'Login failed. Please repeat again!.'
            ], 401);
        }

        $userSSO = $this->checkUserSSO($tokenSSO);
        $user = User::where('email', $userSSO['email'])->first();
        if(empty($user)){
            $newUser = User::create([
                'name' => $userSSO['name'],
                'email' => $userSSO['email'],
                'password' => Hash::make(\Str::random(40)),
                'email_verified_at' => @$userSSO['email_verified_at'],
            ]);

            Profile::create([
                'user_id' => $newUser->id,
                // 'city' => $userSSO['city'],
                'phone' => $userSSO['phone'],
                'image' => $userSSO['photo'],
                'postal_code' => $userSSO['postal_code']
            ]);
            $user = $newUser;
        }else{
            $user->update([
                'name' => $userSSO['name'],
                'email' => $userSSO['email'],
                'image' => $userSSO['photo'],
                'email_verified_at' => @$userSSO['email_verified_at'],
            ]);
            Profile::where('user_id', $user->id)->first()->update([
                // 'city' => $userSSO['city'],
                'phone' => $userSSO['phone'],
                'image' => $userSSO['photo'],
                'postal_code' => $userSSO['postal_code']
            ]);
        }
        $user->update(['token_sso' => $tokenSSO]);
        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login success',
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|regex:/^\S*$/u|unique:users,email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 500);
        }

        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user = User::where('email', $request->email)->first();

            $city = City::find($request->city);
            Profile::create([
                'user_id' => $user->id,
                'province' => @$city->province_code,
                'city' => $request->city,
                'phone' => $request->phone,
                'postal_code' => $request->postal_code,
                'dob' => $request->dob
            ]);

            $token = $user->createToken('appToken')->plainTextToken;

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'token'  => $token
            ];

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Register success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function checkUser()
    {
        $user = auth('sanctum')->user();
        $userSSO = $this->checkUserSSO($user['token_sso']);
        $profile = Profile::where('user_id', $user->id)->with('province')->with('cities')->first();
        if(!empty(@$userSSO['photo']) && ($user->image != @$userSSO['photo'])){
            $user = User::find($user->id);
            $user['image'] = @$userSSO['photo'];
            $user->save();
            $profile['image'] = @$userSSO['photo'];
            $profile->save();
        }

        $user['profile'] = $profile;

        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $user
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $profile = Profile::where('user_id', $this->user->id)->first();
        $user = User::where('id', $this->user->id)->first();
        DB::beginTransaction();
        try {
            $user->update(['name' => $request->name]);
            $city = City::find(@$request['city']);
            $profile->update([
                'dob' => $request['dob'],
                'phone' => $request['phone'],
                'province' => @$city->province_code,
                'city' => $request['city'],
                'postal_code' => $request['postal_code'],
            ]);

            $base64 = null;
            if(@$request->file('image')){
                $path = @$request->file('image')->path();
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
            $updateUserSSO = Http::withHeaders([
                'Authorization' => 'Bearer ' . $user->token_sso,
                'Accept' => 'aplication/json'
            ])->post(env('SSO_API') . 'update-profile', [
                'name' => $request['name'],
                'phone' => $request['phone'],
                'postal_code' => $request['postal_code'],
                'city' => @$city->city_name,
                'photo' => $base64,
            ]);

            $resSSO = $updateUserSSO->json();

            if (@$request->file('image') && @$resSSO['data'] && @$resSSO['data']['photo']) {
                $user->update([
                    'image' => $resSSO['data']['photo']
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Profile updated'
            ], 200);
        } catch (\Exception $e) {
            dd($e);
        }

    }

    public function updatePassword(Request $request)
    {
        $user = $this->user;
        $input = $request->all();

        DB::beginTransaction();
        try {
            if (Hash::check($input['old_password'], $this->user->password)) {
                if ($input['new_password'] == $input['confirm_password']) {
                    $user->update([
                        'password' => Hash::make($input['new_password'])
                    ]);

                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'Password updated successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Password not match'
                    ], 406);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'old password incorrect'
                ], 406);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function sentEmailResetPassword(Request $request)
    {
        $input = $request->all();
        $user = User::where('email', $input['email'])->first();
        $code = mt_rand(100000, 999999);

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'message' => 'Account not found'
            ], 404);
        }

        $cekToken = PasswordResets::where('email', $input['email'])->first();

        if (empty($cekToken)) {
            DB::beginTransaction();
            try {
                PasswordResets::create([
                    'email' => $input['email'],
                    'token' => $code
                ]);

                Mail::to($input['email'])->send(new SendCodeResetPassword($code, $user->name));

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Email sent successfully'
                ], 200);
            } catch(\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        } else if ($cekToken->created_at > now()->addMinute(5)) {
            $cekToken->delete();
            PasswordResets::create([
                'email' => $input['email'],
                'token' => $code
            ]);

            Mail::to($input['email'])->send(new SendCodeResetPassword($code, $user->name));

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Email sent successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Please check your email'
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $cekToken = PasswordResets::where('token', $request->token)->first();


        if (empty($cekToken)) {
             return response()->json([
                'status' => false,
                'message' => 'Token not found'
            ], 422);
        }

        if ($cekToken->created_at > now()->addMinutes(5)) {
            $cekToken->delete();
            return response()->json([
                'status' => false,
                'message' => 'Token expired'
            ], 422);
        }

        $user = User::where('email', $cekToken->email)->first();

        if ($request->new_password != $request->confirm_password) {
            return response()->json([
                'status' => false,
                'message' => 'Password not match'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->confirm_password)
        ]);

        $cekToken->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reset password successfully'
        ], 200);
    }

    private function checkUserSSO($tokenSSO){
        $url = env('SSO_API') . 'user';
        $userSSO = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tokenSSO,
            'Accept' => 'aplication/json'
        ])->get($url);
        return $userSSO->json();
    }
}
