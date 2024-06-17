<?php

namespace App\Http\Resources\v1\sites;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SitesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'site_id'   => $this->id,
            'name' => $this->name,
            'location'  => $this->location,
            'superficie'  => $this->superficie,
            'date_of_create'  => $this->date_of_create,
            'date_of_service'  => $this->date_of_service,
            'images'  => $this->images,
            'createdAt'    => Carbon::parse($this->created_at)->format('d-m-Y H:i:s'),
            'updatedAt'    => Carbon::parse($this->updated_at)->format('d-m-Y H:i:s')
        ];
    }
}
