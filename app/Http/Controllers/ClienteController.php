<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Monolog\DateTimeImmutable;

class ClienteController extends Controller
{
    //
    public function crearCliente(Request $request)
    {
        $data = $request->json()->all();
        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];
        $direccion = $data['direccion'];
        $telefono = $data['telefono'];
        $email = $data['email'];
        $password = $data['password'];

        $cliente = new Cliente();
        $cliente->nombres= $nombres;
        $cliente->apellidos= $nombres;
        $cliente->direccion = $direccion;
        $cliente->telefono = $telefono;
        $cliente->email = $email;
        $cliente->password = Hash::make($password);

        $cliente->save();

        return response()->json(['message' => $cliente->id], 200);


    }

    public function listarClientes()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    public function obtenerClientePorId($id, Request $request)
    {
        $cliente = Cliente::find($id);
        return response()->json($cliente);

    }

    public function eliminarCliente($id, Request $request)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            // Producto no encontrado, devuelve una respuesta con código 404
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        try {
            $cliente->delete();
            // Producto eliminado correctamente, devuelve una respuesta con código 200
            return response()->json(['message' => "Cliente eliminado"], 200);
        } catch (\Exception $e) {
            // Error al eliminar el producto, devuelve una respuesta con código 500
            return response()->json(['message' => 'Error al eliminar el cliente'], 500);
        }
    }


    public function login(Request $request)
    {
        $data = $request->json()->all();
        $email = $data['email'];
        $password = $data['password'];

        // Buscar empleado por correo electrónico y contraseña
        $empleado = Cliente::where('email', $email)->first();

        if (!isset($password) || !isset($password)) {
            return response()->json(['message' => 'Autenticación inválida'], 401);
        }

        //dd($password);
        if ($empleado && password_verify($password, $empleado->password)) {
            // Autenticación válida
            //return redirect()->route('empleado.auth')->with('empleado', $empleado);
            $token = $this->generarToken($empleado);
            return response()->json(['token' => $token->toString(),
           'userdata' => $empleado         
        ]);


        } else {
            // dd($empleado);
            //dd($password);
            // Autenticación inválida
            return response()->json(['message' => 'Autenticación inválida'], 401);
        }
    }


    public function generarToken(Cliente $cliente)
    {

        // Obtén una clave segura para la firma del token (puede estar en tu archivo .env)
        $jwtKey = 'asdasdasd';

        // Crea un objeto Lcobucci\JWT\Signer\Key a partir de la clave
        $key = InMemory::plainText($jwtKey);

        // Crear un objeto DateTimeImmutable para la expiración
        $expiration = new DateTimeImmutable(false);
        $expiration = $expiration->modify('+1 hour'); // Agregar 1 hora a la fecha actual



        $config = Configuration::forSymmetricSigner(new Sha256(), $key);



        // Construir el token
        $token = $config->builder()
            ->issuedBy('https://miapp.com') // Emisor del token
            ->expiresAt($expiration) // Tiempo de expiración en segundos (1 hora)
            ->withClaim('id', $cliente->id) // Agregar un claim personalizado
            ->getToken($config->signer(), $config->signingKey());

        // Retornar el token como respuesta
        return $token;
    }


}