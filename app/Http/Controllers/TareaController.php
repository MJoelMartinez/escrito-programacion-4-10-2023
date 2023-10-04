<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TareaController extends Controller
{
    public function BloquearTablaASoloEscritura()
    {
        DB::raw('LOCK TABLE tareas WRITE');
    }

    public function DesbloquearTablas()
    {
        DB::raw('UNLOCK TABLES');
    }

    public function Crear(Request $request)
    {
        $validation = Validator::make($request->all(),
        [
            "titulo" => "required|min:2|max:40",
            "contenido" => "required|min:2|max:100",
            "estado" => "required|min:2|alpha|max:20",
            "autor" => "required|min:2|max:30"
        ]);

        if($validation->fails())
            return response($validation->errors(), 401);

        $this->BloquearTablaASoloEscritura();
        DB::beginTransaction();

        Tarea::create([
            "titulo" => $request -> input("titulo"),
            "contenido" => $request -> input("contenido"),
            "estado" => $request -> input("estado"),
            "autor" => $request -> input("autor")
        ]);

        DB::commit();
        $this->DesbloquearTablas();

        return [ "mensaje" => "Tarea creada correctamente."];
    }

    public function ListarTodos(Request $request)
    {
        return Tarea::all();
    }

    public function ListarUno(Request $request, $id)
    {
        return Tarea::FindOrFail($id);
    }

    public function Modificar(Request $request, $id)
    {
        $tarea = Tarea::FindOrFail($id)->get();

        $this->BloquearTablaASoloEscritura();
        DB::beginTransaction();

        $tarea->titulo = $request->input("titulo", $tarea->titulo);
        $tarea->contenido = $request->input("contenido", $tarea->contenido);
        $tarea->estado = $request->input("estado", $tarea->estado);
        $tarea->autor = $request->input("autor", $tarea->autor);

        $tarea->save();

        DB::commit();
        $this->DesbloquearTablas();

        return $tarea;
    }

    public function Eliminar(Request $request, $id)
    {
        $tarea = Tarea::FindOrFail($id);

        $this->BloquearTablaASoloEscritura();
        DB::beginTransaction();

        $tarea->delete();

        DB::commit();
        $this->DesbloquearTablas();

        return [ "mensaje" => "Tarea eliminada correctamente." ];
    }
}
