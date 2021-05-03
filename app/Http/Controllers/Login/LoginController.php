<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function loginGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback(){
        $user = Socialite::driver('google')->user();



        if(!empty($user->email)){
            $u = User::where('email',$user->email)->first();
            if(!$u){
                $u = new User();
                $u->is_google_login = 1;
                $u->google_token = $user->token;
                $u->name = $user->name;
                $u->email = $user->email;
                $u->password = Hash::make(rand(1111,9999).$user->email.rand(1111,2222));
                if(strpos($user->email,'@spiderworks.in') !== false){
                    $u->is_admin = 1;
                }
                $u->save();
            }

            if (Auth::loginUsingId($u->id)) {
                $u->is_google_login = 1+$u->google_login;
                $u->google_token = $user->token;
                $u->save();
                if($u->is_admin ==1){
                    return redirect('admin/dashboard');
                }else{
                    return redirect('/');
                }
            }
        }
        session()->flash('error','Google login failed, please try other options');
        return redirect('login');
    }

    public function login(Request $request){

        // email and token needs to pass here
        try{
            // $user = file_get_contents('https://www.googleapis.com/oauth2/v3/userinfo?access_token='.$request->token);

            $client = new \Google_Client(['client_id' => $request->client_id]);  // Specify the CLIENT_ID of the app that accesses the backend
            $payload = $client->verifyIdToken($request->id_token);
            if ($payload) {
                $userid = $payload['sub'];

                if(!empty($payload['email'])){

                    $u = User::where('email',$payload['email'])->first();
                    if(!$u){
                        $u = new User();
                        $u->is_google_login = 1;
                        $u->google_token = $request->id_token;
                        $u->name = $payload['name'];
                        $u->email = $payload['email'];
                        $u->password = Hash::make(rand(1111,9999).rand(1111,2222));
                        if(strpos($payload['email'],'@spiderworks.in') !== false){
                            $u->is_admin = 1;
                        }
                        $u->save();
                    }

                    $token = $u->createToken('user-token')->plainTextToken;

                    $response = [
                        'status' => true,
                        'token' => $token,
                        'user' => $u
                    ];

                }else{
                    $response = [
                        'status' => false,
                        'token' => 'Invalid token, Failed to fetch user details'
                    ];
                }


            } else {
                dd($payload);
                $response = [
                    'status' => false,
                    'token' => 'Invalid token, Failed to fetch user details'
                ];
            }


        }catch(\Exception $e){
            $response = [
                'status' => false,
                'token' => 'Invalid token, Failed to fetch user details'
            ];
            return response($response, 403);
        }



        return response($response, 200);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
