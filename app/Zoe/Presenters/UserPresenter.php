<?php
declare(strict_types=1);

namespace HiSKIO\Presenters;

use HiSKIO\PresenterModel;

class UserPresenter extends PresenterModel
{
    public function getAvatar()
    {
        $avatar = $this->avatar;

        if (starts_with($avatar, 'https://') || starts_with($avatar, 'http://')) {
            return $avatar;
        }

//        if (!empty($avatar) || !is_null($avatar)) {
//            return asset($avatar);
//        }

        return asset('images/user.png');
    }

    public function getUserName()
    {
        return $this->name;
    }

    public function getVerityTokenURL()
    {
        return route('auth.get.verity', [
            'email' => $this->email,
            'token' => $this->confirm_token
        ]);
    }

    public function getForgotPasswordURL()
    {
        return route('auth.get.reset_password', [
            'email' => $this->email,
            'token' => $this->forgot_token
        ]);
    }
}