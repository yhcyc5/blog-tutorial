<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;

use Socialite;

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

    public function postRegister()
    {
        $input = Input::all();

        // 重複?
        $new = User::where('name', $input['name'])->first();
        if($new) {
            return redirect(route('login'))->with(['MESSAGE' => '此帳號已被註冊']);
        }
        $new = User::where('email', $input['email'])->first();
        if($new) {
            return redirect(route('login'))->with(['MESSAGE' => '此信箱已存在帳號']);
        }

        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
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
