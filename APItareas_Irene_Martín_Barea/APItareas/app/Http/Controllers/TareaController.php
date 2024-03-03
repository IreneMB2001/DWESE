<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResource
    {
        //Obtener todos los registros de tareas
        $tareas = Tarea::all();
        //Convierte las tareas recuperadas en una colección utilizando el formato TareaResource
        return TareaResource::collection($tareas);
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
    public function store(TareaRequest $request):JsonResource
    {
        //Crear una nueva instancia de la clase Tarea
        $tarea=new Tarea();

        //Asignar los valores a los atributos de la tarea desde la solicitud
        $tarea->titulo = $request->titulo;
        $tarea->descripcion = $request->descripcion;

        //Guardar la tarea en la base de datos
        $tarea->save();

        //Asociar la tarea con las etiquetas proporcionadas en la solicitud (si las hay)
        $tarea->etiquetas()->attach($request->etiquetas);

        //Devolver la tarea en una instancia con el formato de TareaResource
        return new TareaResource($tarea);
    }

    /**
     * Display the specified resource.
     */
    public function show($id):JsonResource
    {
        // Encontrar la tarea en la base de datos por su ID
        $tarea = Tarea::find($id);

        // Devolver la tarea en una instancia con el formato de TareaResource
        return new TareaResource($tarea);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TareaRequest $request, $id):JsonResource
    {
        // Encontrar la tarea en la base de datos por su ID
        $tarea = Tarea::find($id);

        //Asignar los valores a los atributos de la tarea desde la solicitud
        $tarea->titulo = $request->titulo;
        $tarea->descripcion = $request->descripcion;

        // Desasociar todas las etiquetas existentes de la tarea
        $tarea->etiquetas()->detach();
    
        // Asociar las nuevas etiquetas proporcionadas en la solicitud
        $tarea->etiquetas()->attach($request->etiquetas);
        // Guardar los cambios en la base de datos
        $tarea->save();
    
        // Devolver la tarea en una instancia con el formato de TareaResource
        return new TareaResource($tarea);           
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrar la tarea en la base de datos por su ID
        $tarea = Tarea::find($id);

        // Verificar si la tarea fue encontrada
        if ($tarea){
            // Eliminar la tarea de la base de datos
            $tarea->delete();

            //devolver una respuesta JSON de éxito
            return response()->json(['success' => true], 200);
        }else{
            // Si la tarea no fue encontrada, devolver un mensaje de error en formato JSON
            return response()->json(['mensaje' => 'Tarea no encontrada'], 404);
        }
    }
}
