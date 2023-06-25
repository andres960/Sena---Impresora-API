<?php

namespace App\Http\Controllers;

use App\Models\ImpresoraSeguimiento;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImpresoraSeguimientoController extends Controller
{
    //

    public function crearSeguimiento(Request $request)
    {
        $data = $request->json()->all();
        $id_administrador = $data['id_administrador'];
        $id_impresora = $data['id_impresora'];
        $descripcion = $data['descripcion'];

        $seguimiento = new ImpresoraSeguimiento();

        $seguimiento->id_administrador = $id_administrador;
        $seguimiento->id_impresora = $id_impresora;
        $seguimiento->Descripcion = $descripcion;

        $seguimiento->save();

        return response()->json(['message' => "Registro de seguimiento impresion creado ID: " . $seguimiento->id], 200);


    }


    //LISTANDO SEGUIMIENTOS POR ID
    public function listarSeguimientos($id_impresora, Request $request)
    {

        $seguimientos = ImpresoraSeguimiento::where('id_impresora', $id_impresora)->get();

        return response()->json($seguimientos);

    }




}