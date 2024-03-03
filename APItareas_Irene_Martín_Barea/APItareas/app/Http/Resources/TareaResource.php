<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaResource extends JsonResource
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
            'Titulo' => 'Titulo: '. $this->titulo,
            'descripcion' => 'Desc: '. $this->descripcion,
            //'etiquetas' => $this->etiquetas
            //Si hay etiquetas muestra los nombres, de lo contrario aparece un mensaje
            'etiquetas' => $this->etiquetas != null && $this->etiquetas->isNotEmpty() ? 
                           $this->etiquetas->pluck('nombre') : 'No hay etiquetas asociadas'
        ];
    }
}
