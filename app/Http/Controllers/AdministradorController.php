<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Dotenv\Exception\ValidationException;
use Dotenv\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Monolog\DateTimeImmutable;

class AdministradorController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->json()->all();
        $email = $data['email'];
        $password = $data['password'];

        // Buscar empleado por correo electrónico y contraseña
        $empleado = Administrador::where('email', $email)->first();

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


    public function register(Request $request)
    {
        // Validar los datos de entrada
        // Validar los datos de entrada
       
        // Crear un nuevo empleado
        $administrador = new Administrador();
        $administrador->nombres = $request->input('nombres');
        $administrador->apellidos = $request->input('apellidos');
        $administrador->telefono = $request->input('telefono');
        $administrador->email = $request->input('email');
        $administrador->password = Hash::make($request->input('password'));
        $administrador->save();

        return response()->json(['message' => 'Registro exitoso'], 201);
    }


    public function generarToken(Administrador $empleado)
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
            ->withClaim('id', $empleado->id) // Agregar un claim personalizado
            ->getToken($config->signer(), $config->signingKey());

        // Retornar el token como respuesta
        return $token;
    }



    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message' => 'Datos incorrectos'], 422));
    }
}
