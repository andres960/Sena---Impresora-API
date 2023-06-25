<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//ADMIN ACCESO
Route::post('auth/administrador/login', [App\Http\Controllers\AdministradorController::class, 'login'])->name('admin.login');
Route::post('auth/administrador/register', [App\Http\Controllers\AdministradorController::class, 'register']);
Route::get('auth/administrador/autenticar', [App\Http\Controllers\AdministradorController::class, 'generarToken'])->name('admin.auth');

//CLIENTE ACCESO

Route::post('auth/cliente/login', [App\Http\Controllers\ClienteController::class, 'login'])->name('cliente.login');
Route::post('auth/cliente/register', [App\Http\Controllers\ClienteController::class, 'crearCliente']);
Route::get('auth/cliente/autenticar', [App\Http\Controllers\ClienteController::class, 'generarToken'])->name('cliente.auth');


//IMPRESORAS
Route::post('impresoras/', [App\Http\Controllers\ImpresoraController::class, 'crearImpresora']);
Route::put('impresoras/{id}', [App\Http\Controllers\ImpresoraController::class, 'actualizarImpresora']);
Route::get('impresoras/{id}', [App\Http\Controllers\ImpresoraController::class, 'obtenerImpresionPorId']);


//IMPRESORAS - SEGUIMIENTOS
Route::post('impresoras/seguimientos/', [App\Http\Controllers\ImpresoraSeguimientoController::class, 'crearSeguimiento']);
Route::get('impresoras/seguimientos/{id}', [App\Http\Controllers\ImpresoraSeguimientoController::class, 'listarSeguimientos']);


//CLIENTES
Route::post('clientes/', [App\Http\Controllers\ClienteController::class, 'crearCliente']);
Route::get('clientes/', [App\Http\Controllers\ClienteController::class, 'listarClientes']);
Route::get('clientes/{id}', [App\Http\Controllers\ClienteController::class, 'obtenerClientePorId']);
Route::delete('clientes/{id}', [App\Http\Controllers\ClienteController::class, 'eliminarCliente']);


//VENTAS
Route::post('ventas/', [App\Http\Controllers\VentaController::class, 'crearVenta']);

