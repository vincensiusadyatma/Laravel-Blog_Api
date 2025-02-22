<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    public function redirectToSupabase(){
        $supabaseUrl = env('SUPABASE_URL') . '/auth/v1/authorize';
    
        $query = http_build_query([
            'provider' => 'google',
            'redirect_to' => url('/auth/authenticate')
        ]);
    
        return redirect()->away("$supabaseUrl?$query");
    }


    public function handleSupabaseCallback(Request $request){
        $data = $request->all();

       

        if (!isset($data['access_token'])) {
            
            return response()->json(['error' => 'Token not found.'], 400);

        } else {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$data['access_token']}", 
                'apikey' => env('SUPABASE_ANON_KEY'),
            ])->get(env('SUPABASE_URL') . '/auth/v1/user');
        
            if ($response->failed()) {
                return response()->json(['error' => 'Gagal mendapatkan data pengguna.'], 400);
            } else {
                // dd($response->json()["user_metadata"]);
                $user_data = $response->json()["user_metadata"];
                
                DB::beginTransaction();
        
                try {
                    // Cari user berdasarkan email
                    $user = User::where('email', $user_data["email"])->first();
                
                    if (!$user) {
                        $user = User::create([
                            'user_uuid' => Str::uuid(), 
                            'username' => $user_data["name"],
                            'fullname' => $user_data["full_name"],
                            'email' => $user_data["email"],
                            'status' => true,
                            'last_sign_in' =>$response->json()["last_sign_in_at"]
                        ]);
                    } else {
                        $user->update([
                            'username' => $user_data["name"],
                            'fullname' => $user_data["full_name"],
                        ]);
                    }
                
                    Auth::login($user);
                    DB::commit();
        
                    return response()->json([
                        'status' => 200,
                        'message' => 'Login successful',
                        'user' => $user,
                    ], 200);

                } catch (\Throwable $th) {
                    DB::rollBack();
                    dd($th);
                    return response()->json([
                        'status' => 500,
                        'message' => 'Error',
                    ], 500);
                }

            }
        
           

        }
       
        
        
    }

        // Debug response
        // return response()->json($response->json());
    
    

   

    

}
