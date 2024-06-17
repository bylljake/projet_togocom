<?php

namespace App\Http\Controllers\Api\v1;


use App\Services\SitesService;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Sites\StoreSitesRequest;
use App\Http\Requests\v1\Sites\UpdateSitesRequest;
use App\Models\Sites;

class SitesController extends Controller
{
    #region Declarations
    private $sitesService;
    #endregion

    #region Cnstructor
    public function __construct(SitesService $sitesService)
    {
        $this->sitesService = $sitesService;
    }
    #endregion

    #region Display all Categories
    /**
     * Display a listing of the resource.
     * @return collection of categories.
     */
    public function index()
    {
        return $this->sitesService->getAllSites();
    }


    /**
     * Store a newly created resource in the database.
     */
    public function store(StoreSitesRequest $request)
    {
        $result = [
            'status' => 200,
            "message" => "Sites crée avec succès."
        ];
        $result['data'] = $this->sitesService->save($request);

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource for the given ID.
     */
    public function show(string $id)
    {
        return $this->sitesService->getById($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in database for the given ID.
     */
    public function update(UpdateSitesRequest $request, string $id)
    {
        return $this->sitesService->updateSites($request, $id);
    }

    /**
     * Remove the specified resource from database for the given ID.
     */
    public function destroy(string $id)
    {
        return  $this->sitesService->delete($id);
    }
}
