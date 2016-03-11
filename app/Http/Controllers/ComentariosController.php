<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ComentariosController extends Controller
{
    public function store($post,Request $request){
        $comentario = new Comentario();
        $comentario->id_post = $post->id_post;
        $comentario->comentario = $request->comentario;
        $comentario->fh_publicacion = Carbon::now();
        $comentario->autor = 1;
        $comentario->save();
        return response($comentario->id_comentario);
    }
}
