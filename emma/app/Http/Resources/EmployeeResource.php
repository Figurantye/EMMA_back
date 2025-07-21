<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'hire_date' => $this->hire_date,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
            'phone' => $this->phone,
            'city' => $this->city,
            'description' => $this->description,
            'absence' => $this->absence,
            'employment_status' => $this->employment_status,

            // Relações
            'position' => new PositionResource($this->whenLoaded('position')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),

            // Extras se desejar no futuro
            // 'labor_rights' => LaborRightResource::collection($this->whenLoaded('laborRights')),
            // 'documents' => DocumentResource::collection($this->whenLoaded('documents')),
        ];
    }
}
