<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseRepository;


/**
 * @User of class UserRepository
 * @Extend the Base class BaseRepository
 */
class UserRepository extends BaseRepository
{
    /**
     * Repository constructor.
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
