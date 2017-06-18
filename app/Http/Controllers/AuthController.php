<?php

namespace App\Http\Controllers;

use Request;
use Validator;
use Socialite;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;


class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth/login')
            ->with('title', '登入');
    }

    public function postLogin()
    {
        $request = Request::only(['name', 'password']);

        // 帳號是否啟用
        $login = User::where('name', $request['name'])->first();
        if ($login) {
            if (!$login->status) {
                return redirect(route('login'))->with(['MESSAGE' => '此帳號尚未郵件驗證']);
            }
        }

        // 驗證
        $status = Auth::attempt($request, true);
        //return view('test')->with(['test' => $status ]);

        // 密碼錯誤
        if (!$status) {
            return redirect(route('login'))->with(['MESSAGE' => '帳號或密碼錯誤']);
        }

        // 登入
        $user = User::where('name', $request['name'])->first();
        return redirect(route('blog', ['id' => $user->id]));
    }

    public function getLogout()
    {
        if (Auth::check()) {
            Auth::user()->update([
                'login_session' => null,
                'login_time' => date('Y-m-d H:i:s')
            ]);
            Auth::logout();
        }

        return redirect(route('home'));
    }

    public function getRegister()
    {
        return view('auth/register')
            ->with('title', '註冊');
    }

    public function postRegister(RegisterRequest $request)
    {
        /*
        $validator = Validator::make($input, [
            'name' => 'required|unique:users|min:3',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect(route('register'))
                ->withErrors($validator, 'register')
                ->withInput();
        }
        */


        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->password_verify = $request['password_verify'];
        $user->confirmed_code = str_random(40);


        // send email
        Mail::send('emails.user_confirm', ['user' => $user], function ($message) use ($user) {
            $message->from('hello@app.com', 'Your Application');
            $message->subject('Your Verify Step!');
            $message->to($user->email, $user->name);
        });

        User::create([
            'name' => $user->name,
            'email'    => $user->email,
            'password' => bcrypt($user->password),
            'confirmed_code' => $user->confirmed_code
        ]);

        return redirect(route('login'))->with(['MESSAGE' => '驗證信件已寄出，驗證完成後即可登入']);
    }

    public function getUserConfirm ()
    {
        $request = Request::only(['name', 'token']);

        $user = User::where('name', $request['name'])->where('confirmed_code', $request['token'])->first();

        if ($user) {
            $data = [
                'confirmed_code' => null,
                'status' => true,
            ];
            $user->update($data);
            return redirect(route('login'))->with(['MESSAGE' => '帳號驗證成功，馬上登入吧～']);
        }
        return abort(404);
    }


}
