<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;


class ProductoController extends Controller
{
    public function crearProducto(Request $request)
    {
        $data = $request->json()->all();

        if (isset($data['id_categoria'])) {
            // El parámetro "id_categoria" está presente en $data
            $id_categoria = $data['id_categoria'];
        } else {
            // El parámetro "id_categoria" no está presente en $data
            $id_categoria = 2; // Valor por defecto
        }


        $nombre = $data['nombre'];
        $codigo = $data['codigo'];
        $descripcion = $data['descripcion'];
        $precio = $data['precio'];
        $cantidad_stock = $data['cantidad_stock'];



        $producto = new Producto();
        $producto->id_categoria = $id_categoria;
        $producto->nombre = $nombre;
        $producto->codigo = $codigo;
        $producto->descripcion = $descripcion;
        $producto->precio = $precio;
        $producto->cantidad_stock = $cantidad_stock;

        $producto->save();

        return response()->json(['message' => $producto->id], 200);




    }


    public function actualizarProducto($id, Request $request)
    {

        $data = $request->json()->all();

        $nombre = $data['nombre'];
        $codigo = $data['codigo'];
        $descripcion = $data['descripcion'];
        $precio = $data['precio'];
        $cantidad_stock = $data['cantidad_stock'];

        $producto = Producto::find($id);

        $producto->nombre = $nombre;
        $producto->codigo = $codigo;
        $producto->descripcion = $descripcion;
        $producto->precio = $precio;
        $producto->cantidad_stock = $cantidad_stock;

        $producto->save();

        return response()->json(['message' => $producto->id], 200);

    }

    public function eliminarProducto($id, Request $request)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            // Producto no encontrado, devuelve una respuesta con código 404
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
    
        try {
            $producto->delete();
            // Producto eliminado correctamente, devuelve una respuesta con código 200
            return response()->json(['message' => "Producto eliminado"], 200);
        } catch (\Exception $e) {
            // Error al eliminar el producto, devuelve una respuesta con código 500
            return response()->json(['message' => 'Error al eliminar el producto'], 500);
        }
    }

    public function listarProductos()
    {
        $productos = Producto::all();

        // Modificar cada producto para limitar los campos "nombre" y "descripcion" a 10 caracteres
        $productos = $productos->map(function ($producto) {
            $producto->nombre = substr($producto->nombre, 0, 10);
            $producto->descripcion = substr($producto->descripcion, 0, 10);
            return $producto;
        });
    
        return response()->json($productos);
    }

    public function obtenerProductoPorId(Request $request, $id)
    {
        $producto = Producto::find($id);
        return response()->json($producto);

    }

   

    public function obtenerProductoPorCodigo(Request $request, $codigo)
    {

    }



}