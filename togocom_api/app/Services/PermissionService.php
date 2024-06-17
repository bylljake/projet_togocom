<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Resources\V1\Role\PermissionResource;
use App\Repositories\PermissionRepository;
use Exception;

/**
 * @Category class
 * @Member of PermissionService
 */
class PermissionService
{
     #regin Declarations
     private $permissionRepository;
     #endregion

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    #region Get all roles
    public function getAllPermissions()
    {
        return $this->permissionRepository->all();
    }
    #endregion

    #region Find permission
    /**
     * Get permission by given the id.
     *
     * @param $id
     * @return the Permission
     */
    public function findPermissionById($id)
    {
        try {
            $permission = ['status' => 200];
            $permission['data'] = $this->findById($id);
            if (is_null($permission['data']))
            {
                return response()->json(['message' => 'Cette identification '. $id." n'existe pas"], 404);
            }
        } catch (Exception $e) {
            throw new ApiException('Valeur introuvable: '.$e->getMessage(), 500);
        }
        $data = new PermissionResource($permission['data']);

        return response()->json($data, $permission['status']);
    }
    #endregion

    private function findById($id)
    {
        return $this->permissionRepository->find($id);
    }
    #endregion
}
