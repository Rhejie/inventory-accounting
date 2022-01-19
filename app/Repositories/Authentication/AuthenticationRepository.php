<?php

namespace App\Repositories\Authentication;

use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class AuthenticationRepository extends Repository
{
    private $auth ;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getUserProfile()
    {

        $user = $this->auth()->user;

        return $user;

    }
}
