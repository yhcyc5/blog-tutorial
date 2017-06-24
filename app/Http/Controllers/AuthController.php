<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Socialite;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Zoe\Repositories\UserRepository;
use Zoe\Services\MailService;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{

    protected $userRepository = null;
    protected $mailService = null;

    public function __construct(
        UserRepository $userRepository,
        MailService $mailService
    ) {
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }

    public function getLogin()
    {
        return view('auth/login')
            ->with('title', '登入');
    }

    public function postLogin(Request $request)
    {
        $request = $request->only(['name', 'password']);

        $user = $this->userRepository->getByName($request['name']);


        if ($user == null) {
            return redirect(route('login'))->with(['MESSAGE' => '此帳號不存在']);
        }

        if (!$user->status) {
            /* send email
            Mail::send('emails.register', ['params' => $user], function ($message) use ($user) {
                $message->from('hello@app.com', 'Your Application');
                $message->subject('Your Verify Step!');
                $message->to($user['email'], $user['name']);
            });
            */
            $this->mailService->sendRegisterConfirmEmail($user);

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

        $user = $this->userRepository->register($params);

        $this->mailService->sendRegisterConfirmEmail($user);

        return redirect(route('login'))->with(['MESSAGE' => '驗證信件已寄出，驗證完成後即可登入']);
    }

    public function getUserConfirm (Request $request)
    {
        $request = $request->only(['name', 'token']);

        $confirm_status = $this->userRepository->userConfirm($request);

        if ($confirm_status) {
            return redirect(route('login'))->with(['MESSAGE' => '帳號驗證成功，馬上登入吧～']);
        } else {
            return abort(404);
        }
    }

    public function getForgotPassword ()
    {
        return view('auth/forgot_password')
            ->with('title', '忘記密碼');
    }

    public function postForgotPassword (Request $request)
    {
        $request = $request->only('email');

        if ($request['email'] == null) {
            return redirect(route('forgotPassword'))
                ->with(['MESSAGE' => '請輸入Email']);
        }

        $user = $this->userRepository->getByEmail($request['email']);
        $new_password = str_random(8);

        $user = $this->userRepository->passwordUpdate($user->id, $new_password);

        $this->mailService->sendForgotPasswordEmail($user);

        return redirect(route('login'))->with(['MESSAGE' => '新密碼已寄至信箱，請使用新密碼登入']);
    }

    public function getResetPassword ()
    {
        return view('auth/reset_password')
            ->with('title', '更改密碼');
    }

    public function postResetPassword (Request $request)
    {
        $request = $request->only(['email', 'new_password']);

        if (Auth::user()->email != $request['email']) {
            return redirect(route('reset-password'))
                ->with(['MESSAGE' => 'Email輸入錯誤！']);
        }

        $this->userRepository->passwordUpdate(Auth::user()->id, $request['new_password']);

        return redirect(route('login'))->with(['MESSAGE' => '密碼已更新，請使用新密碼登入']);
    }
}
