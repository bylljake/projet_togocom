<?php

namespace App\Repositories;


use App\Repositories\Base\BaseRepository;
use Spatie\Permission\Models\Role;

/**
 * @Category of class RoleRepository
 * @Extend the Base class Repository
 */
class RoleRepository extends BaseRepository
{
    /**
     * RoleRepository constructor.
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Get by name in the database.
     *
     * @param string $name
     * @return objet
     */
    public function getByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }
}
