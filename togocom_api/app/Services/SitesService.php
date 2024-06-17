<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Http\Resources\v1\sites\SitesResource;
use App\Http\Resources\v1\sites\SitesCollection;
use App\Models\sites;
use App\Repositories\sitesRepository;
use Exception;
use Illuminate\Http\Request;

/**
 * @sites class
 * @Member of sitesService
 */
class sitesService
{
    #regin Declarations
    private $sitesRepository;
    #endregion

    #region Constructor
    /**
     * @sitesService Constructor
     * @return void
     */
    public function __construct(sitesRepository $sitesRepository)
    {
        $this->sitesRepository = $sitesRepository;
    }
    #endregion

    #region Save sites
    /**
     * Save record in the database.
     * @param $request.
     * @return entity from the database.
     */
    public function save(Request $request)
    {
        $sitesData =  $request->only([
            'name',
            'location',
            'description',
            'superficie',
            'date_of_create',
            'date_of_service',
            'images'
        ]);

        if ($request->hasFile('images')) {
            $imageData = base64_encode(file_get_contents($sitesData['images']));
            $existingImage = Sites::where('images', $imageData)->first(); // Méthode hypothétique pour trouver une image similaire

            if ($existingImage) {
                // Une image similaire existe déjà, retourner un message d'erreur ou prendre une autre action appropriée
                return response()->json(['message' => 'Cette image existe déjà.', 'status' => 400]);
            }else{
                $sitesData['images'] = $imageData;

            }

            }
        $sites = $this->sitesRepository->create($sitesData);
         return $sites;
    }
    #endregion

    #region Find sites
    /**
     * Get sites by given the id.
     *
     * @param $id
     * @return the sites
     */
    public function getById($id)
    {
        try {
            $sites = ['status' => 200];
            $sites['data'] = $this->findById($id);
            if (is_null($sites['data'])) {
                return response()->json(['message' => "sites n'existe pas"], 404);
            }
        } catch (Exception $e) {
            throw new ApiException('Valeur introuvable: ' . $e->getMessage(), 500);
        }
        $data = new SitesResource($sites['data']);

        return response()->json($data, $sites['status']);
    }
    #endregion

    #region Get all Sites
    /**
     * Get all Sites.
     * @return a collection of Sites.
     */
    public function getAllSites()
    {
        return new SitesCollection($this->sitesRepository->getAll());
    }
    #endregion

    #region Update sites
    /**
     * Update the sites for the giving $id.
     * @param Request $request
     * @param $id
     * @return the updated sites.
     */
    public function updatesites(Request $request, $id)
    {
        $data = ['status' => 200, "message" => "Site actualisé avec succès."];
        try {
            $sites = $this->findById($id);
            if (is_null($sites)) {
                return response()->json(['message' => 'Site n\'existe pas', 'status' => 404]);
            }
            $sitesData = $request->only([
                'name',
            'location',
            'description',
            'superficie',
            'date_of_create',
            'date_of_service',
            'images'
            ]);
            $this->sitesRepository->update($sitesData, $id);

        } catch (Exception $e) {
            $data = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json([
                'Error' => 'Cette valeur: ' . $sitesData['id'] . ' est incorrecte pour la colonne',
                'Status' => $data['status']
            ]);
        }

        return response()->json($data, $data['status']);
    }
    #endregion

    #region Delete sites
    /**
     * Delete the specified sites from the database.
     * @param $id
     * @return the success message deleted sites.
     */
    public function delete($id)
    {
        $data = ['status' => 200, "message" => "FRM supprimé avec succes."];
        try {
            $sites = $this->findById($id);
            if (is_null($sites)) {
                return response()->json(['message' => 'FRM n\'existe pas', 'status' => 404]);
            }
            } catch (Exception $e) {
                $sites = [
                    'status' => 500,
                    'error' => $e->getMessage()
                ];
            }

        $this->sitesRepository->delete($id);
        return response()->json($data);
    }
    #endregion

    #region Private Methods
    private function findById($id)
    {
        return $this->sitesRepository->find($id);
    }
    #endregion
}
