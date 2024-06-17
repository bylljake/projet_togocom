<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Resources\V1\Equipement\EquipementsCollection;
use App\Http\Resources\V1\Equipement\EquipementsResource;
use App\Models\Equipements;
use App\Repositories\EquipementsRepository;
use Exception;
use Illuminate\Http\Request;

/**
 * @Equipements class
 * @Member of EquipementsService
 */
class EquipementsService
{
    #regin Declarations
    private $equipementsRepository;
    #endregion

    #region Constructor
    /**
     * @EquipementsService Constructor
     * @return void
     */
    public function __construct(EquipementsRepository $equipementsRepository)
    {
        $this->equipementsRepository = $equipementsRepository;
    }
    #endregion

    #region Save Equipements
    /**
     * Save record in the database.
     * @param $request.
     * @return entity from the database.
     */
    public function save(Request $request)
    {
        $equipementsData =  $request->only([
            'name',
            'description',
            'images',
            'type',
            'quantity',
            'sites_id'
        ]);
        if ($request->hasFile('images')) {
            $imageData = base64_encode(file_get_contents($equipementsData['images']));
            $existingImage = Equipements::where('images', $imageData)->first(); // Méthode hypothétique pour trouver une image similaire

            if ($existingImage) {
                // Une image similaire existe déjà, retourner un message d'erreur ou prendre une autre action appropriée
                return response()->json(['message' => 'Cette image existe déjà.', 'status' => 400]);
            }else{
                $equipementsData['images'] = $imageData;

            }

            }
        $equipements = $this->equipementsRepository->create($equipementsData);
         return $equipements;
    }
    #endregion

    #region Find Equipements
    /**
     * Get Equipements by given the id.
     *
     * @param $id
     * @return the Equipements
     */
    public function getById($id)
    {
        try {
            $Equipements = ['status' => 200];
            $Equipements['data'] = $this->findById($id);
            if (is_null($Equipements['data'])) {
                return response()->json(['message' => "Catégorie n'existe pas"], 404);
            }
        } catch (Exception $e) {
            throw new ApiException('Valeur introuvable: ' . $e->getMessage(), 500);
        }
        $data = new EquipementsResource($Equipements['data']);

        return response()->json($data, $Equipements['status']);
    }
    #endregion

    #region Get all Equipement
    /**
     * Get all Equipement.
     * @return a collection of Equipement.
     */
    public function getAllEquipement()
    {
        return new EquipementsCollection($this->equipementsRepository->getAll());
    }
    #endregion

    #region Update Equipements
    /**
     * Update the Equipements for the giving $id.
     * @param Request $request
     * @param $id
     * @return the updated Equipements.
     */
    public function updateEquipements(Request $request, $id)
    {
        $data = ['status' => 200, "message" => "Catégorie actualisé avec succès."];
        try {
            $Equipements = $this->findById($id);
            if (is_null($Equipements)) {
                return response()->json(['message' => 'Catégorie n\'existe pas', 'status' => 404]);
            }
            $EquipementsData = $request->only([
                'Equipements_name',
                'description',
            ]);
            $this->equipementsRepository->update($EquipementsData, $id);

        } catch (Exception $e) {
            $data = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json([
                'Error' => 'Cette valeur: ' . $EquipementsData['id'] . ' est incorrecte pour la colonne demande de messe ',
                'Status' => $data['status']
            ]);
        }

        return response()->json($data, $data['status']);
    }
    #endregion

    #region Delete Equipements
    /**
     * Delete the specified Equipements from the database.
     * @param $id
     * @return the success message deleted Equipements.
     */
    public function delete($id)
    {
        $data = ['status' => 200, "message" => "Catégorie supprimé avec succes."];
        try {
            $Equipements = $this->findById($id);
            if (is_null($Equipements)) {
                return response()->json(['message' => 'Catégorie n\'existe pas', 'status' => 404]);
            }
            } catch (Exception $e) {
                $Equipements = [
                    'status' => 500,
                    'error' => $e->getMessage()
                ];
            }

        $this->equipementsRepository->delete($id);
        return response()->json($data);
    }
    #endregion

    #region Private Methods
    private function findById($id)
    {
        return $this->equipementsRepository->find($id);
    }
    #endregion
}
