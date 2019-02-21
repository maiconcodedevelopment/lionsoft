<?php

use Illuminate\Http\Request;
use App\User;
use App\Posts;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'user'], function () {
    Route::post('insert', function (Request $request) {

        $user = User::create($request->all());
        return response()->json($user);
    });

    Route::group(['prefix' => 'post'], function () {
        Route::post("add", function (Request $request) {

            $iduser = $request->get("iduser");
            $idpost = $request->get("idpost");
            $title = (string)$request->get("title");
            $description = (string)$request->get("description");

            $post = User::find((int) $iduser)->posts()->find((int) $idpost);

            if(!is_null($post)){
                $post->title = $title;
                $post->description = $description;

                $post->save();
                return response()->json($post);
            }

            $post = User::find((int)$iduser)->posts()->create(["title" => $title, "description" => $description]);

            return response()->json($post);
        });

        Route::delete("delete/{posts}",function(Posts $posts){
            $posts->delete();
            return response()->json($posts);
        });

        Route::get("all/{id}", function ($id) {

            $posts = User::find((int)$id)->posts()->get()->all();

            return response()->json($posts);
        });
    });
});