<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\EtiquetaRequest;
use App\Http\Resources\EtiquetaResource;

class EtiquetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener todos los registros de etiquetas
        $etiquetas = Etiqueta::all();
        //Convierte las etiquetas recuperadas en una colección utilizando el formato EtiquetaResource
        return EtiquetaResource::collection($etiquetas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EtiquetaRequest $request):JsonResource
    {
        //Crear una nueva instancia de la clase Etiqueta
        $etiqueta=new Etiqueta();

        //Asignar los valores a los atributos de la etiqueta desde la solicitud
        $etiqueta->nombre = $request->nombre;

        //Guardar la etiqueta en la base de datos
        $etiqueta->save();

        // Devolver la etiqueta en una instancia con el formato de EtiquetaResource
        return new EtiquetaResource($etiqueta);
    }

    /**
     * Display the specified resource.
     */
    public function show($id):JsonResource
    {
        // Encontrar la etiqueta en la base de datos por su ID
        $etiqueta = Etiqueta::find($id);

        // Devolver la etiqueta en una instancia con el formato de EtiquetaResource
        return new EtiquetaResource($etiqueta);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etiqueta $etiqueta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EtiquetaRequest $request, $id):JsonResource
    {
        // Encontrar la etiqueta en la base de datos por su ID
        $etiqueta = Etiqueta::find($id);

        //Asignar los valores a los atributos de la etiqueta desde la solicitud
        $etiqueta->nombre = $request->nombre;

        //Guardar la etiqueta en la base de datos
        $etiqueta->save();

        // Devolver la etiqueta en una instancia con el formato de EtiquetaResource
        return new EtiquetaResource($etiqueta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrar la etiqueta en la base de datos por su ID
        $etiqueta = Etiqueta::find($id);

        // Verificar si la etiqueta fue encontrada
        if ($etiqueta){
            // Eliminar la etiqueta de la base de datos
            $etiqueta->delete();

            //devolver una respuesta JSON de éxito
            return response()->json(['success' => true], 200);
        }else{
            // Si la etiqueta no fue encontrada, devolver un mensaje de error en formato JSON
            return response()->json(['mensaje' => 'Etiqueta no encontrada'], 404);
        }
    }
}
