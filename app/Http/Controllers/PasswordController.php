<?php

namespace App\Http\Controllers;

use Request;
use App\User;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;

class PasswordController extends Controller
{
    public function getForgotPassword ()
    {
        return view('auth/forgot_password');
    }

    public function postForgotPassword ()
    {
        $request = Request::Only('email');
        $user = User::where('email', $request['email'])->first();

        $new_password = str_random(8);

        // send email
        Mail::send('emails.password', ['user' => $user, 'new_password' => $new_password], function ($message) use ($user) {
            $message->from('hello@app.com', 'Your Application');
            $message->subject('新密碼');
            $message->to($user->email, $user->name);
        });


        if($user) {
            $data = [
                'password' => bcrypt($new_password)
            ];
            $user->update($data);
        }

        return redirect(route('login'))->with(['MESSAGE' => '新密碼已寄至信箱，請使用新密碼登入']);
    }

    public function getResetPassword ()
    {
        return view('auth/reset_password');
    }

    public function postResetPassword ()
    {
        $request = Request::Only('email','new_password');
        $user = User::where('email', $request['email'])->first();
        if($user) {
            $data = [
                'password' => bcrypt($request['new_password'])
            ];
            $user->update($data);
        }

        return redirect(route('login'))->with(['MESSAGE' => '密碼已更新，請使用新密碼登入']);
    }
}
