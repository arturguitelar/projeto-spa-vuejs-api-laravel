<?php
use App\User;
use App\Conteudo;
use App\Comentario;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// USER
Route::post('/cadastro', 'UsuarioController@cadastro');

Route::post('/login', 'UsuarioController@login');

Route::middleware('auth:api')->put('/perfil', 'UsuarioController@perfil');

// CONTEUDO
Route::middleware('auth:api')->post('/conteudo/adicionar', 'ConteudoController@adicionar');
Route::middleware('auth:api')->get('/conteudo/listar', 'ConteudoController@listar');

// CURTIR
Route::middleware('auth:api')->put('/conteudo/curtir/{id}', 'ConteudoController@curtir');
Route::middleware('auth:api')->put('/conteudo/curtirpagina/{id}', 'ConteudoController@curtirpagina');

// COMENTAR
Route::middleware('auth:api')->put('/conteudo/comentar/{id}', 'ConteudoController@comentar');
Route::middleware('auth:api')->put('/conteudo/comentarpagina/{id}', 'ConteudoController@comentarpagina');

// PAGINAS
Route::middleware('auth:api')->get('/conteudo/pagina/listar/{id}', 'ConteudoController@pagina');

// AMIGO
Route::middleware('auth:api')->post('/usuario/amigo', 'UsuarioController@amigo');
Route::middleware('auth:api')->get('/usuario/listaamigos', 'UsuarioController@listaamigos');
Route::middleware('auth:api')->get('/usuario/listaamigospagina/{id}', 'UsuarioController@listaamigospagina');
