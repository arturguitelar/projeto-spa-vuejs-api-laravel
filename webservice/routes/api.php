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

// TESTES
Route::get('/testes', function () {
    // $user = User::find(1);
    // $user2 = User::find(2);

    // dd(Conteudo::all());

    // // Deletar TODOS os conteúdos
    // $conteudos = Conteudo::all();
    // foreach ($conteudos as $key => $value) {
    //     $value->delete();
    // }

    // // Criar conteudo
    // $user->conteudos()->create([
    //     'titulo' => 'Conteúdo 3',
    //     'texto' => 'Aqui um texto',
    //     'imagem' => 'url da imagem',
    //     'link' => 'Link',
    //     'data' => date('Y-m-d')
    // ]);
    // return $user->conteudos;

    // // Add amigo
    // $user->amigos()->attach($user2->id);
    // Remove amigo
    // $user->amigos()->detach($user2->id);

    // // Método do Laravel para add e remover amigo
    // $user->amigos()->toggle($user2->id);

    // // listando amigos
    // return $user->amigos;

    // // Add curtidas
    // $conteudo = Conteudo::find(1);
    // $user->curtidas()->toggle($conteudo->id);

    // // listando curtidas do conteúdo
    // return $conteudo->curtidas;

    // // contando quantidade de conteudos
    // return $conteudo->curtidas()->count();

    // // Comentários
    // $conteudo = Conteudo::find(16);
    // $user->comentarios()->create([
    //     'conteudo_id' => $conteudo->id,
    //     'texto' => 'Aqui um comentário',
    //     'data' => date('Y-m-d H:i:s')
    // ]);
    // // $user2->comentarios()->create([
    // //     'conteudo_id' => $conteudo->id,
    // //     'texto' => 'Aqui um comentário do usuário 2',
    // //     'data' => date('Y-m-d')
    // // ]);
    // return $conteudo->comentarios;

    // // Simulando comportamento da listagem da Homepage
    // $user = User::find(1);
    // $amigos = $user->amigos()->pluck('id');
    // $amigos->push($user->id);
    // $conteudos = Conteudo::whereIn('user_id', $amigos)->with('user')->orderBy('data', 'DESC')->paginate(5);

    // dd($conteudos);
});
