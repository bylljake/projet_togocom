<?php

namespace App\Http\Resources\v1\equipement;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipementsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'equipement_id'   => $this->id,
            'name' => $this->name,
            'type'  => $this->type,
            'quantity'  => $this->quantity,
            'description'  => $this->description,
            'images'  => $this->images,
            'createdAt'    => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'updatedAt'    => Carbon::parse($this->updated_at)->format('d-m-Y H:i:s')
        ];
    }
}
