<?php

namespace App\Http\Controllers\Api\v1;


use App\Services\EquipementsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\equipement\StoreEquipementsRequest;
use App\Http\Requests\v1\equipement\UpdateEquipementsRequest;
use App\Models\Equipements;

class EquipementsController extends Controller
{
    #region Declarations
    private $equipementsService;
    #endregion

    #region Cnstructor
    public function __construct(EquipementsService $equipementsService)
    {
        $this->equipementsService = $equipementsService;
    }
    #endregion

    #region Display all Categories
    /**
     * Display a listing of the resource.
     * @return collection of categories.
     */
    public function index()
    {
        return $this->equipementsService->getAllEquipement();
    }


    /**
     * Store a newly created resource in the database.
     */
    public function store(StoreEquipementsRequest $request)
    {
        $result = [
            'status' => 200,
            "message" => "Equipements crée avec succès."
        ];
        $result['data'] = $this->equipementsService->save($request);

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource for the given ID.
     */
    public function show(string $id)
    {
        return $this->equipementsService->getById($id);
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
    public function update(UpdateEquipementsRequest $request, string $id)
    {
        return $this->equipementsService->updateEquipements($request, $id);
    }

    /**
     * Remove the specified resource from database for the given ID.
     */
    public function destroy(string $id)
    {
        return  $this->equipementsService->delete($id);
    }
}
