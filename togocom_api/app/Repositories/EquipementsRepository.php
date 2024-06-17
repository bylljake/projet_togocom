<?php

namespace App\Repositories;


use App\Repositories\Base\BaseRepository;
use App\Models\Equipements;

/**
 * @Category of class EquipementsRepository
 * @Extend the Base class Repository
 */
class EquipementsRepository extends BaseRepository
{
    /**
     * EquipementsRepository constructor.
     */
    public function __construct(Equipements $model)
    {
        parent::__construct($model);
    }
}
