<?php
namespace App\Repositories;

use App\Repositories\Repository;
use App\User;

class UserRepository extends Repository{
    function __construct(User $user){
        parent::__construct($user);
    }
}