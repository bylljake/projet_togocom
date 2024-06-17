<?php

namespace App\Repositories;


use App\Repositories\Base\BaseRepository;
use Spatie\Permission\Models\Permission;


/**
 * @Category of class PermissionRepository
 * @Extend the Base class Repository
 */
class PermissionRepository extends BaseRepository
{
    /**
     * PermissionRepository constructor.
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}