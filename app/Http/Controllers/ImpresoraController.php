<?php

namespace App\Http\Controllers;

use App\Models\Impresora;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImpresoraController extends Controller
{
    //CREANDO IMPRESORA

    public function crearImpresora(Request $request)
    {
        $data = $request->json()->all();
        $id_encargado = $data['id_encargado'];
        $id_cliente = $data['id_cliente'];
        $modelo = $data['modelo'];
        $marca = $data['marca'];
        $nroSerie = $data['nroserie'];
        $conectividad = $data['conectividad'];
        $resolucion = $data['resolucion'];
        $estado_tinta = $data['estado_tinta'];
        $estado_impresora = $data['estado_impresora'];
        $estado_taller = $data['estado_taller'];


        $impresora = new Impresora();
        $impresora->id_encargado = $id_encargado;
        $impresora->id_cliente = $id_cliente;
        $impresora->Modelo = $modelo;
        $impresora->Marca = $marca;
        $impresora->NroSerie = $nroSerie;
        $impresora->Conectividad = $conectividad;
        $impresora->Resolucion = $resolucion;
        $impresora->Estado_tinta = $estado_tinta;
        $impresora->Estado_impresora = $estado_impresora;
        $impresora->Estado_taller = $estado_taller;

        $impresora->save();

        return response()->json(['message' => "Registro de impresion creado" . $impresora->id], 200);


    }
    

    public function actualizarImpresora($id, Request $request)
    {


        $data = $request->json()->all();
        $id_encargado = isset($data['id_encargado']) ? $data['id_encargado'] : null;
        $id_cliente = isset($data['id_cliente']) ? $data['id_cliente'] : null;
        $modelo = isset($data['modelo']) ? $data['modelo'] : null;
        $marca = isset($data['marca']) ? $data['marca'] : null;
        $nroSerie = isset($data['nroserie']) ? $data['nroserie'] : null;
        $conectividad = isset($data['conectividad']) ? $data['conectividad'] : null;
        $resolucion = isset($data['resolucion']) ? $data['resolucion'] : null;
        $estado_tinta = isset($data['estado_tinta']) ? $data['estado_tinta'] : null;
        $estado_impresora = isset($data['estado_impresora']) ? $data['estado_impresora'] : null;
        $estado_taller = isset($data['estado_taller']) ? $data['estado_taller'] : null;


        $impresora = Impresora::find($id);
        $impresora->id_encargado = $id_encargado !== null ? $id_encargado : $impresora->id_encargado;
        $impresora->id_cliente = $id_cliente !== null ? $id_cliente : $impresora->id_cliente;
        $impresora->Modelo = $modelo !== null ? $modelo : $impresora->Modelo;
        $impresora->Marca = $marca !== null ? $marca : $impresora->Marca;
        $impresora->NroSerie = $nroSerie !== null ? $nroSerie : $impresora->NroSerie;
        $impresora->Conectividad = $conectividad !== null ? $conectividad : $impresora->Conectividad;
        $impresora->Resolucion = $resolucion !== null ? $resolucion : $impresora->Resolucion;
        $impresora->Estado_tinta = $estado_tinta !== null ? $estado_tinta : $impresora->Estado_tinta;
        $impresora->Estado_impresora = $estado_impresora !== null ? $estado_impresora : $impresora->Estado_impresora;
        $impresora->Estado_taller = $estado_taller !== null ? $estado_taller : $impresora->Estado_taller;
        

        $impresora->save();
        


        return response()->json(['message' => "Registro de impresion actualizado" . $impresora], 200);



    }


    public function obtenerImpresionPorId(Request $request, $id)
    {
        $producto = Impresora::find($id);
        return response()->json($producto);

    }


    

    


}