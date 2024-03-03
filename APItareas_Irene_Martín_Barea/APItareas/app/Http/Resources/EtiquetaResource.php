<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EtiquetaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //Es lo que tiene que aparecer al hacer el get
        return [
            'id' => $this->id,
            'nombre' => 'Nombre: ' .$this->nombre
        ];
    }
}
