<?php

namespace App\Http\Controllers;

use Request;
use Validator;
use Socialite;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Zoe\Repositories\UserRepository;


class AuthController extends Controller
{

    protected $userRepository = null;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getLogin()
    {
        return view('auth/login')
            ->with('title', '登入');
    }

    public function postLogin()
    {
        $request = Request::only(['name', 'password']);

        $user = $this->userRepository->getByName($request['name']);

        if ($user == null) {
            return redirect(route('login'))->with(['MESSAGE' => '此帳號不存在']);
        }

        if (!$user->status) {
            // send email
            Mail::send('emails.user_confirm', ['params' => $user], function ($message) use ($user) {
                $message->from('hello@app.com', 'Your Application');
                $message->subject('Your Verify Step!');
                $message->to($user['email'], $user['name']);
            });

            return redirect(route('login'))->with(['MESSAGE' => '驗證郵件已再次寄出']);
        }

        $login_status = Auth::attempt($request, true);

        if (!$login_status) {
            return redirect(route('login'))->with(['MESSAGE' => '帳號或密碼錯誤']);
        }

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
        $params = $request->only([
            'name', 'email', 'password', 'password_confirmation'
        ]);

        $this->userRepository->register($params);

        // send email
        Mail::send('emails.user_confirm', ['params' => $params], function ($message) use ($params) {
            $message->from('hello@app.com', 'Your Application');
            $message->subject('Your Verify Step!');
            $message->to($params['email'], $params['name']);
        });

        return redirect(route('login'))->with(['MESSAGE' => '驗證信件已寄出，驗證完成後即可登入']);
    }

    public function getUserConfirm (Request $request)
    {
        $request = Request::only(['name', 'token']);

        $confirm_status = $this->userRepository->userConfirm($request);

        if ($confirm_status) {
            return redirect(route('login'))->with(['MESSAGE' => '帳號驗證成功，馬上登入吧～']);
        } else {
            return abort(404);
        }
    }
}
