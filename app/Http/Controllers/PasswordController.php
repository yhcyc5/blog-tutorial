<?php

namespace App\Http\Controllers;

use Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use Auth;
use Zoe\Repositories\UserRepository;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;

class PasswordController extends Controller
{

    protected $userRepository = null;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getForgotPassword ()
    {
        return view('auth/forgot_password')
            ->with('title', '忘記密碼');
    }

    public function postForgotPassword ()
    {
        $request = Request::Only('email');

        if ($request['email'] == null) {
            return redirect(route('forgotPassword'))
                ->with(['MESSAGE' => '請輸入Email']);
        }

        $user = $this->userRepository->getByEmail($request['email']);
        $new_password = str_random(8);

        $user = $this->userRepository->passwordUpdate($user->id, $new_password);

        // send email
        Mail::send('emails.password', ['user' => $user, 'new_password' => $new_password], function ($message) use ($user) {
            $message->from('hello@app.com', 'Your Application');
            $message->subject('新密碼');
            $message->to($user->email, $user->name);
        });

        return redirect(route('login'))->with(['MESSAGE' => '新密碼已寄至信箱，請使用新密碼登入']);
    }

    public function getResetPassword ()
    {
        return view('auth/reset_password')
            ->with('title', '更改密碼');
    }

    public function postResetPassword ()
    {
        $request = Request::Only('email', 'new_password');

        if (Auth::user()->email != $request['email']) {
            return redirect(route('resetPassword'))
                ->with(['MESSAGE' => 'Email輸入錯誤！']);
        }

        $this->userRepository->passwordUpdate(Auth::user()->id, $request['new_password']);

        return redirect(route('login'))->with(['MESSAGE' => '密碼已更新，請使用新密碼登入']);
    }
}
