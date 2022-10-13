<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use DateTime;
use Auth;
use DB;
use Mail;
use Validator;
use App\Http\Requests;
use App\Repositories\UsersRepository;
use Illuminate\Auth\Passwords\PasswordBroker;
use App\Http\Controllers\AppBaseController as Controller;

use App\Models\Users;
use App\Models\UsersDetail;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password'), 'role' => request('role')])) {
            $api_token = bcrypt(request('email') . time());

            Users::where('email', request('email'))
                ->update([
                    'api_token' => $api_token
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Masukkan email dan password',
                // 'data' => auth(),
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Masukkan email dan password',
                'data' => '',
            ], 422);
        }
    }

    public function register()
    {
        $UsersExist = Users::where('email', request('email'))->first();
        if ($UsersExist) {
            return $this->sendError('Email sudah digunakan', 422);
        }

        $api_token = bcrypt(request('email') . time());

        $Users = Users::create([
            'api_token' => $api_token,
            'email' => request('email'),
            'role' => 'Users',
            'password' => bcrypt(request('password'))
        ]);

        UsersDetail::create([
            'Users_id' => $Users->id,
            'notelp' => request('notelp'),
            'full_name' => request('full_name'),
            'alamat' => request('alamat'),
            'kota_id' => request('kota_id'),
            'umur' => request('umur'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Users berhasil terdaftar',
            'data' => '',
        ], 200);
    }
}
