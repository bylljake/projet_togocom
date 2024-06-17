<?php

namespace App\Repositories;

use App\Models\Sites;
use App\Repositories\Base\BaseRepository;

/**
 * @Category of class RoleRepository
 * @Extend the Base class Repository
 */
class SitesRepository extends BaseRepository
{
    /**
     * RoleRepository constructor.
     */
    public function __construct(Sites $model)
    {
        parent::__construct($model);
    }

   
}
