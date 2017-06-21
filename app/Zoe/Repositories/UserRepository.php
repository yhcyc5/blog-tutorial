<?php

namespace Zoe\Repositories;

use Zoe\EloquentRepository;
use App\User;

class UserRepository extends EloquentRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getByName($user_name)
    {
        return User::where('name', $user_name)->first();
    }

    public function getByEmail($user_email)
    {
        return User::where('email', $user_email)->first();
    }

    public function register($params)
    {
        $user = $this->model->create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Bcrypt($params['password']),
            'confirm_token' => str_random(40),
        ]);

        return $user;
    }

    public function userConfirm($params)
    {
        $user = User::where('name', $params['name'])->where('confirm_token', $params['token'])->first();

        if ($user == null) {
            return true;
        }

        $data = [
            'confirm_token' => null,
            'status' => true,
        ];
        $user->update($data);

        return false;
    }

    public function passwordUpdate($user_id, $new_password)
    {
        $user = $this->getById($user_id);

        $data = [
            'password' => bcrypt($new_password)
        ];
        $user->update($data);

        return $user;
    }


}