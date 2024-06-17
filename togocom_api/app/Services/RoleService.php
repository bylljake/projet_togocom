<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Resources\V1\Role\RoleResource;
use App\Repositories\RoleRepository;



/**
 * @Category class
 * @Member of Roleervice
 */
class RoleService
{
    #regin Declarations
    private $roleRepository;
    #endregion

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    #region Get all roles
    public function getAllRoles()
    {
        return $this->roleRepository->all();
    }
    #endregion

    #region Find role
    /**
     * Get role by given the id.
     *
     * @param $id
     * @return the Role
     */
    public function getRoleById($id)
    {
        try {
            $role = ['status' => 200];
            $role['data'] = $this->findById($id);
            if (is_null($role['data']))
            {
                return response()->json(['message' => 'Cette identification '. $id." n'existe pas"], 404);
            }
        } catch (Exception $e) {
            throw new ApiException('Valeur introuvable: '.$e->getMessage(), 500);
        }
        $data = new RoleResource($role['data']);

        return response()->json($data, $role['status']);
    }
    #endregion

    #region Update role
    /**
     * Update the role for the giving $id.
     * @param array $attributes
     * @param $id
     * @return the updated role.
     */
    public function updateRole(array $attributes, $id)
    {
        $data = ['status' => 200, "message" => "Rôle mis à jour avec succès."];
        try {
            $role = $this->findById($id);
            if (is_null($role)) {
                return response()->json(['message' => 'Cette identification ' . $id . ' n\'existe pas', 'status' => 404]);
            }
            $role->name = $attributes['name'];

            $this->roleRepository->update($attributes, $id);

            $data['result'] = $attributes;
        } catch (Exception $e) {
            $data = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json(['Error' => 'Cette valeur: '.$attributes['name']. ' est incorrecte pour la colonne RoleName ',
                'Status' => $data['status']
            ]);
        }

        return response()->json($data, $data['status']);
    }
    #endregion
    #region Private Methods
    private function findById($id)
    {
        return $this->roleRepository->find($id);
    }
    #endregion
}
